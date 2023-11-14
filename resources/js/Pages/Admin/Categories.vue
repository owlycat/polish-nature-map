<script setup>
import Layout from "@/Pages/Admin/Layout.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import {ref} from "vue";                   // optional

const categories = ref([
  {
    id: 1,
    name: 'Category 1',
    image: '/images/place-default-thumbnail.png',
    display_name: 'Category 1',
    created_at: '2021-08-01 12:00:00',
    updated_at: '2021-08-01 12:00:00',
  },
  {
    id: 2,
    name: 'Category 2',
    image: '/images/place-default-thumbnail.png',
    display_name: 'Category 2',
    created_at: '2021-08-01 12:00:00',
    updated_at: '2021-08-01 12:00:00',
  },
  {
    id: 3,
    name: 'Category 3',
    image: '/images/place-default-thumbnail.png',
    display_name: 'Category 3',
    created_at: '2021-08-01 12:00:00',
    updated_at: '2021-08-01 12:00:00',
  },
  {
    id: 4,
    name: 'Category 4',
    image: '/images/place-default-thumbnail.png',
    display_name: 'Category 4',
    created_at: '2021-08-01 12:00:00',
    updated_at: '2021-08-01 12:00:00',
  },
  {
    id: 5,
    name: 'Category 5',
    image: '/images/place-default-thumbnail.png',
    display_name: 'Category 5',
    created_at: '2021-08-01 12:00:00',
    updated_at: '2021-08-01 12:00:00',
  },
]);

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
              <img :src="`${slotProps.data.image}`" :alt="slotProps.data.image" class="w-12" />
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
