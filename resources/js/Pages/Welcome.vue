<script setup>
import { Head } from '@inertiajs/vue3';
import PlacesList from '@/Components/PlacesList.vue';
import { ref } from 'vue';
import Map from '@/Components/Maplibre/Map.vue';

const props = defineProps({
    geojson: JSON,
    categories: Array,
});

const map = ref(null);
const coorinates = ref(null);

function onDataUpdate(data) {
    map.value.filterMap(data);
}

const handleShowCoordinates = (coordinates) => {
  coorinates.value = coordinates;
};
</script>

<template>
  <Head title="Welcome" />
  <div class="flex-grow overflow-y-auto h-screen flex md:flex-row flex-col-reverse">
    <div class="h-3/5 md:h-full relative">
      <PlacesList
        :categories="props.categories"
        @filter:geojson="onDataUpdate"
        @show-coordinates="handleShowCoordinates"
      />
    </div>
    <div class="w-full h-2/5 md:h-full">
      <Map
        ref="map"
        :geojson="props.geojson"
        :coordinates="coorinates"
      />
    </div>
  </div>
</template>
