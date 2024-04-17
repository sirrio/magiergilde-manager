<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import {ref} from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
  password: '',
})

const confirmDeleteModal = ref()

const deleteUser = () => {
  form.delete(route('profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value?.focus(),
    onFinish: () => {
      form.reset()
    },
  })
}

const closeModal = () => {
  confirmingUserDeletion.value = false

  form.reset()
}
</script>

<template>
  <section class="space-y-6">
    <div class="card bg-base-100 text-base-content">
      <div class="card-body">
        <div class="flex flex-col gap-3 max-w-md">
          <div class="card-title">
            <h2>Delete Account</h2>
          </div>

          <p class="text-sm">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
            your account, please download any data or information that you wish to retain.
          </p>

          <button
            class="btn btn-error"
            @click="confirmDeleteModal.showModal()"
          >
            Delete Account
          </button>
        </div>

        <dialog
          ref="confirmDeleteModal"
          class="modal"
        >
          <div class="modal-box">
            <form method="dialog">
              <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
                ✕
              </button>
            </form>
            <h3 class="font-bold text-lg">
              Are you sure you want to delete your account?
            </h3>

            <p class="mt-1 text-sm">
              Once your account is deleted, all of its resources and data will be permanently deleted. Please
              enter your password to confirm you would like to permanently delete your account.
            </p>

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
                @keyup.enter="deleteUser"
              >
            </label>

            <button
              class="btn btn-error mt-3"
              :disabled="form.processing"
              @click="deleteUser"
            >
              Delete Account
            </button>
          </div>
        </dialog>
      </div>
    </div>
  </section>
</template>
