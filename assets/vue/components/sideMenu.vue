<template>
  <v-navigation-drawer width="400">
    <v-list>
      <v-list-item prepend-icon="mdi-home" title="Home"></v-list-item>

      <!-- Boucle sur les groupes de catégories uniques -->
      <v-list-group v-for="(group, groupId) in categoryGroups" :key="groupId" :value="groupId">
        <!-- En-tête du groupe -->
        <template v-slot:activator="{ props }">
          <template v-if="groupNames[groupId]">
            <v-list-item v-bind="props" prepend-icon="mdi-folder" :title="groupNames[groupId]"></v-list-item>
          </template>
          <template v-else>
            <v-skeleton-loader type="list-item-avatar"></v-skeleton-loader>
          </template>
        </template>

        <!-- Liste des catégories du groupe -->
        <v-list-item v-for="categoryId in group" :key="categoryId" prepend-icon="mdi-file"
          :title="categoryNames[categoryId]" :value="categoryId"
          @click="$emit('category-selected', categoryId)"></v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import axios from 'axios'
import MainContent from './MainContent.vue'

export default {
  data() {
    return {
      linkHasCategories: [],
      categoryGroups: {},
      groupNames: {},
      categoryNames: {},
    }
  },
  components: {
    MainContent
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/link_has_categories')
        this.linkHasCategories = response.data['hydra:member']
        this.organizeCategoriesByGroup()
        await this.fetchGroupNames()
        await this.fetchSubCategoryNames()
      } catch (error) {
        console.error('Erreur lors du chargement des données:', error)
      }
    },

    async fetchGroupNames() {
      const groupIds = Object.keys(this.categoryGroups)

      for (const groupId of groupIds) {
        try {
          const response = await axios.get(`/api/category_groups/${groupId}`)
          this.groupNames[groupId] = response.data.name
        } catch (error) {
          console.error(`Erreur lors du chargement du groupe ${groupId}:`, error)
        }
      }
    },

    async fetchSubCategoryNames() {
      const categoryIds = Object.keys(this.categoryGroups).reduce((acc, group) => {
        return acc.concat(this.categoryGroups[group])
      }, [])

      for (const categoryId of categoryIds) { // Boucle sur les catégories
        try {
          const response = await axios.get(`/api/categories/${categoryId}`)
          this.categoryNames[categoryId] = response.data.name
        } catch (error) {
          console.error(`Erreur lors du chargement de la catégorie ${categoryId}:`, error)
        }
      } // Fin de la boucle sur les catégories
    },

    organizeCategoriesByGroup() {
      // Organise les catégories par groupe
      this.categoryGroups = this.linkHasCategories.reduce((groups, item) => {
        const groupId = item.categoryGroup.split('/').pop()
        const categoryId = item.category.split('/').pop()

        if (!groups[groupId]) {
          groups[groupId] = []
        }

        if (!groups[groupId].includes(categoryId)) {
          groups[groupId].push(categoryId)
        }

        return groups
      }, {})
    },
    handleCategoryLinksClick(categoryId) {
      this.$refs.MainContent.getLinksByCategory(categoryId)
    }

  },
  mounted() {
    this.fetchData()
  }

}

</script>

<style></style>