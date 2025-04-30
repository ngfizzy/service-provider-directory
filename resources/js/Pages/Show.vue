<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'

const { provider } = usePage().props
</script>

<template>
  <Head :title="provider.name" />

  <!-- 🔹 Hero Section -->
  <section class="bg-gradient-to-br from-blue-900 to-blue-700 text-white py-16 text-center">
    <div class="container mx-auto max-w-3xl px-4">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-3">
        {{ provider.name }}
      </h1>
      <p class="text-blue-200 text-sm mb-6 font-medium tracking-wide uppercase">
        {{ provider.category.name }}
      </p>
      <p class="text-lg text-blue-100 leading-relaxed max-w-2xl mx-auto">
        {{ provider.short_description }}
      </p>
    </div>
  </section>

  <!-- 🔹 Provider Details Card -->
  <section class="container mx-auto p-6 max-w-3xl">
    <Link href="/" class="inline-block mt-6 text-blue-600 hover:underline text-sm font-medium">
      &larr; Back to Directory
    </Link>

    <div class="mt-6 p-6 bg-white shadow-lg rounded-xl">
      <div class="flex justify-center mb-4">
        <img
          v-if="provider.logo"
          :src="provider.logo"
          alt="Logo"
          class="h-32 w-32 rounded-full object-cover shadow-md"
        />
        <i v-else class="fas fa-building text-6xl text-gray-300"></i>
      </div>

      <div class="text-center">
        <h2 class="text-2xl font-bold">{{ provider.name }}</h2>
        <p class="text-gray-500 text-sm mt-1">{{ provider.category.name }}</p>
        <p class="mt-4 text-gray-700 leading-relaxed">
          {{ provider.short_description }}
        </p>
      </div>
    </div>
  </section>
</template>
