<script setup>
import { Head } from '@inertiajs/vue3';
import MapMenu from './Partials/MapMenu.vue';
import Map from '@/Components/Maplibre/Map.vue';

const props = defineProps({
    displayInfo: Object,
    personalMap: Object,
});

</script>

<template>
  <Head title="Map" />
  <div class="flex-grow overflow-y-auto h-screen flex md:flex-row flex-col-reverse">
    <div class="h-3/5 md:h-full relative">
      <MapMenu
        :user="props.displayInfo.user"
        :categories="props.displayInfo.categories"
        :totals="props.displayInfo.totals"
        :personal-map="props.personalMap"
      />
    </div>
    <div class="w-full h-2/5 md:h-full">
      <Map
        ref="map"
        :geojson="props.displayInfo.geojson"
      />
    </div>
  </div>
</template>
