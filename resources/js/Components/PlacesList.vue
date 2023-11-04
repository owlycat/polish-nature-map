<script setup>
import Card from 'primevue/card';
</script>
<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-96 flex flex-col h-full">
    <Card class="sticky top-0 z-10">
      <template #title>
        (( Search component ))
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
    <Card class="sticky bottom-0 z-10">
      <template #title>
        (( Pagination component ))
      </template>
    </Card>
  </div>
</template>
