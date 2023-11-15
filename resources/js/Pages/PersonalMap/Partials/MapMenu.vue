<script setup>
import InputText from 'primevue/inputtext';
import SelectButton from 'primevue/selectbutton';
import Button from 'primevue/button';
import Panel from 'primevue/panel';
import { computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import TotalsPanel from './TotalsPanel.vue';
import Avatar from 'primevue/avatar';
import InputError from '@/Components/InputError.vue';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    categories: Array,
    totals: Object,
    personalMap: Object,
    user: Object,
});

const isOwner = computed(() => {
    const page = usePage();

    if (page.props.auth.user === null) {
        return false;
    }
    return page.props.auth.user.id === props.personalMap.user_id;
});

const privacyOptions = [
    { name: 'Public', value: 'public' },
    { name: 'Private', value: 'private' },
];

function getPrivacyOption() {
    if (props.personalMap.is_public) {
        return privacyOptions[0];
    }

    return privacyOptions[1];
}

const form = useForm({
    privacy: getPrivacyOption(),
    name: props.personalMap.name ?? '',
    personal_map_id: props.personalMap.id,
});

const submitForm = () => {
    form.put(route('map.share'), {
        errorBag: 'mapShare',
        preserveScroll: true,
    })
};

const getLink = async () => {
    try {
        await navigator.clipboard.writeText(route('map', { name: props.personalMap.name }));
        toast.add({
            severity: 'success',
            summary: 'Link copied to clipboard',
            life: 3000,
        });
    } catch (err) {
        toast.add({
            severity: 'error',
            summary: 'Failed to copy link',
            detail: err.message,
            life: 3000,
        });
    }
};
</script>
<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-screen flex flex-col h-full">
    <div class="overflow-y-auto flex-grow max-h-fit p-4 flex flex-col gap-4">
      <Panel header="Map Owner">
        <div class="flex items-center">
          <Avatar
            :image="props.user.avatar_url"
            class="mr-2"
            size="xlarge"
            shape="circle"
            aria-labelledby="User Avatar"
          />
          <span class="font-semibold">{{ props.user.name }}</span>
        </div>
      </Panel>
      <Panel
        v-if="isOwner"
        header="Share Settings"
      >
        <p class="text-sm">
          Share your map with others by setting a shareable link name and making it public.
        </p>
        <div class="flex flex-col pt-2">
          <div class="flex">
            <span class="p-input-icon-left w-full">
              <i class="pi pi-pencil" />
              <InputText
                v-model="form.name"
                class="w-full"
                placeholder="Shareable name"
              />
            </span>
            <Button
              :disabled="!props.personalMap.is_public"
              aria-labelledby="Share link"
              icon="pi pi-link"
              @click="getLink()"
            />
          </div>
          <InputError :message="form.errors.name" />
        </div>
        <div class="flex justify-between pt-4">
          <SelectButton
            v-model="form.privacy"
            :allow-empty="false"
            :options="privacyOptions"
            option-label="name"
            aria-labelledby="Map privacy"
          />
          <Button
            label="Apply"
            type="submit"
            @click="submitForm"
          />
        </div>
      </Panel>
      <TotalsPanel
        label="Visited Places"
        :value="totals.visited"
        :max="totals.all"
      />
      <template
        v-for="(category, index) in categories"
        :key="index"
      >
        <TotalsPanel
          :label="category.name"
          :value="category.visited"
          :max="category.total"
        />
      </template>
    </div>
  </div>
</template>
