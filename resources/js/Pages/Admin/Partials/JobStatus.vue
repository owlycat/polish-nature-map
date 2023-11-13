<script setup>
import Column from "primevue/column";
import DataTable from "primevue/datatable";
</script>

<template>
  <div class="flex flex-col gap-4">
  <span class="text-lg font-semibold">Job status</span>
  <DataTable :value="jobStatuses">
    <Column field="job_name" header="Name"></Column>
    <Column field="job_status" header="Status"></Column>
    <Column field="timestamp" header="Timestamp"></Column>
  </DataTable>
  </div>
</template>
