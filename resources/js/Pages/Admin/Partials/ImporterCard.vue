<script setup>
import Card from 'primevue/card';
import InlineMessage from 'primevue/inlinemessage';
import Button from 'primevue/button';
import { computed, defineExpose, ref } from 'vue';
import {router} from '@inertiajs/vue3';

const props = defineProps({
  importer: Object,
});

function getClass() {
  return props.importer.class;
}

const statusState = ref(props.importer.status);
const timeState = ref(props.importer.timestamp);

function setStatus(status) {
    statusState.value = status;
}

function setTimeMessage(timeMessage) {
    timeState.value = timeMessage;
}

defineExpose({ getClass, setStatus, setTimeMessage });

const importerName = props.importer.class.split('\\').pop();

const timeMessage = computed(() => {
  return `At: ${timeState.value}`;
});

const messageText = computed(() => {
  switch (statusState.value) {
    case 'wait': return 'Waiting';
    case 'queued': return 'Queued';
    case 'running': return 'Running';
    case 'success': return 'Success';
    case 'failed': return 'Failed';
    case 'not_run': return 'Never run';
    default: return '';
  }
});

const messageSeverity = computed(() => {
  switch (statusState.value) {
    case 'success': return 'success';
    case 'failed': return 'error';
    case 'not_run': return 'warn';
    default: return 'info';
  }
});

const blockButton = computed(() => {
  return statusState.value === 'success' || statusState.value === 'not_run';
});

const runImporter = () => {
  router.post(route('admin.importers.run'), { importer: props.importer });
};

</script>

<template>
  <Card>
    <template #title>
      {{ importerName }}
    </template>
    <template #subtitle>
      <div class="flex justify-between items-center flex-wrap">
        <span>{{ timeMessage }}</span>
        <InlineMessage
          :severity="messageSeverity"
          class="h-9"
        >
          {{ messageText }}
        </InlineMessage>
      </div>
    </template>
    <template #content>
      <Button
        :disabled="! blockButton"
        class="w-full"
        label="Run importer"
        icon="pi pi-sync"
        size="small"
        @click="runImporter"
      />
    </template>
  </Card>
</template>
