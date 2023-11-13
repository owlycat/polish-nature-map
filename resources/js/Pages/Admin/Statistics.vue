<script setup>
import Layout from "@/Pages/Admin/Layout.vue";
</script>

<template>
  <Layout header="Statistics">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Number of Users -->
      <div class="bg-white p-4 rounded-md shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Users</h2>
        <p class="text-4xl font-bold text-blue-500">123</p>
      </div>

      <!-- Number of Places -->
      <div class="bg-white p-4 rounded-md shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Places</h2>
        <p class="text-4xl font-bold text-green-500">432</p>
      </div>

    </div>
  </Layout>
</template>
