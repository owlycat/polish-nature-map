<script setup>
import {computed, ref} from 'vue';
import {Link, router, usePage} from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';

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
        disabled: route().current('admin.*'),
        route: '/admin/importers',
      },
      {
        label: 'My Map',
        icon: 'pi pi-bookmark',
        justify: 'end',
        visible: user.value != null,
        disabled: route().current('map.me'),
        route: '/map/me',
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
  <nav class="flex justify-between items-center bg-primary text-white p-2 z-50">
    <div class="flex gap-2 pl-2 sm:gap-10 sm:pl-10 items-center">
      <Link
        class="w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center rounded-md hover:bg-highlight-text-color"
        :href="'/'"
      >
        <i class="pi pi-map" />
      </Link>
      <div class="hidden md:flex md:gap-3">
        <template
          v-for="item in leftItems"
          :key="item.label"
        >
          <button
            v-if="item.visible && item.command"
            :disabled="item.disabled"
            class="flex items-center px-2 py-1 sm:px-3 sm:py-2 rounded-md hover:bg-highlight-text-color transition-colors"
            @click="item.command"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </button>
          <Link
            v-else-if="item.visible"
            :href="item.route"
            :class="{'opacity-50': item.disabled}"
            class="flex items-center px-2 py-1 sm:px-3 sm:py-2 rounded-md hover:bg-highlight-text-color transition-colors"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </div>
    </div>

    <div class="flex gap-2 pr-2 sm:gap-3 sm:pr-10 items-center">
      <button
        class="w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center rounded-md hover:bg-highlight-text-color text-white focus:outline-none md:hidden"
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
            class="flex items-center px-2 py-1 sm:px-3 sm:py-2 rounded-md hover:bg-highlight-text-color transition-colors"
            @click="item.command"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </button>
          <Link
            v-else-if="item.visible"
            :href="item.route"
            :class="{'opacity-50': item.disabled}"
            class="flex items-center px-2 py-1 sm:px-3 sm:py-2 rounded-md hover:bg-highlight-text-color transition-colors"
          >
            <i :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div>
    <transition name="slide-fade">
      <div
        v-if="mobileMenuOpen"
        class="md:hidden bg-white absolute w-full shadow z-40"
      >
        <template
          v-for="item in visibleMenuItems"
          :key="item.label"
        >
          <Link
            v-if="item.route"
            :href="item.route"
            class="flex items-center px-3 py-2 rounded-md hover:bg-surface-100 transition-colors"
            @click="mobileMenuOpen=false"
          >
            <div class="flex gap-3 items-center">
              <i :class="item.icon" />
              {{ item.label }}
            </div>
          </Link>

          <button
            v-if="item.command"
            class="w-full flex items-center px-3 py-2 rounded-md hover:bg-surface-100 transition-colors"
            @click="handleMenuItemClick(item)"
          >
            <div class="flex gap-3 items-center">
              <i :class="item.icon" /> {{ item.label }}
            </div>
          </button>
        </template>
      </div>
    </transition>
  </div>
</template>

<style scoped>
/* Define initial state for enter and leave */
.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-100%); /* Start above the screen */
  opacity: 0;
}

/* Define end state for enter, and initial state for leave */
.slide-fade-enter-to,
.slide-fade-leave-from {
  transform: translateY(0);
  opacity: 1;
}

/* Define active state for enter and leave */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}
</style>
