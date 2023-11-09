<script setup>
import { ref, onMounted, onBeforeUnmount} from 'vue';
import { addControls } from './Partials/mapControls.js';
import { loadGeojsonFeatures } from './Partials/loadGeojsonFeatures.js';
import ProgressSpinner from 'primevue/progressspinner';

import 'maplibre-gl/dist/maplibre-gl.css';
import maplibregl from 'maplibre-gl';

const MAPLIBRE_TOKEN = import.meta.env.VITE_MAPLIBRE_TOKEN;
const mapContainer = ref(null);
const map = ref(null);


const LoadingStates = {
    FetchingData: 'Fetching Data...',
    PopulatingMap: 'Populating Map with Data...',
    RenderingMap: 'Rendering Map...',
    Completed: 'Completed',
};

const currentLoadingState = ref(LoadingStates.FetchingData);

function createMap() {
    map.value = new maplibregl.Map({
        container: mapContainer.value,
        style: `https://api.maptiler.com/maps/dataviz/style.json?key=${MAPLIBRE_TOKEN}`,
        center: [18.907417071275205, 52.373746306181296],
        zoom: 6,
        crossSourceCollisions: false,
        failIfMajorPerformanceCaveat: false,
        attributionControl: false,
        preserveDrawingBuffer: true,
        hash: false,
        minPitch: 0,
        maxPitch: 60,
    });

    map.value.on('load', () => {
    fetch('./assets/placeholder/output.geojson')
        .then(response => response.json())
        .then(geojson => {
            currentLoadingState.value = LoadingStates.PopulatingMap;
            return new Promise(resolve => {
                setTimeout(() => {
                    loadGeojsonFeatures(map.value, geojson, 'placeholder', '#6321b5');
                    resolve();
                }, 200);
            });
        })
        .then(() => {
            currentLoadingState.value = LoadingStates.RenderingMap;
            return new Promise(resolve => {
                setTimeout(() => {
                    addControls(map.value);
                    resolve();
                }, 200);
            });
        })
        .finally(() => {
            currentLoadingState.value = LoadingStates.Completed;
        });
});
}

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
    <div v-show="currentLoadingState !== LoadingStates.Completed" class="flex items-center justify-center w-full h-full">
        <div class="flex flex-col gap-2">
            <ProgressSpinner />
            {{ currentLoadingState }}
        </div>
    </div>
    <div v-show="currentLoadingState === LoadingStates.Completed" ref="mapContainer" class="h-full w-full"/>
</template>
