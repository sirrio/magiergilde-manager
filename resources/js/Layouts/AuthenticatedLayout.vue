<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link, usePage } from '@inertiajs/vue3'
import { themeChange } from 'theme-change'
import { onMounted } from 'vue'

onMounted(() => {
  themeChange(false)
})

const page = usePage()

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
  <div class="bg-base-300 min-h-screen">
    <div v-if="Object.keys(page.props.errors).length > 0" class="toast z-50">
      <div v-for="(error, key) in page.props.errors" :key="key" class="alert alert-error">
        <p>
          {{ error }}
        </p>
      </div>
    </div>
    <div class="navbar bg-base-100">
      <div class="hidden px-4 md:inline-block">
        <ApplicationLogo class="h-10 fill-current" />
      </div>
      <div class="flex-1 md:hidden">
        <div class="dropdown">
          <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
            <font-awesome-icon icon="bars" size="xl" />
          </div>
          <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow-sm">
            <li>
              <a :href="route('characters.index')" :class="{ 'menu-active': route().current('characters.index') }">Characters</a>
            </li>
            <li>
              <a :href="route('games.index')" :class="{ 'menu-active': route().current('games.index') }">Game Master</a>
            </li>
            <li v-if="page.props.auth.user.is_admin">
              <a :href="route('items.index')" :class="{ active: route().current('items.index') }">Items</a>
            </li>
            <li v-if="page.props.auth.user.is_admin">
              <a :href="route('items.shop')" :class="{ active: route().current('items.shop') }">Shop</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="hidden flex-1 md:inline-block">
        <ul class="menu menu-horizontal gap-1 px-1">
          <li>
            <a :href="route('characters.index')" :class="{ 'menu-active': route().current('characters.index') }">Characters</a>
          </li>
          <li>
            <a :href="route('games.index')" :class="{ 'menu-active': route().current('games.index') }">Game Master</a>
          </li>
          <li v-if="page.props.auth.user.is_admin">
            <a :href="route('items.index')" :class="{ 'menu-active': route().current('items.index') }">Items</a>
          </li>
          <li v-if="page.props.auth.user.is_admin">
            <a :href="route('items.shop')" :class="{ 'menu-active': route().current('items.shop') }">Shop</a>
          </li>
        </ul>
      </div>
      <div class="mr-4 flex flex-none">
        <div class="dropdown dropdown-end">
          <span class="mr-3 hidden sm:inline">{{ page.props.auth.user.name }}</span>
          <div tabindex="0" role="button" class="btn btn-circle">
            <div class="avatar">
              <div class="w-full rounded-full">
                <img :src="page.props.auth.user.avatar" alt="avatar" />
              </div>
            </div>
          </div>
          <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow-sm">
            <li>
              <div class="flex items-center">
                <p class="hidden sm:block">Theme:</p>
                <select class="select select-sm" data-choose-theme>
                  <option v-for="(theme, key) in themes" :key="key" :data-theme="theme" :value="theme" class="capitalize">
                    {{ theme }}
                  </option>
                </select>
              </div>
            </li>
            <li>
              <Link :href="route('logout')" method="post" :as="'button'"> Logout </Link>
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
