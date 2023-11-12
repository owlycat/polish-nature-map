<script setup>
import { Head } from '@inertiajs/vue3';
import PlacesList from '@/Components/PlacesList.vue';
import { ref } from 'vue';
import Map from '@/Components/Maplibre/Map.vue';

const props = defineProps({
    geojson: JSON,
    features: Object,
});

const isListVisible = ref(true);

const toggleListVisibility = () => {
    isListVisible.value = !isListVisible.value;
};
</script>

<template>
  <Head title="Welcome" />
  <div class="flex-grow overflow-y-auto h-screen flex md:flex-row flex-col-reverse">
    <div :class="isListVisible ? 'h-3/5 md:h-full relative' : 'h-0'">
      <PlacesList
        v-show="isListVisible"
        :features="props.features"
      />
      <button
        v-show="isListVisible"
        class="absolute top-0 right-0 m-4 md:hidden z-20"
        @click="toggleListVisibility"
      >
        Hide List
      </button>
    </div>
    <div :class="isListVisible ? 'w-full h-2/5 md:h-full' : 'w-full h-full'">
      <Map :geojson="props.geojson" />
    </div>
    <button
      v-show="!isListVisible"
      class="fixed bottom-0 right-0 m-4 md:hidden"
      @click="toggleListVisibility"
    >
      Show List
    </button>
  </div>
</template>
