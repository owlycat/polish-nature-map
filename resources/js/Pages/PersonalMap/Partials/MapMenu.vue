<script setup>
import InputText from 'primevue/inputtext';
import SelectButton from 'primevue/selectbutton';
import Button from 'primevue/button';
import Panel from 'primevue/panel';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import TotalsPanel from './TotalsPanel.vue';
import Avatar from 'primevue/avatar';

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

const privacySelection = ref(getPrivacyOption());
const newShareableName = ref(props.personalMap.name ?? '');

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
          Share your map with others by setting a shareable name and making it public.
        </p>
        <div class="flex pt-2">
          <span class="p-input-icon-left w-full">
            <i class="pi pi-pencil" />
            <InputText
              v-model="newShareableName"
              class="w-full"
              placeholder="Shareable name"
            />
          </span>
        </div>
        <div class="flex justify-between pt-4">
          <SelectButton
            v-model="privacySelection"
            :allow-empty="false"
            :options="privacyOptions"
            option-label="name"
            aria-labelledby="Map privacy"
          />
          <Button
            label="Apply"
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
