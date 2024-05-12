<script setup lang="ts">
import { ref } from 'vue'
import { Character } from '@/types'
import { InertiaForm, router, useForm } from '@inertiajs/vue3'

const modalAlly = ref()

const props = defineProps<{
  character: Character
}>()

const emit = defineEmits<{
  (e: 'updateKey'): void
}>()

const form: InertiaForm<{
  name: string
  standing: string
  character_id: number
}> = useForm({
  name: '',
  standing: 'normal',
  character_id: props.character.id,
})

const showModal = () => {
  modalAlly.value.showModal()
}

const clickCreateAlly = () => {
  form.put(route('ally.store'), {
    onSuccess: () => {
      form.reset()
      emit('updateKey')
    },
  })
}

const clickDeleteAlly = (id: number) => {
  router.delete(route('ally.destroy', { ally: id }), {
    onSuccess: () => {
      emit('updateKey')
    },
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalAlly"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg">
        Manage your allies
      </h3>
      <form
        class="flex flex-col gap-3"
        @submit.prevent="clickCreateAlly()"
      >
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Add an ally</span>
          </div>
          <div class="flex gap-1">
            <input
              v-model="form.name"
              placeholder="Your allies name"
              type="text"
              class="input input-sm input-bordered w-full"
            >
            <select
              v-model="form.standing"
              class="select select-bordered select-sm w-32 capitalize"
            >
              <option value="good">Friend</option>
              <option value="normal">Ally</option>
              <option value="bad">Disliked</option>
            </select>
            <button class="btn btn-sm btn-neutral">
              Add
            </button>
          </div>
        </label>
      </form>

      <template v-for="standing in ['good', 'normal', 'bad']">
        <div
          v-if="character.allies.filter(a => a.standing === standing).length > 0"
          :key="standing"
          class="mt-6 "
        >
          <h3 class="font-bold text-lg">
            {{ standing === "good" ? "Friends" : standing === "normal" ? "Allies" : "Disliked" }}
          </h3>
          <div class="flex flex-wrap gap-1">
            <div
              v-for="(ally, key) in character.allies.filter(a => a.standing === standing)"
              :key="key"
              class="badge badge-neutral group"
            >
              {{ ally.name }}
              <button
                class="hidden text-error group-hover:block ml-1"
                @click="clickDeleteAlly(ally.id)"
              >
                x
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
  </dialog>
</template>
