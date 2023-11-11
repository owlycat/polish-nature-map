<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import Socialstream from '@/Components/Socialstream.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <Head title="Log in" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600"
    >
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="email">Email</label>
          <InputText
            id="email"
            v-model="form.email"
            placeholder="E-mail address"
            :class="{ 'p-invalid': form.errors.email }"
            type="email"
            required
            autocomplete="email"
            class="mt-1 block w-full"
            @input="form.errors.email = ''"
          />
          <InputError
            :message="form.errors.email"
            class="mt-2"
          />
        </div>
      </div>

      <!-- Password -->
      <div class="col-span-6 sm:col-span-4 mt-4">
        <div class="flex flex-col gap-2">
          <label for="password">Password</label>
          <InputText
            id="password"
            v-model="form.password"
            placeholder="Password"
            :class="{ 'p-invalid': form.errors.password }"
            type="password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full"
            @input="form.errors.password = ''"
          />
          <InputError
            :message="form.errors.password"
            class="mt-2"
          />
        </div>
      </div>

      <!-- Remember Me -->
      <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox
            v-model:checked="form.remember"
            name="remember"
          />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Forgot your password?
        </Link>

        <Button
          type="submit"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          label="Log in"
          class="ml-4"
        />
      </div>
    </form>

    <Socialstream
      v-if="$page.props.socialstream.show && $page.props.socialstream.providers.length"
      :error="$page.props.errors.socialstream"
      :prompt="$page.props.socialstream.prompt"
      :labels="$page.props.socialstream.labels"
      :providers="$page.props.socialstream.providers"
    />
  </AuthenticationCard>
</template>

