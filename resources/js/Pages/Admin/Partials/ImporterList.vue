<script setup>
import Button from "primevue/button";
import Card from "primevue/card";
</script>

<template>
  <div class="flex flex-col gap-4">
    <span class="text-lg font-semibold">List of all importers</span>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <Card>
        <template #title> national_park </template>
        <template #content>
          <Button label="Run importer" size="small" class="mt-2" />
        </template>
      </Card>
      <Card>
        <template #title> national_park </template>
        <template #content>
          <Button label="Run importer" size="small" class="mt-2" />
        </template>
      </Card>
      <Card>
        <template #title> national_park </template>
        <template #content>
          <Button label="Run importer" size="small" class="mt-2" />
        </template>
      </Card>
    </div>
    <div class="flex justify-end gap-2">
      <Button label="Run all importers" />
      <Button label="Update missing descriptions" />
    </div>
  </div>
</template>
