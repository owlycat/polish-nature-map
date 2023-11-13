<script setup>
import Layout from "@/Pages/Admin/Layout.vue";
import ImporterList from "@/Pages/Admin/Partials/ImporterList.vue";
import JobStatus from "@/Pages/Admin/Partials/JobStatus.vue";

const props = defineProps({
  availableImporters: Array,
});
</script>

<template>
  <Layout header="Importers">
    <div class="flex flex-col gap-4">
      <ImporterList :availableImporters="availableImporters" />
      <JobStatus />
    </div>
  </Layout>
</template>
