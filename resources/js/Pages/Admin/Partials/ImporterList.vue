<script setup>
import Button from 'primevue/button';
import ImporterCard from './ImporterCard.vue';
import {router} from '@inertiajs/vue3';
import {defineProps, ref} from 'vue';

defineProps({
  availableImporters: Array,
});

const runAllImporters = () => {
  router.post(route('admin.importers.runAll'));
};

const updateDescriptions = () => {
  router.post(route('admin.importers.describe'));
};

const importerCards = ref([])

// eslint-disable-next-line
Echo.channel('importer-status')
    .listen('UpdateImporterJobStatus', (e) => {
        const importerClass = e.importer;
        const status = e.status;
        const timestamp = e.timestamp;


        const importerCard = importerCards.value.find(importerCard => importerCard.getClass() === importerClass);
        importerCard.setStatus(status);
        importerCard.setTimeMessage(timestamp)
    });

</script>

<template>
  <div class="flex flex-col gap-4">
    <span class="text-lg font-semibold">List of all importers</span>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <ImporterCard
        v-for="importer in availableImporters"
        ref="importerCards"
        :key="importer.class"
        :importer="importer"
      />
    </div>
    <div class="flex justify-end gap-2">
      <Button
        label="Run all importers"
        icon="pi pi-play"
        size="small"
        @click="runAllImporters"
      />
      <Button
        label="Update descriptions"
        icon="pi pi-refresh"
        size="small"
        @click="updateDescriptions"
      />
    </div>
  </div>
</template>
