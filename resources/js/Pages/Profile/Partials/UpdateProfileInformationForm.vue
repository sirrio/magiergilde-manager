<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3'

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>()

const user = usePage().props.auth.user

const form = useForm({
  name: user.name,
  email: user.email,
})
</script>

<template>
  <section>
    <div class="card bg-base-100 text-base-content">
      <div class="card-body">
        <div class="card-title">
          <h2>Update your account's profile information and email address.</h2>
        </div>

        <form
          class="flex flex-col gap-3 max-w-md"
          @submit.prevent="form.patch(route('profile.update'))"
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

          <label class="form-control w-full ">
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

          <!--          <div v-if="mustVerifyEmail && user.email_verified_at === null">-->
          <!--            <p class="text-sm mt-2 text-gray-800">-->
          <!--              Your email address is unverified.-->
          <!--              <Link-->
          <!--                :href="route('verification.send')"-->
          <!--                method="post"-->
          <!--                as="button"-->
          <!--                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
          <!--              >-->
          <!--                Click here to re-send the verification email.-->
          <!--              </Link>-->
          <!--            </p>-->

          <!--            <div-->
          <!--              v-show="status === 'verification-link-sent'"-->
          <!--              class="mt-2 font-medium text-sm text-green-600"-->
          <!--            >-->
          <!--              A new verification link has been sent to your email address.-->
          <!--            </div>-->
          <!--          </div>-->

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
