<script setup>
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    features: Object,
});

const previousPage = props.features.links[0];
const nextPage = props.features.links[props.features.links.length - 1]

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
      <div
        v-for="(feature, featureIndex) in props.features.data"
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
              {{ feature.name }}
            </h3>
            <p class="text-sm text-gray-600">
              {{ feature.category_id }}
            </p>
          </div>

          <div>
            <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 text-xs rounded transition-colors duration-200">
              Visited
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="sticky bottom-0 z-10">
      <div class="flex gap-1">
        <Link
          v-if="previousPage.url"
          class="flex-1"
          :href="previousPage.url"
          :only="['features']"
        >
          <Button
            class="w-full"
            label="Previous"
            icon="pi pi-angle-left"
            size="small"
            outlined
          />
        </Link>
        <Button
          v-else
          class="flex-1"
          label="Previous"
          icon="pi pi-angle-left"
          size="small"
          disabled
          outlined
        />
        <Link
          v-if="nextPage.url"
          class="flex-1"
          :href="nextPage.url"
          :disabled="nextPage.active == false"
          :only="['features']"
        >
          <Button
            class="w-full"
            label="Next"
            icon="pi pi-angle-right"
            size="small"
            icon-pos="right"
            outlined
          />
        </Link>
        <Button
          v-else
          class="flex-1"
          label="Next"
          icon="pi pi-angle-right"
          size="small"
          icon-pos="right"
          disabled
          outlined
        />
      </div>
    </div>
  </div>
</template>
