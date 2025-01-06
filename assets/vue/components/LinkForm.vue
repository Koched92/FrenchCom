<template>
  <form>
    <v-text-field v-model="state.name" :counter="10" :error-messages="v$.name.$errors.map(e => e.$message)" label="Name"
      required @blur="v$.name.$touch" @input="v$.name.$touch"></v-text-field>

    <v-text-field v-model="state.url" :error-messages="v$.url.$errors.map(e => e.$message)" label="URL" required
      @blur="v$.url.$touch" @input="v$.url.$touch"></v-text-field>

    <v-select v-model="state.select" :error-messages="v$.select.$errors.map(e => e.$message)" :items="CategoryGroups"
      label="Category group" required @blur="v$.select.$touch" @change="v$.select.$touch"
      @update:model-value="selectUpdateHandler"></v-select>

    <v-select v-model="state.select" :error-messages="v$.select.$errors.map(e => e.$message)" :items="Category"
      label="Category" required @blur="v$.select.$touch" @change="v$.select.$touch"></v-select>

    <v-select clearable chips label="Tags" required :items="Tags" multiple variant="outlined"></v-select>

    <v-textarea :error-messages="v$.textarea.$errors.map(e => e.$message)" label="Description" append-icon="mdi-text"
      variant="outlined" required @blur="v$.textarea.$touch" @change="v$.textarea.$touch"></v-textarea>

    <v-checkbox v-model="state.checkbox" :error-messages="v$.checkbox.$errors.map(e => e.$message)"
      label="Do you agree?" required @blur="v$.checkbox.$touch" @change="v$.checkbox.$touch"></v-checkbox>

    <v-btn class="me-4 text-none" append-icon="mdi-send" color="primary" variant="flat" @click="v$.$validate">
      submit
    </v-btn>
    <v-btn @click="clear" append-icon="mdi-restore" class="me-2 text-none" color="warning" variant="tonal">
      clear
    </v-btn>
  </form>
</template>

<script setup>

import { reactive, ref, onMounted } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import axios from 'axios'

const initialState = {
  name: '',
  url: '',
  select: null,
  checkbox: null,
}

const state = reactive({
  ...initialState,
})

const CategoryGroups = ref([])
const Category = ref([])
const Tags = ref([])

const fetchGroups = async () => {
  try {
    const response = await axios.get('/api/category_groups')

    CategoryGroups.value = response.data['hydra:member'].map(group => group.name)

  } catch (error) {
    console.error('Erreur lors du chargement des données:', error)
  }
}
const fetchTags = async () => {
  try {
    const response = await axios.get('/api/tags')

    Tags.value = response.data['hydra:member'].map(group => group.slug)

  } catch (error) {
    console.error('Erreur lors du chargement des données:', error)
  }
}
const selectUpdateHandler = (selectedValue) => {
  console.log(selectedValue);

}
onMounted(() => {
  fetchGroups()
  fetchTags()
})

const rules = {
  name: { required },
  url: { required },
  select: { required },
  textarea: { required },
  items: { required },
  checkbox: { required },
}

const v$ = useVuelidate(rules, state)

function clear() {
  v$.value.$reset()

  for (const [key, value] of Object.entries(initialState)) {
    state[key] = value
  }
}
</script>
<style></style>