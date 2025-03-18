<script setup lang="ts">
import { InertiaForm, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Item } from '../../Types'

const form: InertiaForm<Item> = useForm({
  name: '',
  url: '',
  cost: '',
  rarity: '',
  type: ''
} as InertiaForm<Item>)

const modalCreateItem = ref()

const showModal = () => {
  modalCreateItem.value.showModal()
}

const clickCreateItem = () => {
  form.post(route('item.store'), {
    preserveState: false,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog
    ref="modalCreateItem"
    class="modal"
  >
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
          ✕
        </button>
      </form>
      <h3 class="font-bold text-lg mb-6">
        Create Item
      </h3>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input
          v-model="form.name"
          type="text"
          placeholder="Shortsword +1"
          class="input"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input
          v-model="form.url"
          type="text"
          placeholder="https://..."
          class="input"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input
          v-model="form.cost"
          type="text"
          placeholder="1000 GP"
          class="input"
        >
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <select
          v-model="form.rarity"
          class="select capitalize"
        >
          <option
            v-for="(rarity, key) in ['common', 'uncommon', 'rare', 'very_rare']"
            :key="key"
            :value="rarity"
            class="capitalize"
          >
            {{ rarity.replace('_', ' ') }}
          </option>
        </select>
      </label>

      <label class="form-control w-full mb-2">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <select
          v-model="form.type"
          class="select capitalize"
        >
          <option
            v-for="(type, key) in ['item', 'consumable', 'spellscroll']"
            :key="key"
            :value="type"
            class="capitalize"
          >
            {{ type }}
          </option>
        </select>
      </label>

      <button
        class="btn btn-neutral mt-6"
        @click="clickCreateItem()"
      >
        Create
      </button>
    </div>
  </dialog>
</template>
