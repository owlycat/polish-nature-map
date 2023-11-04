<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';


const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
  <FormSection @submitted="updateProfileInformation">
    <template #title>
      Profile Information
    </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <template #form>
      <!-- Profile Photo -->
      <div
        v-if="$page.props.jetstream.managesProfilePhotos"
        class="col-span-6 sm:col-span-4"
      >
        <div class="flex flex-col items-center gap-3">
          <!-- Profile Photo File Input -->
          <input
            id="photo"
            ref="photoInput"
            type="file"
            class="hidden"
            @change="updatePhotoPreview"
          >

          <label for="photo">Profile photo</label>

          <!-- Current Profile Photo -->
          <div
            v-show="! photoPreview"
            class="mt-2"
          >
            <img
              :src="user.profile_photo_url"
              :alt="user.name"
              class="rounded-full h-full w-20 object-cover"
            >
          </div>

          <!-- New Profile Photo Preview -->
          <div
            v-show="photoPreview"
            class="mt-2"
          >
            <span
              class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
              :style="'background-image: url(\'' + photoPreview + '\');'"
            />
          </div>

          <div class="flex gap-3">
            <Button
              type="button"
              label="Select A New Photo"
              severity="secondary"
              outlined
              @click.prevent="selectNewPhoto"
            />


            <Button
              v-if="user.profile_photo_path"
              type="button"
              label="Remove Photo"
              severity="secondary"
              outlined
              @click.prevent="deletePhoto"
            />
          </div>

          <InputError
            :message="form.errors.photo"
            class="mt-2"
          />
        </div>
      </div>
      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="name">Name</label>
          <InputText
            id="name"
            v-model="form.name"
            placeholder="Name"
            :class="{ 'p-invalid': form.errors.name }"
            autocomplete="name"
            required
            @input="form.errors.name = ''"
          />
          <small v-if="form.errors.name">{{ form.errors.name }}</small>
        </div>
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <div class="flex flex-col gap-2">
          <label for="name">E-mail</label>
          <InputText
            id="email"
            v-model="form.email"
            placeholder="E-mail address"
            :class="{ 'p-invalid': form.errors.email }"
            type="email"
            required
            autocomplete="email"
            @input="form.errors.email = ''"
          />
          <small v-if="form.errors.email">{{ form.errors.email }}</small>
        </div>


        <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
          <p class="text-sm mt-2">
            Your email address is unverified.

            <Link
              :href="route('verification.send')"
              method="post"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              @click.prevent="sendEmailVerification"
            >
              Click here to re-send the verification email.
            </Link>
          </p>

          <div
            v-show="verificationLinkSent"
            class="mt-2 font-medium text-sm text-green-600"
          >
            A new verification link has been sent to your email address.
          </div>
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
