<script setup>
import { Head } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
</script>

<template>
  <Head title="Welcome" />
  <Button
    label="Toast"
    @click="toast.add({severity: 'info', summary: 'Info', detail: 'Toast test'})"
  />
</template>

