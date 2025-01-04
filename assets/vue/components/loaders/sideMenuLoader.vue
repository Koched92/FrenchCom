<template>
  <v-container>

      <v-skeleton-loader :loading="loading" type="list-item-two-line">

        <v-list-item lines="two" subtitle="Subtitle" :title="title" rounded></v-list-item>
      </v-skeleton-loader>

  </v-container>
</template>

<script>
export default {
  props: {
    loading: {
      type: Boolean,
      required: true
    },
    title: {
      type: String,
      required: true
    }
  }
}
</script>

<style></style>
