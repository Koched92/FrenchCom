<template>
  <v-layout class="rounded rounded-md">
    <v-app :theme="theme">
      <SideMenu @category-selected="handleCategorySelection" />

      <v-app-bar title="French'COM" class="px-3" :order="order">
        <v-spacer></v-spacer>
        <v-btn :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'" slim
          @click="onClick"></v-btn>
        <template v-slot:append>
          <v-switch v-model="order" false-value="0" label="Toggle order" true-value="-1" hide-details inset></v-switch>
        </template>

      </v-app-bar>

      <v-main style="min-height: 300px;">
        <v-container>
          <MainContent ref="mainContent" />
        </v-container>
      </v-main>
    </v-app>
  </v-layout>
</template>


<script>
import { ref } from 'vue'

import SideMenu from './sideMenu.vue';
import MainContent from './MainContent.vue';

export default {
  data() {
    return {
      order: 0,
      theme,
      onClick
    }
  },
  components: {
    SideMenu,
    MainContent
  },
  methods: {
    handleCategorySelection(categoryId) {
      this.$refs.mainContent.getLinksByCategory(categoryId)
    }
  }
}

const theme = ref('light')

function onClick() {
  theme.value = theme.value === 'light' ? 'dark' : 'light'
}
</script>