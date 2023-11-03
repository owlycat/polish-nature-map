<script setup>
import { Head } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';
import PlacesList from "@/Components/PlacesList.vue";

const toast = useToast();
</script>

<template>
  <Head title="Welcome" />
    <div class="flex-grow flex overflow-y-auto h-screen">
        <PlacesList />
        <div class="h-full w-full"> Map component </div>
    </div>
</template>

