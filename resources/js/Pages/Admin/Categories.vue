<script setup>
import Layout from "@/Pages/Admin/Layout.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import { router } from '@inertiajs/vue3'

import {ref} from "vue"; 

const props = defineProps({
    categories: Array,
});


const onRowEditSave = (event) => {
  let { newData, index } = event;

  categories.value[index] = newData;
};

const editingRows = ref([]);

</script>

<template>
  <Layout header="Categories">
    <DataTable v-model:editingRows="editingRows" :value="categories" editMode="row" dataKey="id" @row-edit-save="onRowEditSave">
          <Column field="id" header="ID"></Column>
          <Column field="name" header="Name"></Column>
          <Column field="image" header="Image">
            <template #body="slotProps">
              <img :src="slotProps.data.image ? slotProps.data.image : '/images/place-default-thumbnail.png'" :alt="slotProps.data.image" :class="slotProps.data.image ? 'w-12' : 'grayscale w-12'" />
            </template>
          </Column>
          <Column field="display_name" header="Display name">
            <template #editor="{ data, field }">
              <InputText v-model="data[field]" />
            </template>
          </Column>
          <Column field="created_at" header="Created at"></Column>
          <Column field="updated_at" header="Updated at"></Column>
          <Column :rowEditor="true"></Column>
        </DataTable>
  </Layout>
</template>
