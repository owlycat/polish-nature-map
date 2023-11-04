<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Socialstream from '@/Components/Socialstream.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<template>
  <Head title="Register" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <form @submit.prevent="submit">
      <!-- Name -->
      <div class="mt-4">
        <InputLabel
          for="name"
          value="Name"
        />
        <InputText
          id="name"
          v-model="form.name"
          autocomplete="name"
          autofocus
          required
          type="text"
          class="mt-1 block w-full"
        />
        <InputError
          :message="form.errors.name"
          class="mt-2"
        />
      </div>

      <!-- Email -->
      <div class="mt-4">
        <InputLabel
          for="email"
          value="Email"
        />
        <InputText
          id="email"
          v-model="form.email"
          autocomplete="username"
          required
          type="email"
          class="mt-1 block w-full"
        />
        <InputError
          :message="form.errors.email"
          class="mt-2"
        />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <InputLabel
          for="password"
          value="Password"
        />
        <InputText
          id="password"
          v-model="form.password"
          autocomplete="new-password"
          required
          type="password"
          class="mt-1 block w-full"
        />
        <InputError
          :message="form.errors.password"
          class="mt-2"
        />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <InputLabel
          for="password_confirmation"
          value="Confirm Password"
        />
        <InputText
          id="password_confirmation"
          v-model="form.password_confirmation"
          autocomplete="new-password"
          required
          type="password"
          class="mt-1 block w-full"
        />
        <InputError
          :message="form.errors.password_confirmation"
          class="mt-2"
        />
      </div>

      <!-- Terms and Privacy Policy Agreement -->
      <div
        v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
        class="mt-4"
      >
        <InputLabel for="terms">
          <div class="flex items-center">
            <Checkbox
              id="terms"
              v-model:checked="form.terms"
              name="terms"
              required
            />
            <div class="ml-2">
              I agree to the
              <a
                :href="route('terms.show')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
                target="_blank"
              >Terms of Service</a>
              and
              <a
                :href="route('policy.show')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
                target="_blank"
              >Privacy Policy</a>
            </div>
          </div>
        </InputLabel>
        <InputError
          :message="form.errors.terms"
          class="mt-2"
        />
      </div>

      <!-- Registration and Already Registered -->
      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Already registered?
        </Link>

        <Button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          label="Register"
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
