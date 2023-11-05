<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';
import MultiSelect from 'primevue/multiselect';

const toast = useToast();

const props = defineProps({
    availableImporters: Array,
});

const importers = ref([]);

const form = useForm({
    importers: [],
});

const runImporters = () => {
    form.put(route('admin.importers.run'), {
        errorBag: 'runImporters',
        preserveScroll: true,
    });
};

</script>
<template>
    <Head title="Import Features" />

    <Button label="Import" @click="runImporters" />
    <MultiSelect v-model="form.importers" optionLabel="name" placeholder="Select Importers" :options="props.availableImporters" />
    <div v-if="form.errors.importers">{{ form.errors.importers }}</div>
</template>
