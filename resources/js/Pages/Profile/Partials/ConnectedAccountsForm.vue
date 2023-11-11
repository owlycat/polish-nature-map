<script setup>
import {ref} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import ActionLink from '@/Components/ActionLink.vue';
import ActionSection from '@/Components/ActionSection.vue';
import ConnectedAccount from '@/Components/ConnectedAccount.vue';
import DialogModal from '@/Components/DialogModal.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const accountId = ref(null);
const confirmingRemoveAccount = ref(false);
const passwordInput = ref(null);

const page= usePage();

const form = useForm({
    password: '',
});

const getAccountForProvider = (provider) => page.props.socialstream.connectedAccounts
    .filter(account => account.provider === provider.id)
    .shift();


const setProfilePhoto = (id) => {
    form.put(route('user-profile-photo.set', { id }), {
        preserveScroll: true
    });
};

const confirmRemoveAccount = (id) => {
    accountId.value = id;

    confirmingRemoveAccount.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const removeAccount = () => {
    console.log(accountId);
    form.delete(route('connected-accounts.destroy', { id: accountId.value }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingRemoveAccount.value = false;

    form.reset();
};

</script>

<template>
  <ActionSection>
    <template #title>
      Connected Accounts
    </template>

    <template #description>
      Manage and remove your connected accounts.
    </template>

    <template #content>
      <h3
        v-if="$page.props.socialstream.connectedAccounts.length === 0"
        class="text-lg font-medium text-gray-900"
      >
        You have no connected accounts.
      </h3>
      <h3
        v-else
        class="text-lg font-medium text-gray-900"
      >
        Your connected accounts.
      </h3>

      <div class="mt-3 ax-w-xl text-sm text-gray-600">
        You are free to connect any social accounts to your profile and may remove any connected accounts at any
        time. If you feel any of your connected accounts have been compromised, you should disconnect them
        immediately and change your password.
      </div>

      <div class="mt-5 space-y-6">
        <div
          v-for="(provider) in $page.props.socialstream.providers"
          :key="provider"
        >
          <ConnectedAccount
            :provider="provider"
            :created-at="getAccountForProvider(provider)?.created_at"
          >
            <template #action>
              <template v-if="getAccountForProvider(provider)">
                <div class="flex items-center flex-wrap gap-3">
                  <Button
                    v-if="$page.props.jetstream.managesProfilePhotos && getAccountForProvider(provider).avatar_path"
                    type="button"
                    label="Use Avatar"
                    severity="secondary"
                    outlined
                    @click="setProfilePhoto(getAccountForProvider(provider).id)"
                  />

                  <Button
                    v-if="$page.props.socialstream.connectedAccounts.length > 1 || $page.props.socialstream.hasPassword"
                    type="button"
                    label="Remove"
                    severity="danger"
                    @click="confirmRemoveAccount(getAccountForProvider(provider).id)"
                  />
                </div>
              </template>

              <template v-else>
                <ActionLink :href="route('oauth.redirect', { provider })">
                  Connect
                </ActionLink>
              </template>
            </template>
          </ConnectedAccount>
        </div>
      </div>

      <!-- Confirmation Modal -->
      <DialogModal
        :show="confirmingRemoveAccount"
        @close="closeModal"
      >
        <template #title>
          Are you sure you want to remove this account?
        </template>

        <template #content>
          Please enter your password to confirm you would like to remove this account.

          <div class="mt-4">
            <div class="flex flex-col gap-2">
              <InputText
                id="password"
                ref="passwordInput"
                v-model="form.password"
                placeholder="Password"
                :class="{ 'p-invalid': form.errors.password }"
                type="password"
                required
                @input="form.errors.password = ''"
              />
              <small v-if="form.errors.password">{{ form.errors.password }}</small>
            </div>
          </div>
        </template>

        <template #footer>
          <div class="flex gap-3">
            <Button
              type="button"
              label="Cancel"
              severity="secondary"
              outlined
              @click="closeModal"
            />

            <Button
              type="button"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              label="Remove Account"
              severity="danger"
              @click="removeAccount"
            />
          </div>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
