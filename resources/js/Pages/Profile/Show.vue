<script setup>
import ConnectedAccountsForm from '@/Pages/Profile/Partials/ConnectedAccountsForm.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SetPasswordForm from '@/Pages/Profile/Partials/SetPasswordForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import Divider from 'primevue/divider';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
  <div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div v-if="$page.props.jetstream.canUpdateProfileInformation">
        <UpdateProfileInformationForm :user="$page.props.auth.user" />

        <Divider />
      </div>

      <div v-if="$page.props.jetstream.canUpdatePassword && $page.props.socialstream.hasPassword">
        <UpdatePasswordForm class="mt-10 sm:mt-0" />

        <Divider />
      </div>

      <div v-else>
        <SetPasswordForm class="mt-10 sm:mt-0" />

        <Divider />
      </div>

      <div
        v-if="$page.props.jetstream.canManageTwoFactorAuthentication && $page.props.socialstream.hasPassword"
      >
        <TwoFactorAuthenticationForm
          :requires-confirmation="confirmsTwoFactorAuthentication"
          class="mt-10 sm:mt-0"
        />

        <Divider />
      </div>

      <div v-if="$page.props.socialstream.show">
        <ConnectedAccountsForm class="mt-10 sm:mt-0" />
      </div>

      <div v-if="$page.props.socialstream.hasPassword">
        <Divider />

        <LogoutOtherBrowserSessionsForm
          :sessions="sessions"
          class="mt-10 sm:mt-0"
        />
      </div>

      <template
        v-if="$page.props.jetstream.hasAccountDeletionFeatures && $page.props.socialstream.hasPassword"
      >
        <Divider />

        <DeleteUserForm class="mt-10 sm:mt-0" />
      </template>
    </div>
  </div>
</template>
