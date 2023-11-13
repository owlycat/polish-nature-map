<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

const page = usePage();
const user = computed(() => page.props.auth.user);
const toast = useToast();

const menuItems = computed(() => [
  {
    label: 'Importers',
    icon: 'pi pi-download',
    visible: user.value !== null,
    disabled: route().current('admin.importers.index'),
    route: '/admin/importers',
  },
  {
    label: 'Categories',
    icon: 'pi pi-list',
    visible: user.value !== null,
    disabled: route().current('admin.categories.index'),
    route: '/admin/categories',
  },
  {
    label: 'Statistics',
    icon: 'pi pi-chart-line',
    visible: user.value !== null,
    disabled: route().current('admin.statistics.index'),
    route: '/admin/statistics',
  }
]);
</script>

<template>
  <nav class="flex justify-between items-center bg-surface-a p-2">
    <div class="flex gap-2 pl-2 sm:gap-10 sm:pl-10 items-center">
      <div class="flex md:gap-3 flex-wrap items-center justify-center gap-2">
        <template v-for="item in menuItems" :key="item.label">
          <Link
              v-if="item.visible"
              :href="item.route"
              :class="{'border-b-2 border-primary': item.disabled}"
              class="flex items-center px-2 py-1 sm:px-3 sm:py-2 hover:border-b-2"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </div>
    </div>
  </nav>
</template>
