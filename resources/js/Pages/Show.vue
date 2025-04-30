<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'

const { provider } = usePage().props
</script>

<template>

    <Head :title="provider.name" />

    <div class="container mx-auto p-6 max-w-3xl">
        <Link href="/providers" class="text-sm text-blue-600 hover:underline">&larr; Back to List</Link>

        <div class="mt-6 p-6 bg-white shadow rounded">
            <div class="flex justify-center mb-4">
                <img v-if="provider.logo" :src="provider.logo" alt="Logo" class="h-32 w-32 rounded-full object-cover" />
                <i v-else class="fas fa-building text-6xl text-gray-300"></i>
            </div>

            <h1 class="text-2xl font-bold text-center">{{ provider.name }}</h1>
            <p class="text-center text-sm text-gray-500 mt-1">{{ provider.category.name }}</p>

            <p class="mt-4 text-gray-700 text-base leading-relaxed text-center">
                {{ provider.short_description }}
            </p>
        </div>
    </div>
</template>
