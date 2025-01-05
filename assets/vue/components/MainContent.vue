<template>
  <v-row align="center" justify="center" dense>
    <!-- Afficher le loader pendant le chargement -->
    <v-col v-if="loading" v-for="n in 7" :key="n" cols="12" md="6">
      <v-skeleton-loader :elevation="8" type="list-item-avatar"></v-skeleton-loader>
    </v-col>

    <!-- Afficher les cartes une fois les données chargées -->
    <v-col v-for="(link, linkId) in categoryLinks" :key="linkId" cols="12" md="6">
      <v-card :elevation="8" class="mx-auto" :subtitle="link.slug" :title="link.name">
        <template v-slot:prepend>
          <v-avatar size="34">
            <v-img alt="John" :src="link.icon.path"></v-img>
          </v-avatar>
        </template>
        <template v-slot:append>
          <a :href="link.url" target="_blank" style="text-decoration: none; color: inherit;">
            <v-icon>mdi-open-in-new</v-icon>
          </a>
        </template>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :icon="expandedCards[linkId] ? 'mdi-chevron-up' : 'mdi-chevron-down'"
            @click.stop="expandedCards[linkId] = !expandedCards[linkId]"></v-btn>
        </v-card-actions>

        <v-expand-transition>
          <div v-show="expandedCards[linkId]">
            <v-divider></v-divider>
            <v-card-text>
              {{ link.description }}
            </v-card-text>
          </div>
        </v-expand-transition>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import axios from 'axios'

export default {
  name: 'MainContent',
  props: {
    categoryId: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      loading: false,
      expandedCards: {},
      categoryLinks: []
    }
  },
  mounted() {
    // Initialiser expandedCards pour chaque lien
    this.categoryLinks.forEach((_, index) => {
      this.expandedCards[index] = false
    })
  },
  methods: {
    async getLinksByCategory(categoryId) {
      this.loading = true
      try {

        // 1. D'abord, récupérer la catégorie pour avoir les linkHasCategories
        const categoryResponse = await axios.get(`/api/categories/${categoryId}`)
        const linkHasCategoriesUrls = categoryResponse.data.linkHasCategories
        this.categoryLinks = []
        // 2. Pour chaque linkHasCategory, récupérer les détails du lien
        for (const linkHasCategoryUrl of linkHasCategoriesUrls) {
          try {
            // Récupérer le linkHasCategory
            const linkHasCategoryResponse = await axios.get(linkHasCategoryUrl)
            // Récupérer l'URL complète du lien
            const linkUrl = linkHasCategoryResponse.data.link

            // Récupérer les détails du lien
            const linkResponse = await axios.get(linkUrl)
            this.categoryLinks.push(linkResponse.data)
          } catch (error) {
            console.error(`Erreur lors du chargement du lien:`, error)
          }
        }

        // Stocker les liens dans categoryLinks
        return this.categoryLinks

      } catch (error) {
        console.error(`Erreur lors du chargement des liens pour la catégorie ${categoryId}:`, error)
        return []
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style></style>