<script setup>
import { defineProps } from 'vue';
import Panel from 'primevue/panel';
import ProgressBar from 'primevue/progressbar';

const props = defineProps({
    label: String,
    value: Number,
    max: Number,
});

const percentage = (props.value / props.max) * 100;
</script>
<template>
  <Panel :header="label">
    <div class="flex flex-col items-end">
      <span class="text-xl">
        {{ value }} / {{ max }}
      </span>
      <ProgressBar
        class="w-full"
        :show-value="false"
        :value="percentage"
      />
    </div>
  </Panel>
</template>
