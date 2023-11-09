<script setup>
import { ref, onMounted, onBeforeUnmount} from 'vue';
import { addControls } from './Partials/mapControls.js';
import { loadGeojsonFeatures } from './Partials/loadGeojsonFeatures.js';

import 'maplibre-gl/dist/maplibre-gl.css';
import maplibregl from 'maplibre-gl';

const mapContainer = ref(null);
const map = ref(null);

function createMap(){
    map.value = new maplibregl.Map({
        container: mapContainer.value,
        style: `https://api.maptiler.com/maps/1d49ef3b-6f11-4b99-bc3e-5333cb10e6ab/style.json?key=${MAPLIBRE_TOKEN}`,
        center: [0, 0],
        zoom: 0,
        crossSourceCollisions: false,
        failIfMajorPerformanceCaveat: false,
        attributionControl: false,
        preserveDrawingBuffer: true,
        hash: false,
        minPitch: 0,
        maxPitch: 60,
    });

    map.value.on('load', function () {
        fetch('./assets/placeholder/output.geojson')
        .then(response => response.json())
        .then(geojson => {
            loadGeojsonFeatures(map.value, geojson, 'placeholder', '#6321b5')
        });

        addControls(map.value);
    });
}

const MAPLIBRE_TOKEN = import.meta.env.VITE_MAPLIBRE_TOKEN;

onMounted(() => {
    createMap();
});

const destroyMap = () => {
    map.value.remove();
};

onBeforeUnmount(() => {
    destroyMap();
});
</script>
<template>
  <div
    ref="mapContainer"
    class="h-full w-full"
  />
</template>
