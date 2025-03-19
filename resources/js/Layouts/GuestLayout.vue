<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
</script>

<template>
  <div class="bg-base-300 flex min-h-screen flex-col items-center justify-center">
    <div v-if="Object.keys(page.props.errors).length > 0" class="toast z-50">
      <div v-for="(error, key) in page.props.errors" :key="key" class="alert alert-error">
        <p>
          {{ error }}
        </p>
      </div>
    </div>

    <div>
      <Link href="/">
        <ApplicationLogo class="text-base-content h-40 w-40 fill-current" />
      </Link>
    </div>

    <div>
      <slot />
    </div>
  </div>
</template>
