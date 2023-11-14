<script setup>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

defineProps({
    visible: Boolean,
    place: Object,
});

defineEmits(['update:visible']);
</script>

<template>
    <Dialog :visible="visible" @hide="() => $emit('update:visible', false)" modal header="Header" :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <template #header>
            <div class="inline-flex align-items-center justify-content-center gap-2">
                <Avatar image="/images/place-default-thumbnail.png" shape="circle" />
                <span class="font-bold white-space-nowrap">{{ place.name }}</span>
            </div>
        </template>
        <p class="m-0">
            {{ place.description }}
        </p>
        <template #footer>
            <Button label="Close" icon="pi pi-check" @click="() => $emit('update:visible', false)" autofocus />
        </template>
    </Dialog>
</template>