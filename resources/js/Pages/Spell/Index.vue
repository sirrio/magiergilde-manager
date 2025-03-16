<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Spell } from '@/types'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'

defineProps<{
  spells: Spell[]
}>()

const copied = ref(false)

const copyToClipboard = (text: string) => {
  navigator.clipboard.writeText(text).then(() => {
    copied.value = true
    setTimeout(() => {
      copied.value = false
    }, 1000)
  })
}
</script>

<template>
  <Head title="Spells" />

  <AuthenticatedLayout>
    <div
      v-if="copied"
      class="toast z-50 text-base-content text-base"
    >
      <div class="alert alert-info">
        <font-awesome-icon :icon="['fas', 'copy']" />
        <span>Copied to clipboard.</span>
      </div>
    </div>
    <div class="py-6 px-6">
      <div class="max-w-9xl mx-auto">
        <div class="overflow-x-auto p-4 bg-base-100 rounded-xl">
          <table class="table table-zebra w-full">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Spell School</th>
                <th>Spell Level</th>
                <th>URL</th>
                <th>Legacy URL</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="spell in spells"
                :key="spell.id"
              >
                <td>{{ spell.id }}</td>
                <td>{{ spell.name }}</td>
                <td class="capitalize">
                  {{ spell.spell_school }}
                </td>
                <td>{{ spell.spell_level === 0 ? "Cantrip" : spell.spell_level }}</td>
                <td>
                  <span
                    v-if="spell.url"
                    class="col-span-8 hover:text-accent cursor-pointer"
                    @click="copyToClipboard(`:PHB24: [${spell.name}](<${spell.url}>)`)"
                  >
                    <font-awesome-icon
                      icon="copy"
                      class="opacity-25 mr-1"
                    />
                  </span>
                  <a
                    v-if="spell.url"
                    :href="spell.url"
                    target="_blank"
                    class="link link-primary"
                  >
                    2024
                  </a>
                </td>
                <td>
                  <span
                    v-if="spell.legacy_url"
                    class="col-span-8 hover:text-accent cursor-pointer"
                    @click="copyToClipboard(`:PHB14: [${spell.name}](<${spell.legacy_url}>)`)"
                  >
                    <font-awesome-icon
                      icon="copy"
                      class="opacity-25 mr-1"
                    />
                  </span>
                  <a
                    v-if="spell.legacy_url"
                    :href="spell.legacy_url"
                    target="_blank"
                    class="link link-secondary"
                  >
                    2014 Legacy
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
