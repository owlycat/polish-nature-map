<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
  <FormSection @submitted="updatePassword">
    <template #title>
      Update Password
    </template>

    <template #description>
      Ensure your account is using a long, random password to stay secure.
    </template>

    <template #form>
      <!-- Current Password -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="current_password">Current Password</label>
          <InputText
            id="current_password"
            ref="currentPasswordInput"
            v-model="form.current_password"
            placeholder="Current Password"
            :class="{ 'p-invalid': form.errors.current_password }"
            type="password"
            autocomplete="current-password"
            required
            @input="form.errors.current_password = ''"
          />
          <small v-if="form.errors.current_password">{{ form.errors.current_password }}</small>
        </div>
      </div>

      <!-- New Password -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="password">New Password</label>
          <InputText
            id="password"
            ref="passwordInput"
            v-model="form.password"
            placeholder="New Password"
            :class="{ 'p-invalid': form.errors.password }"
            type="password"
            required
            @input="form.errors.password = ''"
          />
          <small v-if="form.errors.password">{{ form.errors.password }}</small>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="password_confirmation">Confirm Password</label>
          <InputText
            id="password_confirmation"
            v-model="form.password_confirmation"
            placeholder="Confirm Password"
            :class="{ 'p-invalid': form.errors.password_confirmation }"
            type="password"
            required
            @input="form.errors.password_confirmation = ''"
          />
          <small v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</small>
        </div>
      </div>
    </template>

    <template #actions>
      <ActionMessage
        :on="form.recentlySuccessful"
        class="me-3"
      >
        Saved.
      </ActionMessage>

      <Button
        type="submit"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        label="Save"
        icon="pi pi-check"
      />
    </template>
  </FormSection>
</template>

