<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps<{
  canResetPassword?: boolean;
  status?: string;
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-warning"
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
              autocomplete="current-password"
              class="input"
            >
          </label>

          <div class="form-control w-full">
            <label class="label cursor-pointer">
              <span class="label-text">Remember me</span>
              <input
                v-model="form.remember"
                type="checkbox"
                class="checkbox"
              >
            </label>
          </div>

          <button
            class="btn bg-neutral text-neutral-content w-full"
            :disabled="form.processing"
            @click="submit"
          >
            Log in
          </button>
        </form>

        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-xs"
        >
          Forgot your password?
        </Link>
        <Link
          :href="route('register')"
          class="underline text-xs"
        >
          No account yet? Register for free here.
        </Link>
      </div>
    </div>
  </GuestLayout>
</template>
