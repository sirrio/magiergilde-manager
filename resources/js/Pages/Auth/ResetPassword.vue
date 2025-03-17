<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
  email: string;
  token: string;
}>()

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <div class="card bg-base-100 mt-6">
      <div class="card-body">
        <form
          class="flex flex-col gap-3 max-w-md"
          @submit.prevent="submit"
        >
          <label class="form-control w-full ">
            <div class="label">
              <span class="label-text">Email</span>
            </div>
            <input
              v-model="form.email"
              type="text"
              placeholder="someone@mail.com"
              required
              autofocus
              autocomplete="username"
              class="input"
            >
          </label>

          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Password</span>
            </div>
            <input
              v-model="form.password"
              type="password"
              placeholder="****"
              required
              autocomplete="new-password"
              class="input"
            >
          </label>

          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Confirm Password</span>
            </div>
            <input
              v-model="form.password_confirmation"
              type="password"
              placeholder="****"
              required
              autocomplete="new-password"
              class="input"
            >
          </label>

          <button
            class="btn btn-neutral w-full"
            :disabled="form.processing"
          >
            Reset Password
          </button>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
