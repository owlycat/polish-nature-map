<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
  <ActionSection>
    <template #title>
      Delete Account
    </template>

    <template #description>
      Permanently delete your account.
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
      </div>

      <div class="mt-5">
        <Button
          type="button"
          label="Delete account"
          severity="danger"
          @click="confirmUserDeletion"
        />
      </div>

      <!-- Delete Account Confirmation Modal -->
      <DialogModal
        :show="confirmingUserDeletion"
        @close="closeModal"
      >
        <template #title>
          Delete Account
        </template>

        <template #content>
          Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

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
              label="Delete account"
              severity="danger"
              @click="deleteUser"
            />
          </div>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
