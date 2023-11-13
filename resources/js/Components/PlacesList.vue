<script setup>
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InfiniteLoading from 'v3-infinite-loading';
import ProgressSpinner from 'primevue/progressspinner';
import MultiSelect from 'primevue/multiselect';
import SelectButton from 'primevue/selectbutton';
import 'v3-infinite-loading/lib/style.css';
import { ref, computed } from 'vue';
import _ from 'lodash';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

let nextUrl = '/api/features/search/';
let places = ref([]);
const query = ref('');
const selectedCategories = ref([]);
const visited = ref({ name: 'All', value: 'all' });
const visitedOptions = [
    { name: 'All', value: 'all' },
    { name: 'Visited', value: 'visited' },
    { name: 'Not Visited', value: 'not_visited' },
];

const isLoggedIn = computed(() => {
    const page = usePage();
    return page.props.auth.user !== null;
});

const hasFilters = computed(() => {
    return query.value !== '' || selectedCategories.value.length > 0 || visited.value.value !== 'all';
});

const lazyLoaderShow = ref(true);

const props = defineProps({
    categories: Array,
});

const emit = defineEmits(['filter:geojson'])

const search = () => {
    places.value = [];
    nextUrl = '/api/features/search/';
    lazyLoaderShow.value = true;

    axios.get('/api/features/filterIds/', {
        params: {
            query: query.value,
            categories: selectedCategories.value,
            visited: visited.value.value,
        }
    }).then(response => {
        emit('filter:geojson', response.data);
    });
}

const debounceSearch = _.debounce(search, 500);

function clearFilters(){
    query.value = '';
    selectedCategories.value = [];
    visited.value = { name: 'All', value: 'all' };
    search();
}

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
    const url = nextUrl === '/api/features/search/' ? '/api/features/search/' : nextUrl;
    const params = nextUrl === '/api/features/search/' ? {
        page: 1,
        query: query.value,
        categories: selectedCategories.value,
        visited: visited.value.value
    } : {
        query: query.value,
        categories: selectedCategories.value,
        visited: visited.value.value
    };

    axios.get(url, { params }).then(response => {
        getData(response);
        $state.loaded();
    });
    } catch (error) {
        $state.error();
    }
};

const filterOpen = ref(false);
const filterButtonIcon = computed(() => {
    return hasFilters.value ? 'pi pi-filter-fill' : 'pi pi-filter';
});

const toggleFilter = () => {
    filterOpen.value = !filterOpen.value;
};
</script>

<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-screen flex flex-col h-full">
    <div class="flex flex-row sticky top-0 z-10">
      <span class="p-input-icon-left w-full">
        <i class="pi pi-search" />
        <InputText
          v-model="query"
          class="w-full"
          placeholder="Search"
          @input="debounceSearch"
        />
      </span>
      <Button
        :icon="filterButtonIcon"
        text
        aria-label="Submit"
        @click="toggleFilter"
      />
    </div>
    <div
      v-show="filterOpen"
      class="flex flex-col gap-4 p-2"
    >
      <div class="flex flex-col gap-2">
        <MultiSelect
          id="categories"
          v-model="selectedCategories"
          class="w-full"
          option-label="name"
          placeholder="Select Categories"
          :max-selected-labels="1"
          :options="props.categories"
        />
      </div>
      <div
        v-show="isLoggedIn"
        class="flex flex-col gap-2"
      >
        <div class="flex flex-col items-center w-full">
          <SelectButton
            v-model="visited"
            :options="visitedOptions"
            option-label="name"
            aria-labelledby="visited places"
          />
        </div>
      </div>
      <div class="flex flex-row gap-2 justify-end">
        <Button
          label="Clear"
          outlined
          @click="clearFilters"
        />
        <Button
          label="Search"
          @click="search"
        />
      </div>
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
            <Button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 text-xs rounded transition-colors duration-200">
              Visited
            </Button>
          </div>
        </div>
      </div>
      <InfiniteLoading
        v-if="lazyLoaderShow"
        @infinite="load"
      >
        <template #spinner>
          <div class="flex justify-center p-2">
            <ProgressSpinner
              aria-label="Loading"
              class="h-10 w-10"
            />
          </div>
        </template>
      </InfiniteLoading>
      <div
        v-else
        class="grid p-2 justify-items-center flex-grow max-h-fit"
      >
        <div>No more results.</div>
      </div>
    </div>
  </div>
</template>
