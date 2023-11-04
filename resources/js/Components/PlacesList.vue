<script setup>
import Card from 'primevue/card';
</script>
<template>
  <div class="bg-white rounded border md:max-w-md w-full md:w-screen flex flex-col h-full">
    <Card class="sticky top-0 z-10">
      <template #title>
        (( Search component ))
      </template>
    </Card>
    <div class="overflow-y-auto flex-grow max-h-fit">
        <div
          v-for="n in 100"
          :key="n"
        >
          <div class="flex items-center bg-white rounded-lg shadow-md border overflow-hidden hover:bg-surface-100 p-3">
            <img class="h-20 w-20 object-cover rounded-lg opacity-60" src="/images/place-default-thumbnail.png" alt="Place">

            <div class="flex-grow p-2">
              <h3 class="font-semibold text-lg">Some place {{ n }}</h3>
              <p class="text-sm text-gray-600">National park</p>
            </div>
            <div>
              <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 text-xs rounded transition-colors duration-200">
                Visited
              </button>
            </div>
          </div>
        </div>
    </div>
    <Card class="sticky bottom-0 z-10">
      <template #title>
        (( Pagination component ))
      </template>
    </Card>
  </div>
</template>
