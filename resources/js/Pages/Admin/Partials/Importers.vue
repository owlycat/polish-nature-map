<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import MultiSelect from 'primevue/multiselect';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  availableImporters: Array,
});

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

  <div>
    <Button
        label="Import"
        @click="runImporters"
    />
    <MultiSelect
        v-model="form.importers"
        option-label="name"
        placeholder="Select Importers"
        :options="props.availableImporters"
    />
    <template
        v-for="error in form.errors"
        :key="error"
    >
      <InputError :message="error" />
    </template>
  </div>
</template>
