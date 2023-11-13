<script setup>
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InfiniteLoading from "v3-infinite-loading";
import ProgressSpinner from 'primevue/progressspinner';
import "v3-infinite-loading/lib/style.css";
import { ref } from 'vue';
import _ from 'lodash';
import axios from 'axios';

let nextUrl = '/api/features/search/';
let places = ref([]);
const query = ref('');
const lazyLoaderShow = ref(true);

const emit = defineEmits(['filter:geojson'])

const search = () => {
    places.value = [];
    nextUrl = '/api/features/search/';
    lazyLoaderShow.value = true;

    axios.get("/api/features/filterIds/", { params: { query: query.value } }).then(response => {
        emit('filter:geojson', response.data);
    });
}

const debounceSearch = _.debounce(search, 500);

function getData(response){
    const json = response.data
    places.value.push(...json.data);
    nextUrl = json.next_page_url;
}

const load = async $state => {
    if(nextUrl === null) {
        $state.complete();
        lazyLoaderShow.value = false;
        return;
    }

    try {
    const url = nextUrl === '/api/features/search/' ? `/api/features/search/` : nextUrl;
    const params = nextUrl === '/api/features/search/' ? { page: 1, query: query.value } : {};

    axios.get(url, { params }).then(response => {
        getData(response);
        $state.loaded();
    });
    } catch (error) {
        $state.error();
    }
};
</script>

<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-screen flex flex-col h-full">
    <div class="sticky top-0 z-10">
      <span class="p-input-icon-left w-full">
        <i class="pi pi-search" />
        <InputText
          class="w-full"
          v-model="query"
          placeholder="Search"
          @input="debounceSearch"
        />
      </span>
    </div>
    <div class="overflow-y-auto flex-grow max-h-fit">
      <div
        v-for="(feature, featureIndex) in places"
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
              {{ feature.category_name }}
            </p>
          </div>

          <div>
            <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 text-xs rounded transition-colors duration-200">
              Visited
            </button>
          </div>
        </div>
      </div>
      <InfiniteLoading v-if="lazyLoaderShow" @infinite="load">
        <template #spinner>
          <div class="flex justify-center p-2">
            <ProgressSpinner aria-label="Loading" class="h-10 w-10"/>
          </div>
        </template>
      </InfiniteLoading>
      <div class="grid p-2 justify-items-center flex-grow max-h-fit" v-else>
        <div>No more results.</div>
      </div>
    </div>
  </div>
</template>
