<script setup>
import Button from "primevue/button";
import ImporterCard from "./ImporterCard.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  availableImporters: Array,
});

const runAllImporters = () => {
  router.post(route('admin.importers.runAll'));
};

const runImporter = (importer) => {
  router.post(route('admin.importers.run'), { importer: importer });
};

const updateDescriptions = () => {
  router.post(route('admin.importers.describe'));
};
</script>

<template>
  <div class="flex flex-col gap-4">
    <span class="text-lg font-semibold">List of all importers</span>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <ImporterCard/>
      
    </div>
    <div class="flex justify-end gap-2">
      <Button label="Run all importers" icon="pi pi-play" size="small" @click="runAllImporters" />
      <Button label="Update descriptions" icon="pi pi-refresh" size="small" @click="updateDescriptions" />
    </div>
  </div>
</template>
