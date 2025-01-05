<template>
  <v-row class="d-md-flex">
    <!-- Afficher le loader pendant le chargement -->
    <v-col cols="12" sm="12" md="12">
      <div class="experience-section">
        <v-skeleton-loader class="card-class" v-if="loading" v-for="n in 7" :key="n" :elevation="8"
          type="list-item-avatar"></v-skeleton-loader>
      </div>
    </v-col>

    <!-- Afficher les cartes une fois les données chargées -->
    <v-col cols="12" sm="12" md="12">
      <div class="experience-section">
        <v-card class="card-class" v-for="(link, linkId) in categoryLinks" :key="linkId" :elevation="8"
          height="fit-content" :subtitle="link.slug" :title="link.name">
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
              <v-card-text>
                {{ link.description }}
              </v-card-text>
            </div>
          </v-expand-transition>
        </v-card>
      </div>
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
      categoryLinks: [],
      currentRequestId: null
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
      this.categoryLinks = []

      // Sauvegarder l'ID de la requête actuelle
      const requestId = Date.now()
      this.currentRequestId = requestId

      try {
        // Vérifier si c'est toujours la dernière requête avant de continuer
        if (requestId !== this.currentRequestId) return

        const categoryResponse = await axios.get(`/api/categories/${categoryId}`)
        const linkHasCategoriesUrls = categoryResponse.data.linkHasCategories

        const links = []
        for (const linkHasCategoryUrl of linkHasCategoriesUrls) {
          // Vérifier à nouveau si c'est toujours la dernière requête
          if (requestId !== this.currentRequestId) return

          try {
            const linkHasCategoryResponse = await axios.get(linkHasCategoryUrl)
            const linkUrl = linkHasCategoryResponse.data.link
            const linkResponse = await axios.get(linkUrl)

            // Ne mettre à jour les liens que si c'est toujours la dernière requête
            if (requestId === this.currentRequestId) {
              links.push(linkResponse.data)
            }
          } catch (error) {
            console.error(`Erreur lors du chargement du lien:`, error)
          }
        }

        // Mise à jour finale uniquement si c'est toujours la dernière requête
        if (requestId === this.currentRequestId) {
          this.categoryLinks = links
        }

        return links
      } catch (error) {
        console.error(`Erreur lors du chargement des liens pour la catégorie ${categoryId}:`, error)
        return []
      } finally {
        if (requestId === this.currentRequestId) {
          this.loading = false
        }
      }
    }
  }
}

</script>

<style scoped>
.card-class {
  width: 30%;
}

.experience-section {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-between;
}
</style>