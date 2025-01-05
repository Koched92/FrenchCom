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
          <div class="speed-dial-container">
            <v-speed-dial transition="slide-y-reverse-transition" open-on-hover="true" location="bottom right"
              direction="top">
              <template v-slot:activator="{ props: activatorProps }">
                <v-fab v-bind="activatorProps" size="large" icon="$vuetify"></v-fab>
              </template>

              <v-btn key="1" icon="$success"></v-btn>
              <v-btn key="2" icon="$info"></v-btn>
              <v-btn key="3" icon="$warning"></v-btn>
              <v-btn key="4" icon="$error"></v-btn>
            </v-speed-dial>
          </div>
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
      order: -1,
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

const theme = ref('dark')

function onClick() {
  theme.value = theme.value === 'light' ? 'dark' : 'light'
}
</script>

<style scoped>
.speed-dial-container {
  position: fixed;
  bottom: 40px;
  right: 80px;
  z-index: 999;
}
</style>