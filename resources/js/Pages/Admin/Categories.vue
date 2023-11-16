<script setup>
import Layout from '@/Pages/Admin/Layout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import { router } from '@inertiajs/vue3'
import {ref} from 'vue';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const props = defineProps({
    categories: Array,
});

const onRowEditSave = (event) => {
  router.put(route('admin.categories.update', event.data.id), event.newData);
};

const editingRows = ref([]);

const handleImageUpload = async (category) => {
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*';
  input.onchange = async (e) => {
    const file = e.target.files[0];

    if (file) {
      const formData = new FormData();
      formData.append('image', file);

      try {
        const response = await axios.post(route('admin.categories.uploadImage', category.id), formData);
        category.image = `${response.data.image}?timestamp=${new Date().getTime()}`;
        toast.add({
          severity: response.data.severity,
          summary: response.data.title,
          detail: response.data.message,
          life: 3000,
        });
      } catch (error) {
        toast.add({
          severity: 'error',
          summary: 'Error',
          detail: 'Error uploading image',
          life: 3000,
        });
      }
    }
  };

  input.click();
};
</script>

<template>
  <Layout header="Categories">
    <DataTable
      v-model:editingRows="editingRows"
      :value="props.categories"
      edit-mode="row"
      data-key="id"
      @row-edit-save="onRowEditSave"
    >
      <Column
        field="id"
        header="ID"
      />
      <Column
        field="name"
        header="Name"
      />
      <Column
        field="image"
        header="Image"
      >
        <template #body="slotProps">
          <img
            :src="slotProps.data.image ? '/storage/images/' + slotProps.data.image : '/images/place-default-thumbnail.png'"
            :alt="slotProps.data.image"
            :class="slotProps.data.image ? 'w-12 cursor-pointer' : 'grayscale w-12 cursor-pointer'"
            @click="handleImageUpload(slotProps.data)"
          >
        </template>
      </Column>
      <Column
        field="display_name"
        header="Display name"
      >
        <template #editor="{ data, field }">
          <InputText v-model="data[field]" />
        </template>
      </Column>
      <Column
        field="created_at"
        header="Created at"
      />
      <Column
        field="updated_at"
        header="Updated at"
      />
      <Column :row-editor="true" />
    </DataTable>
  </Layout>
</template>
