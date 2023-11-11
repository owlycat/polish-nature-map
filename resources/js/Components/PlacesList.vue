<script setup>
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const { data } = defineProps({
    data: JSON,
});
</script>

<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-screen flex flex-col h-full">
    <div class="sticky top-0 z-10">
      <span class="p-input-icon-left w-full">
        <i class="pi pi-search" />
        <InputText
          class="w-full"
          placeholder="Search"
        />
      </span>
    </div>
    <div class="overflow-y-auto flex-grow max-h-fit">
      <template
        v-for="(category, categoryIndex) in data"
        :key="categoryIndex"
      >
        <div
          v-for="(feature, featureIndex) in category.geojson.features"
          :key="featureIndex"
        >
          <div class="flex items-center bg-white rounded-lg shadow-md border overflow-hidden hover:bg-surface-100 p-3">
            <img
              class="h-20 w-20 object-cover rounded-lg opacity-60"
              src="/images/place-default-thumbnail.png"
              alt="Place"
            >

            <div class="flex-grow p-2">
              <h3 class="font-semibold text-lg">
                {{ feature.properties.name }}
              </h3>
              <p class="text-sm text-gray-600">
                {{ category.category }}
              </p>
            </div>

            <div>
              <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 text-xs rounded transition-colors duration-200">
                Visited
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
    <div class="sticky bottom-0 z-10">
      <div class="flex gap-1">
        <Button
          class="flex-1"
          label="Previous"
          icon="pi pi-angle-left"
          size="small"
          disabled
          outlined
        />
        <Button
          class="flex-1"
          label="Next"
          icon="pi pi-angle-right"
          size="small"
          icon-pos="right"
          outlined
        />
      </div>
    </div>
  </div>
</template>
