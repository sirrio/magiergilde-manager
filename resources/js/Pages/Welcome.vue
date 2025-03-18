<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion: string;
  phpVersion: string;
}>();
</script>

<template>
  <Head title="Welcome" />
  <div class="grid h-screen grid-rows-[1fr_52px]">
    <div class="hero bg-base-100">
      <div class="hero-content text-center">
        <div class="max-w-md prose">
          <application-logo
            width="200px"
            class="mx-auto mb-10"
          />
          <h1 class="font-bold">
            Blaue Magiergilde
          </h1>
          <p>
            Hier kannst du deine Charaktere und gespielten Runden speichern. Deine Ressourcen und Level werden
            automatisch berechnet – so hast du alles im Blick und kannst dich voll und ganz auf dein Spiele
            konzentrieren!
          </p>

          <div class="flex gap-3 mt-10 justify-center">
            <a
              class="btn btn-neutral"
              :href="route('discord.login')"
            >
              <font-awesome-icon :icon="['fas', 'right-to-bracket']" />
              Einloggen per Discord
            </a>

            <a
              class="btn btn-neutral btn-outline"
              href="https://discord.gg/invite/dd5c"
              target="_blank"
            >
              <font-awesome-icon :icon="['fab', 'discord']" />
              Discord Community beitreten
            </a>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
      <aside>
        <p>Copyright © 2025 - All right reserved by sirrio</p>
      </aside>
    </footer>
  </div>
</template>
