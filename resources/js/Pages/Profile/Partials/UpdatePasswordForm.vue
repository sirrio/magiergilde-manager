<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import {ref} from 'vue'

const passwordInput = ref<HTMLInputElement | null>(null)
const currentPasswordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const updatePassword = () => {
  form.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation')
        passwordInput.value?.focus()
      }
      if (form.errors.current_password) {
        form.reset('current_password')
        currentPasswordInput.value?.focus()
      }
    },
  })
}
</script>

<template>
  <section>
    <div class="card bg-base-100 text-base-content">
      <div class="card-body">
        <div class="card-title">
          <h2>Update Password.</h2>
        </div>

        <form
          class="flex flex-col gap-3 max-w-md"
          @submit.prevent="updatePassword"
        >
          <p class="text-sm">
            Ensure your account is using a long, random password to stay secure.
          </p>

          <label class="form-control w-full ">
            <div class="label">
              <span class="label-text">Current Password</span>
            </div>
            <input
              v-model="form.current_password"
              type="password"
              placeholder="****"
              autocomplete="current-password"
              class="input input-bordered w-full"
            >
          </label>

          <label class="form-control w-full ">
            <div class="label">
              <span class="label-text">New Password</span>
            </div>
            <input
              v-model="form.password"
              type="password"
              placeholder="****"
              autocomplete="new-password"
              class="input input-bordered w-full"
            >
          </label>

          <label class="form-control w-full ">
            <div class="label">
              <span class="label-text">Confirm Password</span>
            </div>
            <input
              v-model="form.password_confirmation"
              type="password"
              placeholder="****"
              autocomplete="new-password"
              class="input input-bordered w-full"
            >
          </label>

          <button
            class="btn btn-neutral"
            :disabled="form.processing"
          >
            Save
          </button>
        </form>
      </div>
    </div>
  </section>
</template>
