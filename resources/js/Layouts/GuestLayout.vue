<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import {Link} from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen bg-base-300 flex flex-col items-center justify-center">
    <div
      v-if="Object.keys($page.props.errors).length > 0"
      class="toast z-50"
    >
      <div
        v-for="(error, key) in $page.props.errors"
        :key="key"
        class="alert alert-error"
      >
        <p>
          {{ error }}
        </p>
      </div>
    </div>

    <div>
      <Link href="/">
        <ApplicationLogo class="text-base-content fill-current w-40 h-40" />
      </Link>
    </div>

    <div>
      <slot />
    </div>
  </div>
</template>
