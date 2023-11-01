<script setup>
import { Head } from '@inertiajs/vue3';
import Toast from 'primevue/toast';

defineProps({
    title: String,
});
</script>

<template>
  <Head :title="title" />
  <Toast position="bottom-right" />
  
  <slot />
</template>
