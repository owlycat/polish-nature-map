<script setup>
import {computed, ref} from 'vue';
import {Link, router, usePage} from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';

const page = usePage();
const user = computed(() => page.props.auth.user);
const toast = useToast();

const leftItems = computed(() =>
    endMenuItems.value[0].items.filter((item) => item.justify === 'start')
);
const rightItems = computed(() =>
    endMenuItems.value[0].items.filter((item) => item.justify === 'end')
);

const endMenuItems = computed(() => [
    {
        label: "User options",
        items: [
            {
                label: "Main page",
                icon: "pi pi-user",
                justify: "start",
                visible: user.value !== null,
                disabled: route().current("index"),
                route: "/",
            },
            {
                label: "Admin Panel",
                icon: "pi pi-user-edit",
                justify: "start",
                visible: user.value !== null,
                disabled: route().current("admin"),
                route: "/admin",
            },
            {
                label: "Log In",
                icon: "pi pi-sign-in",
                justify: "end",
                visible: user.value == null,
                disabled: route().current("login"),
                route: "/login",
            },
            {
                label: "Settings",
                icon: "pi pi-user-edit",
                justify: "end",
                visible: user.value !== null,
                disabled: route().current("profile.show"),
                route: "/user/profile",
            },
            {
                label: "Log Out",
                icon: "pi pi-sign-out",
                justify: "end",
                visible: user.value !== null,
                command: () => {
                    router.post(route("logout"));
                    toast.add({severity: 'success', detail: 'Logged out successfully'});
                },
            },
        ],
    },
]);
</script>

<template>
    <nav class="flex justify-between items-center bg-gray-800 text-white p-4">
        <div class="flex space-x-4">
            <!-- Left-aligned items -->
            <template v-for="item in leftItems" :key="item.label">
                <button
                    v-if="item.visible && item.command"
                    :disabled="item.disabled"
                    @click="item.command"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
                >
                    <i :class="item.icon"></i>
                    <span class="ml-2">{{ item.label }}</span>
                </button>
                <Link
                    v-else-if="item.visible"
                    :href="item.route"
                    :class="{'opacity-50': item.disabled}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
                >
                    <i :class="item.icon"></i>
                    <span class="ml-2">{{ item.label }}</span>
                </Link>
            </template>
        </div>
        <div class="flex space-x-4">
            <!-- Right-aligned items -->
            <template v-for="item in rightItems" :key="item.label">
                <button
                    v-if="item.visible && item.command"
                    :disabled="item.disabled"
                    @click="item.command"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
                >
                    <i :class="item.icon"></i>
                    <span class="ml-2">{{ item.label }}</span>
                </button>
                <Link
                    v-else-if="item.visible"
                    :href="item.route"
                    :class="{'opacity-50': item.disabled}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700 transition-colors"
                >
                    <i :class="item.icon"></i>
                    <span class="ml-2">{{ item.label }}</span>
                </Link>
            </template>
        </div>
    </nav>
</template>
