<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

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
      </div>
    </div>
  </div>
  <section class="max-w-2xl mx-auto my-12">
    <div class="card bg-base-200">
      <div class="card-body">
        <h3 class="card-title">
          Roadmap
        </h3>
        <ul class="timeline timeline-vertical">
          <li>
            <div class="timeline-end timeline-box">
              Game Master Tracking
            </div>
            <div class="timeline-middle">
              <font-awesome-icon :icon="['fas', 'check-circle']" />
            </div>
            <hr class="">
          </li>
          <li>
            <hr class="">
            <div class="timeline-middle">
              <font-awesome-icon :icon="['fas', 'circle']" />
            </div>
            <div class="timeline-end timeline-box">
              Fraktionen
            </div>
            <hr class="">
          </li>
          <li>
            <hr class="">
            <div class="timeline-end timeline-box">
              Filler Charactere
            </div>
            <div class="timeline-middle">
              <font-awesome-icon :icon="['fas', 'circle']" />
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <section class="max-w-2xl mx-auto mb-12">
    <div class="card bg-base-200 mb-6">
      <div class="card-body">
        <h3 class="card-title">
          Disclaimer 1
        </h3>
        <p class="text-xs">
          Ich versuche nicht, eure Mitschriften oder Excel zu ersetzen. Das Tool ist optional.
        </p>
      </div>
    </div>

    <div class="card bg-base-200">
      <div class="card-body">
        <h3 class="card-title">
          Disclaimer 2
        </h3>
        <p class="text-xs">
          Ich verwende die Daten nur für die Funktionalität. Es erfolgt keine Auswertung oder Weitergabe
          der Daten an Dritte, dementsprechend werden nur funktionale Cookies gesetzt. Das Tool ist komplett kostenlos
          und wird es auch bleiben, sollte jemand Geld dafür verlangen, ist das nicht korrekt.
        </p>
      </div>
    </div>
  </section>
  <footer class="footer footer-center p-4 bg-base-300 text-base-content">
    <aside>
      <p>Copyright © 2024 - All right reserved by sirrio</p>
    </aside>
  </footer>
</template>
