<script setup>
import Layout from "@/Pages/Admin/Layout.vue";
import ImporterList from "@/Pages/Admin/Partials/ImporterList.vue";
import JobStatus from "@/Pages/Admin/Partials/JobStatus.vue";
import TelescopeLogo from "@/Pages/Admin/Partials/TelescopeLogo.vue";
import Button from 'primevue/button';

const props = defineProps({
  availableImporters: Array,
});
</script>

<template>
  <Layout header="Importers">
    <div class="flex flex-col gap-4">
      <ImporterList :availableImporters="availableImporters" />
      <JobStatus />
      <div class="flex gap-2 items-center justify-end">
        <span>More detailed logs:</span>
          <a href="/telescope" target="_blank">
            <div class="flex gap-1 items-center">
              <TelescopeLogo class="w-5"/>
              <span class="text-indigo-700 font-medium">Laravel Telescope</span>
            </div>
          </a>
      </div>
    </div>
  </Layout>
</template>
