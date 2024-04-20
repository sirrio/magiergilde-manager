<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion: string;
  phpVersion: string;
}>()

const clickLogin = () => {
  router.visit(route('login'))
}
</script>

<template>
  <Head title="Welcome" />
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center">
      <div class="max-w-md prose">
        <h1 class="font-bold">
          Hallo liebe Magiergilde.
        </h1>
        <p>
          aufgrund der besseren Organisation meiner Charaktere habe ich in den letzten Tagen ein Tool entwickelt, mit
          dem man die Charaktere der Magiergilde verfolgen kann. Und zwar vollautomatisch.
        </p>

        <button
          class="btn btn-primary"
          @click="clickLogin()"
        >
          Get Started
        </button>

        <p class="text-xs mt-12">
          Disclaimer 1: Ich versuche nicht, eure Mitschriften oder Excel zu ersetzen. Das Tool ist optional.
        </p>

        <p class="text-xs">
          Disclaimer 2: Ich verwende die Daten nur für die Funktionalität. Es erfolgt keine Auswertung oder Weitergabe
          der Daten an Dritte, dementsprechend werden nur funktionale Cookies gesetzt. Das Tool ist komplett kostenlos
          und wird es auch bleiben, sollte jemand Geld dafür verlangen, ist das nicht korrekt.
        </p>
      </div>
    </div>
  </div>
</template>
