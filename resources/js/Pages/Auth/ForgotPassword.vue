<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'

import { Head, useForm } from '@inertiajs/vue3'

defineProps<{
  status?: string;
}>()

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template>
  <GuestLayout>
    <Head title="Forgot Password" />

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600"
    >
      {{ status }}
    </div>

    <div class="card bg-base-100 mt-6">
      <div class="card-body">
        <form
          class="flex flex-col gap-3 max-w-md"
          @submit.prevent="submit"
        >
          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Email</span>
            </div>
            <input
              v-model="form.email"
              type="text"
              placeholder="someone@mail.de"
              required
              autofocus
              autocomplete="username"
              class="input input-bordered w-full"
            >
          </label>

          <button
            class="btn btn-neutral"
            :disabled="form.processing"
          >
            Email Password Reset Link
          </button>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
