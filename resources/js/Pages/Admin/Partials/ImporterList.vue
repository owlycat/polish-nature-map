<script setup>
import Button from "primevue/button";
import Card from "primevue/card";
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <Card v-for="importer in availableImporters" :key="importer.name">
        <template #title>{{ importer.name }}</template>
        <template #content>
          <Button label="Run importer" size="small"  @click="runImporter(importer)"/>
        </template>
      </Card>
    </div>
    <div class="flex justify-end gap-2">
      <Button label="Run all importers" size="small" @click="runAllImporters" />
      <Button label="Update missing descriptions" size="small" @click="updateDescriptions" />
    </div>
  </div>
</template>
