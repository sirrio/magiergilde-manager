<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Adventure, Character, Downtime } from '@/types'
import { nextTick, Ref, ref } from 'vue'
import { calculateBubbleByAdventure } from '@/helpers/calculateBubble'
import { calculateLevel } from '@/helpers/calculateLevel'
import CreateAdventureModal from '@/Modals/Adventure/CreateAdventureModal.vue'
import DestroyAdventureModal from '@/Modals/Adventure/DestroyAdventureModal.vue'
import UpdateAdventureModal from '@/Modals/Adventure/UpdateAdventureModal.vue'
import CreateDowntimeModal from '@/Modals/Downtime/CreateDowntimeModal.vue'
import DestroyDowntimeModal from '@/Modals/Downtime/DestroyDowntimeModal.vue'
import UpdateDowntimeModal from '@/Modals/Downtime/UpdateDowntimeModal.vue'
import { Head } from '@inertiajs/vue3'

defineProps<{
  character: Character
}>()

const createAdventureModal = ref()
const updateAdventureModal = ref()
const updateAdventureModalKey = ref('updateAdventureModalKey-1')
const destroyAdventureModal = ref()
const destroyAdventureModalKey = ref('destroyAdventureModalKey-1')
const currentAdventure: Ref<Adventure | null> = ref(null)
const createDowntimeModal = ref()
const updateDowntimeModal = ref()
const updateDowntimeModalKey = ref('updateDowntimeModalKey-1')
const destroyDowntimeModal = ref()
const destroyDowntimeModalKey = ref('destroyDowntimeModalKey-1')
const currentDowntime: Ref<Downtime | null> = ref(null)

const clickUpdateAdventureModal = async (adventure: Adventure) => {
  currentAdventure.value = adventure
  updateAdventureModalKey.value = 'updateAdventureModalKey-' + Math.random()
  await nextTick()
  updateAdventureModal.value.showModal()
}

const clickDestroyAdventureModal = async (adventure: Adventure) => {
  currentAdventure.value = adventure
  destroyAdventureModalKey.value = 'destroyAdventureModalKey-' + Math.random()
  await nextTick()
  destroyAdventureModal.value.showModal()
}

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

function onImgError(event: Event) {
  const target = event.target as HTMLImageElement
  target.src = '/images/placeholder.jpg'
}
</script>

<template>
  <Head title="Details" />

  <AuthenticatedLayout>
    <div class="py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="flex flex-col items-center">
          <div class="prose mb-12 text-center">
            <h2>{{ character.name }}</h2>
            <div class="avatar my-0">
              <div class="aspect-square rounded-full h-24">
                <img
                  class="my-0"
                  :src="'/storage/' + character.avatar"
                  alt=""
                  @error="onImgError($event)"
                >
              </div>
            </div>
            <p class="text-xs">
              Level {{ calculateLevel(character) }}
              {{ character.character_classes[0].name }}
            </p>
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-12 mt-3">
          <div class="flex flex-col gap-3">
            <div class="flex justify-between">
              <h2 class="card-title">
                <font-awesome-icon
                  :icon="['fas', 'compass']"
                />
                Adventures
              </h2>
              <button
                class="btn btn-ghost"
                @click="createAdventureModal.showModal()"
              >
                <font-awesome-icon :icon="['fas', 'plus']" />
                Add adventure
              </button>
            </div>
            <div
              v-if="character.adventures.length === 0"
              class="card bg-base-100 text-base-content"
            >
              <div class="card-body text-center">
                <font-awesome-icon
                  :icon="['fas', 'circle-exclamation']"
                  size="7x"
                />
                <h3 class="font-semibold text-xl">
                  No adventures yet
                </h3>
              </div>
            </div>
            <div
              v-for="(adventure, key) of character.adventures"
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
                    @click="clickUpdateAdventureModal(adventure)"
                  >
                    <font-awesome-icon :icon="['fas', 'gear']" />
                  </button>
                  <button
                    class="btn btn-xs btn-error btn-square"
                    @click="clickDestroyAdventureModal(adventure)"
                  >
                    <font-awesome-icon :icon="['fas', 'x']" />
                  </button>
                </div>
                <div class="card-title">
                  <h3>
                    <font-awesome-icon
                      v-if="adventure.notes"
                      :icon="['fas', 'hashtag']"
                      fixed-width
                      size="xs"
                    />{{ key + 1 }}
                    {{ adventure.title ?? 'Adventure' }}
                    <font-awesome-icon
                      v-if="adventure.notes"
                      :icon="['fas', 'note-sticky']"
                      fixed-width
                      size="xs"
                    />
                    <p class="text-xs font-normal">
                      {{ adventure.game_master ?? 'No game master' }}
                    </p>
                  </h3>
                </div>
                <div class="flex justify-between text-xs">
                  <p>
                    <font-awesome-icon
                      :icon="['fas', 'clock']"
                    />
                    You gained {{ calculateBubbleByAdventure([adventure]) }}
                    <span v-if="adventure.has_additional_bubble">(Character Quest)</span>
                    bubbles in {{ Math.floor(adventure.duration / 3600) }}h {{ (adventure.duration / 60) % 60 }}min
                  </p>
                  <p class="italic text-right">
                    <font-awesome-icon
                      :icon="['fas', 'calendar']"
                    />
                    {{ new Date(adventure.start_date).toLocaleDateString() }}
                  </p>
                </div>
                <div class="collapse-content">
                  <p
                    v-if="adventure.notes"
                    class="whitespace-pre-wrap "
                  >
                    {{ adventure.notes }}
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
                    Downtime {{ key + 1 }}
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
        </div>
      </div>
    </div>
    <CreateAdventureModal
      ref="createAdventureModal"
      :character-id="character.id"
    />
    <UpdateAdventureModal
      v-if="currentAdventure"
      ref="updateAdventureModal"
      :key="updateAdventureModalKey"
      :adventure="currentAdventure"
    />
    <DestroyAdventureModal
      v-if="currentAdventure"
      ref="destroyAdventureModal"
      :key="destroyAdventureModalKey"
      :adventure="currentAdventure"
    />
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
  </AuthenticatedLayout>
</template>
