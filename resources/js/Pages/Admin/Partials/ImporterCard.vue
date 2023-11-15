<script setup>
import Card from 'primevue/card';
import InlineMessage from 'primevue/inlinemessage';
import Button from 'primevue/button';
</script>

<template>

<Card>
    <template #title> national_park </template>
    <template #subtitle>
        <div class="flex justify-between items-center flex-wrap">
            <span>Last update: 2 days ago</span>
            <InlineMessage severity="success" class="h-9" >Success</InlineMessage>
        </div>
    </template>
    <template #content>
        <Button class="w-full" label="Run importer" icon="pi pi-sync" size="small"  />
    </template>
</Card>
<Card>
    <template #title> landscape_park </template>
    <template #subtitle>
        <div class="flex justify-between items-center flex-wrap">
            <span>Last update: 1 day ago</span>
            <InlineMessage severity="error" class="h-9" >Failed</InlineMessage>
        </div>
    </template>
    <template #content>
        <Button class="w-full" label="Run importer" icon="pi pi-sync" size="small"  />
    </template>
</Card>

<Card>
    <template #title> national_monument </template>
    <template #subtitle>
        <div class="flex justify-between items-center flex-wrap">
            <span>Last update: 1 day ago</span>
            <InlineMessage severity="info" class="h-9" >Working</InlineMessage>
        </div>
    </template>
    <template #content>
        <Button class="w-full" disabled label="Run importer" icon="pi pi-sync" size="small"  />
    </template>
</Card>

</template>