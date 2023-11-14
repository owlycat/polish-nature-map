<script setup>
import Layout from "@/Pages/Admin/Layout.vue";

const props = defineProps({
  statistics: Array,
});
</script>

<template>
  <Layout header="Statistics">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="statistic in statistics" :key="statistic.name" class="bg-white p-4 rounded-md shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">{{ statistic.name }}</h2>
        <p class="text-4xl font-bold text-primary">{{ statistic.value }}</p>
      </div>
    </div>
  </Layout>
</template>
