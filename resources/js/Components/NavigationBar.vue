<script setup>
import {computed, ref} from 'vue';
import {Link, router, usePage} from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';

const page = usePage();
const user = computed(() => page.props.auth.user);
const toast = useToast();
const mobileMenuOpen = ref(false);

const leftItems = computed(() =>
    endMenuItems.value[0].items.filter((item) => item.justify === 'start')
);
const rightItems = computed(() =>
    endMenuItems.value[0].items.filter((item) => item.justify === 'end')
);

const items = ref([
    { label: 'New', icon: 'pi pi-fw pi-plus' },
    { label: 'Delete', icon: 'pi pi-fw pi-trash' }
]);

const visibleMenuItems = computed(() => {
    return [...endMenuItems.value[0].items].filter(item => item.visible);
});

const handleMenuItemClick = (item) => {
    mobileMenuOpen.value = false;
    if (item.command) {
        item.command();
    }
};

const endMenuItems = computed(() => [
    {
        label: 'User options',
        items: [
            {
                label: 'Main page',
                icon: 'pi pi-user',
                justify: 'start',
                visible: user.value !== null,
                disabled: route().current('index'),
                route: '/',
            },
            {
                label: 'Admin Panel',
                icon: 'pi pi-user-edit',
                justify: 'start',
                visible: user.value !== null,
                disabled: route().current('admin'),
                route: '/admin',
            },
            {
                label: 'Log In',
                icon: 'pi pi-sign-in',
                justify: 'end',
                visible: user.value == null,
                disabled: route().current('login'),
                route: '/login',
            },
            {
                label: 'Settings',
                icon: 'pi pi-user-edit',
                justify: 'end',
                visible: user.value !== null,
                disabled: route().current('profile.show'),
                route: '/user/profile',
            },
            {
                label: 'Log Out',
                icon: 'pi pi-sign-out',
                justify: 'end',
                visible: user.value !== null,
                command: () => {
                    router.post(route('logout'));
                    toast.add({severity: 'success', detail: 'Logged out successfully'});
                },
            },
        ],
    },
]);
</script>



<template>
  <nav class="flex justify-between items-center bg-gray-800 text-white p-4">
    <div class="flex gap-10 pl-10 items-center">
      <i class="pi pi-map" />
      <div class="hidden md:flex md:gap-3">
        <template
          v-for="item in leftItems"
          :key="item.label"
        >
          <button
            v-if="item.visible && item.command"
            :disabled="item.disabled"
            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
            @click="item.command"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </button>
          <Link
            v-else-if="item.visible"
            :href="item.route"
            :class="{'opacity-50': item.disabled}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </div>
    </div>

    <div class="flex gap-3 pr-10 items-center">
      <button
        class="text-white focus:outline-none md:hidden"
        @click="mobileMenuOpen = !mobileMenuOpen"
      >
        <i class="pi pi-bars" />
      </button>
      <div class="hidden md:flex md:gap-3">
        <template
          v-for="item in rightItems"
          :key="item.label"
        >
          <button
            v-if="item.visible && item.command"
            :disabled="item.disabled"
            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
            @click="item.command"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </button>
          <Link
            v-else-if="item.visible"
            :href="item.route"
            :class="{'opacity-50': item.disabled}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div
    v-if="mobileMenuOpen"
    class="md:hidden bg-white absolute w-full shadow"
  >
    <template
      v-for="item in visibleMenuItems"
      :key="item.label"
    >
      <Link
        v-if="item.route"
        :href="item.route"
        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
        @click="mobileMenuOpen=false"
      >
        <div class="flex gap-3 items-center">
          <i :class="item.icon" />
          {{ item.label }}
        </div>
      </Link>

      <button
        v-if="item.command"
        class="w-full flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
        @click="handleMenuItemClick(item)"
      >
        <div class="flex gap-3 items-center">
          <i :class="item.icon" /> {{ item.label }}
        </div>
      </button>
    </template>
  </div>
</template>

