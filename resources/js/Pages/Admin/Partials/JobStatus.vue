<script setup>
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InlineMessage from 'primevue/inlinemessage';
import { ref } from "vue";

const props = defineProps({
    statuses: Object,
});

const jobStatuses = ref(props.statuses);

Echo.channel(`importer-status`)
    .listen('UpdateImporterJobStatus', (e) => {
        const importerClass = e.importer;
        const status = e.status;
        const timestamp = e.timestamp;

        jobStatuses.value.unshift({
            job_name: importerClass,
            job_status: status,
            job_timestamp: timestamp
        });

        jobStatuses.value = jobStatuses.value.slice(0, 20);
    });

const getSeverity = (job) => {
    switch (job.job_status) {
        case 'success':
            return 'success';
        case 'failed':
            return 'error';
        default:
            return 'info';
    }
};

</script>

<template>
  <div class="flex flex-col gap-4">
  <span class="text-lg font-semibold">Job status</span>
  <DataTable :value="jobStatuses" scrollable scrollHeight="400px">
    <Column field="job_name" header="Name"></Column>
    <Column field="job_status" header="Status">
        <template #body="slotProps">
            <InlineMessage :severity="getSeverity(slotProps.data)" class="h-9">{{ slotProps.data.job_status }}</InlineMessage>
        </template>
    </Column>
    <Column field="job_timestamp" header="Timestamp"></Column>
  </DataTable>
  <span class="text-sm">(Showing max of 20 last jobs)</span>
  </div>
</template>
