<script setup>
import { ref, computed, onMounted, onBeforeUnmount} from 'vue';
import 'maplibre-gl/dist/maplibre-gl.css';
import maplibregl from 'maplibre-gl';
import { usePage } from '@inertiajs/vue3'

const page = usePage();
const mapContainer = ref(null);
const map = ref(null);

const geojson = computed(() => page.props.placeholderGeojson)
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

    map.value.on('load', function () {
        map.value.loadImage('./images/park-marker.png', async function(error, image){
            if (error) throw error;
            map.value.addImage('park', image);

        });
        map.value.addSource('parks', {
            'type': 'geojson',
            'data': geojson.value,
            });
        map.value.addLayer({
            'id': 'parks',
            'type': 'symbol',
            'source': 'parks',
            'layout': {
                'icon-image': 'park',
                'icon-size': 0.06
            }
        });
    });

    map.value.on('idle', function () {
        map.value.resize()
    })
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

