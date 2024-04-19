<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { onMounted } from 'vue'
import { themeChange } from 'theme-change'

onMounted(() => {
  themeChange(false)
})

const themes = [
  'light',
  'dark',
  'cupcake',
  'bumblebee',
  'emerald',
  'corporate',
  'synthwave',
  'retro',
  'cyberpunk',
  'valentine',
  'halloween',
  'garden',
  'forest',
  'aqua',
  'lofi',
  'pastel',
  'fantasy',
  'wireframe',
  'black',
  'luxury',
  'dracula',
  'cmyk',
  'autumn',
  'business',
  'acid',
  'lemonade',
  'night',
  'coffee',
  'winter',
  'dim',
  'nord',
  'sunset',
]
</script>

<template>
  <div class="min-h-screen bg-base-300">
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
    <div class="navbar bg-base-100">
      <div class="flex-1">
        <a
          :href="route('dashboard')"
          class="btn btn-ghost text-xl"
        >
          <ApplicationLogo class="h-10 fill-current" />
          <span>Character manager</span>
        </a>
      </div>
      <div class="flex-none">
        <div class="flex items-center">
          <p>Theme:</p>
          <select
            class="select select-bordered select-sm text-xs ml-1 mr-6"
            data-choose-theme
          >
            <option
              v-for="(theme, key) in themes"
              :key="key"
              :data-theme="theme"
              :value="theme"
              class="capitalize"
            >
              {{ theme }}
            </option>
          </select>
        </div>
        <div class="dropdown dropdown-end">
          <span class="mr-3">{{ $page.props.auth.user.name }}</span>
          <div
            tabindex="0"
            role="button"
            class="btn btn-neutral btn-circle"
          >
            <div class="w-10 rounded-full text-neutral-content">
              <font-awesome-icon
                :icon="['far', 'user']"
                size="xl"
              />
            </div>
          </div>
          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
          >
            <li><a :href="route('profile.edit')">Profile</a></li>
            <li>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
              >
                Logout
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Page Content -->
    <main>
      <slot />
    </main>
  </div>
</template>

