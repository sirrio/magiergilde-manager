<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <div class="card bg-base-100 mt-6">
      <div class="card-body">
        <form
          class="flex flex-col gap-3 max-w-md"
          @submit.prevent="submit"
        >
          <label class="form-control w-full ">
            <div class="label">
              <span class="label-text">Name</span>
            </div>
            <input
              v-model="form.name"
              type="text"
              placeholder="Peter"
              required
              autofocus
              autocomplete="name"
              class="input input-bordered w-full"
            >
          </label>

          <label class="form-control w-full">
            <div class="label">
              <span class="label-text">Email</span>
            </div>
            <input
              v-model="form.email"
              type="text"
              placeholder="someone@mail.com"
              required
              autocomplete="username"
              class="input input-bordered w-full"
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
              class="input input-bordered w-full"
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
              class="input input-bordered w-full"
            >
          </label>

          <button
            class="btn btn-neutral w-full mt-2"
            :disabled="form.processing"
          >
            Register
          </button>

          <Link
            :href="route('login')"
            class="underline text-xs"
          >
            Already registered?
          </Link>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
