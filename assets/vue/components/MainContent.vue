<template>
  
  <v-skeleton-loader :elevation="13" type="list-item-avatar"></v-skeleton-loader>
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
      categoryLinks: {}
    }
  },
  methods: {
    async getLinksByCategory(categoryId) {
      try {
        console.log(categoryId);

        // 1. D'abord, récupérer la catégorie pour avoir les linkHasCategories
        const categoryResponse = await axios.get(`/api/categories/${categoryId}`)
        const linkHasCategoriesUrls = categoryResponse.data.linkHasCategories

        // 2. Pour chaque linkHasCategory, récupérer les détails du lien
        const links = []
        for (const linkHasCategoryUrl of linkHasCategoriesUrls) {
          try {
            // Récupérer le linkHasCategory
            const linkHasCategoryResponse = await axios.get(linkHasCategoryUrl)
            // Récupérer l'URL complète du lien
            const linkUrl = linkHasCategoryResponse.data.link

            // Récupérer les détails du lien
            const linkResponse = await axios.get(linkUrl)
            links.push(linkResponse.data)
          } catch (error) {
            console.error(`Erreur lors du chargement du lien:`, error)
          }
        }

        // Stocker les liens dans categoryLinks
        this.categoryLinks[categoryId] = links
        console.log(links);

        return links
      } catch (error) {
        console.error(`Erreur lors du chargement des liens pour la catégorie ${categoryId}:`, error)
        return []
      }
    }
  }
}
</script>

<style></style>