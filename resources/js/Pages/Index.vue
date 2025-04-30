<script setup>
import { Inertia } from '@inertiajs/inertia'
import { Head, Link, usePage } from '@inertiajs/vue3'
import debounce from 'just-debounce-it'
import { defineAsyncComponent, onMounted, ref } from 'vue'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import axiosInstance from '../axios'

const Multiselect = defineAsyncComponent(() => import('vue-multiselect'))

const props = usePage().props
const selectedCategory = ref(props.filters.category_id || null)
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

onMounted(() => {
    fetchCategories('').then(() => {
        if (props.filters.category_id && !selectedCategory.value?.id) {
            selectedCategory.value = categories.value.find(
                (c) => c.id === Number(props.filters.category_id)
            ) || null
        }
    })
})

const applyFilter = () => {
    const params = selectedCategory.value?.id
        ? { category_id: selectedCategory.value.id }
        : {}

    Inertia.get('/', params, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['serviceProviders', 'filters'],
    })
}

const clearFilter = () => {
    selectedCategory.value = null
    Inertia.get('/', {}, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['serviceProviders', 'filters'],
    })
}
</script>

<template>
    <Head title="Service Providers" />

    <section class="bg-primary text-white py-20 px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Directomy</h1>
        <p class="text-lg md:text-xl mb-6">Your one-stop shop for every service</p>
        <a href="#filter"
            class="bg-accent hover:bg-green-500 text-white font-semibold py-2 px-6 rounded shadow transition">
            Explore Providers
        </a>
    </section>

    <section id="filter" class="container mx-auto p-6 bg-white scroll-mt-24">
        <!-- Filter -->
        <div class="flex items-center my-4">
            <div class="flex-grow max-w-md w-full mx-auto">
                <Multiselect
                    v-model="selectedCategory"
                    :options="categories"
                    :searchable="true"
                    :internal-search="false"
                    :label="'name'"
                    :track-by="'id'"
                    placeholder="Search categories…"
                    :clear-on-select="true"
                    :close-on-select="true"
                    @search-change="debouncedFetch"
                    @select="applyFilter"
                />
            </div>
            <button v-if="selectedCategory" @click="clearFilter"
                class="ml-2 px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Clear
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a v-for="p in props.serviceProviders.data" :key="p.id" :href="`/${p.id}`"
                class="block p-4 bg-light-bg border border-gray-200 hover:shadow-lg transition rounded-lg">
                <div class="flex justify-center items-center mb-4">
                    <img v-if="p.logo" :src="p.logo" alt="Logo" class="h-24 w-24 object-cover rounded-full" />
                    <i v-else class="fas fa-building text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-xl font-bold text-center text-primary">{{ p.name }}</h2>
                <p class="text-sm text-gray-600 text-center mt-2">{{ p.short_description }}</p>
                <p class="text-xs text-gray-500 text-center mt-1">{{ p.category.name }}</p>
            </a>
        </div>

        <div
            v-if="props.serviceProviders.links"
            class="mt-6 overflow-x-auto flex justify-center items-center space-x-1 px-2 scrollbar-hide"
        >
            <template v-for="(link, i) in props.serviceProviders.links" :key="i">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    v-html="link.label"
                    class="min-w-[32px] px-3 py-1 border rounded text-sm text-center whitespace-nowrap"
                    :class="{ 'font-bold text-primary': link.active }"
                />
                <span
                    v-else
                    v-html="link.label"
                    class="min-w-[32px] px-3 py-1 border rounded text-sm text-gray-400 cursor-not-allowed text-center whitespace-nowrap"
                />
            </template>
        </div>
    </section>
</template>
