<script setup>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

import { defineProps, defineEmits } from 'vue';

const { visible, place } = defineProps(['visible', 'place']);
const emit = defineEmits();

const closeDialog = () => {
  emit('update:visible', false);
};
</script>

<template>
        <Dialog :visible="visible" modal header="Header" :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            @update:visible="closeDialog">
            <template #header>
                <div class="flex items-center justify-center gap-2">
                    <Avatar image="/images/place-default-thumbnail.png" shape="circle" />
                    <span class="font-bold">{{ place.name }}</span>
                </div>
            </template>
                <p class="m-0">
                        {{ place.description ? place.description : 'No description found' }}
                </p>
                <div class="flex mt-4 flex-wrap gap-2 items-center">
                    <a :href="'https://www.google.com/search?q=' + place.name" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        <div class="flex gap-2 items-center">
                            <i class="pi pi-google"/>
                            <span>Google more information</span>
                        </div>
                    </a>
                    <a target="_blank" :href="`https://www.google.com/maps/place/${place._geo[1]},${place._geo[0]}/@${place._geo[1]},${place._geo[0]},9z`" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded">
                        <div class="flex gap-2 items-center">
                            <i class="pi pi-map-marker"/>
                            <span>Show on Google Maps</span>
                        </div>
                    </a>
                </div>
                
            <template #footer>
                <Button label="Close" icon="pi pi-check" autofocus @click="closeDialog" />
            </template>
        </Dialog>
</template>