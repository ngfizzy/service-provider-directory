<script setup>
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage, Head, Link } from '@inertiajs/vue3'

import axiosInstance from '../axios'
import debounce from 'just-debounce-it'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

const { serviceProviders, filters } = usePage().props

const selectedCategory = ref(filters.category_id || null)
const categories = ref([])
const loading = ref(false)





const fetchCategories = async (q = '') => {
    loading.value = true
    try {
        const { data } = await axiosInstance.get('/api/categories', {
            params: { search: q }
        })
        categories.value = Array.isArray(data) ? data : []
    } catch (error) {
        console.error('Error fetching categories:', error)
        categories.value = []
    } finally {
        loading.value = false
    }
}

const debouncedFetch = debounce(fetchCategories, 300)



const hasHydrated = ref(false)
onMounted(() => {
  fetchCategories('')
  hasHydrated.value = true 
})

const applyFilter = () => {
  const params = selectedCategory.value?.id
    ? { category_id: selectedCategory.value.id }
    : {}

  if (hasHydrated.value) {
    Inertia.get('/providers', params, {
      preserveScroll: true,
      preserveState: true,
      replace: true,
      only: ['serviceProviders', 'filters'],
    })
  } else {
    Inertia.visit('/providers', {
      method: 'get',
      data: params,
      preserveScroll: true,
      preserveState: false,
    })
  }
}


const clearFilter = () => {
    selectedCategory.value = null

    Inertia.visit('/providers', {
        method: 'get',
        preserveScroll: true,
        preserveState: true,
    })
}
</script>

<template>

    <Head title="Service Providers" />

    <section class="container mx-auto p-6">
        <!-- ▼ category filter -->
        <div class="mb-6">
            <label class="block mb-2 text-sm font-semibold text-gray-700">
                Filter by Category:
            </label>

            <div class="flex items-center">
                <div class="flex-grow">
                    <Multiselect v-model="selectedCategory" :options="categories" :searchable="true"
                        :internal-search="false" :label="'name'" :track-by="'id'" placeholder="Search categories…"
                        :clear-on-select="true" :close-on-select="true" @search-change="debouncedFetch"
                        @select="applyFilter" />
                </div>

                <button v-if="selectedCategory" @click="clearFilter"
                    class="ml-2 px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Clear
                </button>
            </div>

            <div v-if="loading" class="mt-2 text-sm text-gray-500">
                Loading categories...
            </div>
        </div>

        <!-- ▼ provider cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="p in serviceProviders.data" :key="p.id" class="p-4 bg-white shadow rounded">
                <div class="h-24 w-24 mx-auto mb-4 flex items-center justify-center bg-gray-100 rounded-full">
                    <img v-if="p.logo" :src="p.logo" alt="Logo" class="h-24 w-24 object-cover rounded-full"
                        loading="lazy" />
                    <i v-else class="fas fa-building text-4xl text-gray-400 leading-none" aria-hidden="true"></i>
                </div>

                <h2 class="text-lg font-semibold text-center">{{ p.name }}</h2>
                <p class="text-sm text-gray-500 text-center">
                    {{ p.short_description }}
                </p>
                <p class="text-xs text-gray-400 text-center mt-2">
                    {{ p.category.name }}
                </p>
            </div>
        </div>

        <div v-if="serviceProviders.links" class="mt-6 text-center">
            <template v-for="(link, i) in serviceProviders.links" :key="i">
                <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-3 py-1 border rounded text-sm"
                    :class="{ 'font-bold': link.active }" />
                <span v-else v-html="link.label"
                    class="px-3 py-1 border rounded text-sm text-gray-400 cursor-not-allowed" />
            </template>
        </div>
    </section>
</template>