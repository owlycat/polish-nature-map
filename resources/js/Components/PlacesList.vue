<script setup>
import Card from 'primevue/card';
</script>
<template>
  <div class="bg-white rounded border max-w-md w-full flex flex-col h-full">
    <Card class="sticky top-0 z-20">
      <template #title>
        Search
      </template>
      <template #content>
        <p class="m-0">
          test
        </p>
      </template>
    </Card>
    <div class="overflow-y-auto flex-grow max-h-fit">
      <ul>
        <li
          v-for="n in 100"
          :key="n"
        >
          Item {{ n }}
        </li>
      </ul>
    </div>
    <Card class="sticky bottom-0 z-20">
      <template #title>
        next page, previous page
      </template>
    </Card>
  </div>
</template>
