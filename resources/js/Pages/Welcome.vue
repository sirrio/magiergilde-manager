<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

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
  <div class="grid h-screen grid-rows-[1fr_52px]">
    <div class="hero bg-base-100">
      <div class="hero-content text-center">
        <div class="max-w-md prose">
          <application-logo
            width="200px"
            class="mx-auto mb-10"
          />
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
    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
      <aside>
        <p>Copyright © 2025 - All right reserved by sirrio</p>
      </aside>
    </footer>
  </div>
</template>
