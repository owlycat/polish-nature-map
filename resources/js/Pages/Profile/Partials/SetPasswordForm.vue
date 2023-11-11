<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const passwordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const setPassword = () => {
    form.post(route('user-password.set'), {
        errorBag: 'setPassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
        },
    });
};
</script>


<template>
  <FormSection @submitted="setPassword">
    <template #title>
      Set Password
    </template>

    <template #description>
      Ensure your account is using a long, random password to stay secure.
    </template>

    <template #form>
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
            autocomplete="new-password"
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
            autocomplete="new-password"
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
        class="mr-3"
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

