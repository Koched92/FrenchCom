<template>
  <v-dialog max-width="500">
    <template v-slot:activator="{ props: activatorProps }">
      <v-fab v-bind="activatorProps" icon="mdi-plus-circle"></v-fab>
    </template>
    <template v-slot:default="{ isActive }">
      <v-card title="New Link">
        <v-card-text>
          <LinkForm />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn append-icon="mdi-close-box" class="me-2 text-none" text="Close" variant="tonal" color="danger" size="small" @click="isActive.value = false"></v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
import LinkForm from './LinkForm.vue'

export default {
  components: {
    LinkForm
  },
}
</script>

<style scoped>
.v-fab {
  position: fixed;
  bottom: 0;
  right: 0;
  margin: 60px;
}
</style>