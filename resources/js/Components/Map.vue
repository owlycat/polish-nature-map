<script setup>
import { ref , onMounted, onBeforeUnmount} from 'vue';
import "maplibre-gl/dist/maplibre-gl.css";
import maplibregl from 'maplibre-gl';

const mapContainer = ref(null);
const map = ref(null);

onMounted(() => {
    map.value = new maplibregl.Map({
        container: mapContainer.value,
        style: 'https://api.maptiler.com/maps/streets/style.json?key=4NMBAEQT9XTdZwrnxwqc',
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

    map.value.addControl(new maplibregl.NavigationControl())
    map.value.addControl(new maplibregl.FullscreenControl())
    map.value.addControl(new maplibregl.ScaleControl())
    map.value.addControl(new maplibregl.GeolocateControl())
    map.value.addControl(new maplibregl.LogoControl())

    map.value.on("idle", function () {
        map.value.resize()
    })

    addMarker();
});

const destroyMap = () => {
    map.value.remove();
};

const addMarker = () => {
    new maplibregl.Marker()
        .setLngLat(map.value.getCenter())
        .addTo(map.value);
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

