<script setup lang="ts">
import { Character, Downtime } from '@/types/index.js'
import { nextTick, Ref, ref } from 'vue'
import CreateDowntimeModal from '@/Modals/Downtime/CreateDowntimeModal.vue'
import UpdateDowntimeModal from '@/Modals/Downtime/UpdateDowntimeModal.vue'
import DestroyDowntimeModal from '@/Modals/Downtime/DestroyDowntimeModal.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

defineProps<{
  character: Character
}>()

const createDowntimeModal = ref()
const updateDowntimeModal = ref()
const updateDowntimeModalKey = ref('updateDowntimeModalKey-1')
const destroyDowntimeModal = ref()
const destroyDowntimeModalKey = ref('destroyDowntimeModalKey-1')
const currentDowntime: Ref<Downtime | null> = ref(null)

const clickUpdateDowntimeModal = async (downtime: Downtime) => {
  currentDowntime.value = downtime
  updateDowntimeModalKey.value = 'updateDowntimeModalKey-' + Math.random()
  await nextTick()
  updateDowntimeModal.value.showModal()
}

const clickDestroyDowntimeModal = async (downtime: Downtime) => {
  currentDowntime.value = downtime
  destroyDowntimeModalKey.value = 'destroyDowntimeModalKey-' + Math.random()
  await nextTick()
  destroyDowntimeModal.value.showModal()
}
</script>

<template>
  <div class="flex flex-col gap-3">
    <div class="flex justify-between">
      <h2 class="card-title">
        <font-awesome-icon
          :icon="['fas', 'hourglass']"
        />
        Downtimes
      </h2>
      <button
        class="btn btn-ghost"
        @click="createDowntimeModal.showModal()"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
        Add downtime
      </button>
    </div>
    <div
      v-if="character.downtimes.length === 0"
      class="card bg-base-100 text-base-content"
    >
      <div class="card-body text-center">
        <font-awesome-icon
          :icon="['fas', 'circle-exclamation']"
          size="7x"
        />
        <h3 class="font-semibold text-xl">
          No downtimes yet
        </h3>
      </div>
    </div>
    <div
      v-for="(downtime, key) of character.downtimes"
      v-else
      :key="key"
      class="card card-compact bg-base-100 text-base-content group"
    >
      <div
        tabindex="0"
        class="card-body collapse cursor-pointer"
      >
        <div class="group-hover:absolute group-hover:flex gap-1 hidden top-2 right-2">
          <button
            class="btn btn-xs btn-square"
            @click="clickUpdateDowntimeModal(downtime)"
          >
            <font-awesome-icon :icon="['fas', 'gear']" />
          </button>
          <button
            class="btn btn-xs btn-error btn-square"
            @click="clickDestroyDowntimeModal(downtime)"
          >
            <font-awesome-icon :icon="['fas', 'x']" />
          </button>
        </div>
        <div class="card-title">
          <h3>
            <font-awesome-icon
              :icon="['fas', 'hashtag']"
              size="xs"
            />
            {{ key + 1 }} Downtime
            <font-awesome-icon
              v-if="downtime.notes"
              :icon="['fas', 'note-sticky']"
            />
          </h3>
        </div>
        <div class="flex justify-between text-xs">
          <p>
            <font-awesome-icon
              :icon="['fas', 'clock']"
            />
            {{ Math.floor(downtime.duration / 3600) }}h {{ (downtime.duration / 60) % 60 }}min
          </p>
          <p class="italic text-right">
            <font-awesome-icon
              :icon="['fas', 'calendar']"
            />
            {{ new Date(downtime.start_date).toLocaleDateString() }}
          </p>
        </div>
        <div class="collapse-content">
          <p
            v-if="downtime.notes"
            class="whitespace-pre-wrap "
          >
            {{ downtime.notes }}
          </p>
          <p v-else>
            <font-awesome-icon
              :icon="['fas', 'circle-exclamation']"
            />
            No notes
          </p>
        </div>
      </div>
    </div>
  </div>
  <CreateDowntimeModal
    ref="createDowntimeModal"
    :character-id="character.id"
  />
  <UpdateDowntimeModal
    v-if="currentDowntime"
    ref="updateDowntimeModal"
    :key="updateDowntimeModalKey"
    :downtime="currentDowntime"
  />
  <DestroyDowntimeModal
    v-if="currentDowntime"
    ref="destroyDowntimeModal"
    :key="destroyDowntimeModalKey"
    :downtime="currentDowntime"
  />
</template>
