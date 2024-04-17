<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/vue3';

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>();
</script>

<template>
  <Head title="Profile"/>

  <AuthenticatedLayout>
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="prose mb-12">
          <h2>Profile</h2>
          <p>Edit your settings here</p>
        </div>

        <div class="flex flex-col gap-6">
          <UpdateProfileInformationForm
            :must-verify-email="mustVerifyEmail"
            :status="status"
          />

          <UpdatePasswordForm/>

          <DeleteUserForm/>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
