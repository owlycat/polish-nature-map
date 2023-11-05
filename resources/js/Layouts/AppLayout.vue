<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import NavigationBar from '@/Components/NavigationBar.vue';
import { useToast } from 'primevue/usetoast';
import { ref, watchEffect } from 'vue';

const toast = useToast();
const inertiaPage = usePage();

defineProps({
    title: String,
});

const user = ref(null);
const subscription = ref(null);

watchEffect(async () => {
  user.value = inertiaPage.props.auth.user;

  if (subscription.value != null) {
    Echo.leaveChannel(subscription.value.name);
    subscription.value = null;
  }

  if (user.value != null) {
    subscription.value = Echo.channel(`user-message.${user.value.id}`)
      .listen('SendMessageEvent', (e) => {
        toast.add({
          severity: e.messageType,
          summary: 'New Message',
          detail: e.message,
          life: 5000,
        });
      });
  }
});
</script>

<template>
  <Head :title="title" />
  <Toast position="bottom-right" />

  <div class="flex flex-col h-screen">
    <div class="sticky top-0 z-20">
      <NavigationBar />
    </div>
    <div class="flex flex-col overflow-y-auto">
      <slot />
    </div>
  </div>
</template>
