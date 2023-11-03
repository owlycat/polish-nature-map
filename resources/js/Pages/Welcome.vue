<script setup>
import { Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import PlacesList from '@/Components/PlacesList.vue';

const toast = useToast();
</script>

<template>
    <Head title="Welcome" />
    <div class="flex-grow flex overflow-y-auto h-screen md:flex-row flex-col-reverse">
        <div class="h-1/2 md:h-full">
            <PlacesList />
        </div>
        <div class="w-full h-1/2 md:h-full">
            Map component
        </div>
    </div>
</template>

