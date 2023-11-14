<script setup>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import { ref } from 'vue';

import { defineProps, defineEmits } from 'vue';

const props = defineProps(['visible', 'place']);
const emit = defineEmits();

const closeDialog = () => {
    emit('update:visible', false);
};

const emitCoordinates = () => {
    emit('showCoordinates', props.place._geo);
    emit('update:visible', false);
};
</script>

<template>
        <Dialog :visible="visible" modal header="Header" :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            @update:visible="closeDialog">
            <template #header>
                <div class="flex items-center justify-center gap-2">
                    <Avatar image="/images/place-default-thumbnail.png" shape="circle" />
                    <span class="font-bold">{{ props.place.name }}</span>
                </div>
            </template>
                <p class="m-0">
                        {{ props.place.description ? props.place.description : 'No description found' }}
                </p>
                <div class="mt-2 overflow-hidden overflow-ellipsis w-full" v-if="props.place.description_source">
                    <span class="font-bold">Source: </span>
                    <a :href="props.place.description_source" target="_blank" class="overflow-ellipsis overflow-hidden">{{ decodeURI(props.place.description_source) }}</a>
                </div>
                <div class="flex mt-4 flex-wrap gap-2 items-center">
                    <a :href="'https://www.google.com/search?q=' + props.place.name" target="_blank" class="border border-blue-500 hover:bg-blue-50 text-blue-500 font-semibold py-2 px-4 rounded">
                        <div class="flex gap-2 items-center">
                            <i class="pi pi-google"/>
                            <span>Google more information</span>
                        </div>
                    </a>
                </div>
                
            <template #footer>
                <button type="button" class="mt-3 border border-emerald-500 hover:bg-emerald-600 bg-emerald-500 text-white font-bold py-2 px-3 rounded text-sm" @click="emitCoordinates">
                    <div class="flex gap-2 items-center">
                        <i class="pi pi-map-marker"/>
                        <span>Show on map</span>
                    </div>
                </button>
                <button type="button" class="mt-3 border border-emerald-500 hover:bg-emerald-50 text-emerald-500 font-bold py-2 px-3 rounded text-sm" @click="closeDialog">
                    <div class="flex gap-2 items-center">
                        <i class="pi pi-times"/>
                        <span>Close</span>
                    </div>
                </button>
            </template>
        </Dialog>
</template>

