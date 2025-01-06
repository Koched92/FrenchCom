<template>
  <v-layout class="rounded rounded-md">
    <v-app :theme="theme">

      <SideMenu @category-selected="handleCategorySelection" />

      <v-app-bar title="French'COM" class="px-3" :order="order">
        <v-spacer></v-spacer>
        <v-btn :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'" slim
          @click="onClick"></v-btn>
        <template v-slot:append>
          <v-switch v-model="order" false-value="-1" true-value="0" hide-details inset></v-switch>
        </template>
      </v-app-bar>

      <v-main>
        <v-container>
          <MainContent ref="mainContent" />
          <SpeedDial />
        </v-container>
      </v-main>

    </v-app>
  </v-layout>
</template>


<script>
import { ref } from 'vue'

import SideMenu from './sideMenu.vue';
import MainContent from './MainContent.vue';
import SpeedDial from './SpeedDial.vue';

export default {
  data() {
    return {
      order: -1,
      theme,
      onClick
    }
  },
  components: {
    SideMenu,
    MainContent,
    SpeedDial,
  },
  methods: {
    handleCategorySelection(categoryId) {
      this.$refs.mainContent.getLinksByCategory(categoryId)
    }
  }
}

const theme = ref('dark')

function onClick() {
  theme.value = theme.value === 'light' ? 'dark' : 'light'
}
</script>

<style>

</style>