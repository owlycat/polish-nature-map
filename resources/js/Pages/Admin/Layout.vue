<script setup>
import TabMenu from '@/Pages/Admin/Partials/TabMenu.vue';
import Panel from 'primevue/panel';

defineProps({
  header: String,
});
</script>

<template>

    <TabMenu />
    <div class="max-w-7xl mx-auto w-full sm:py-10 sm:px-6 lg:px-8">
      <Panel :header="header">
        <slot />
      </Panel>
    </div>
</template>
