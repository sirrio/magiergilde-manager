<script setup lang="ts">
import { Item } from '@/Types'
import { InertiaForm, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  item: Item
}>()

const form: InertiaForm<Item> = useForm({
  id: props.item.id,
  name: props.item.name,
  url: props.item.url,
  cost: props.item.cost,
  rarity: props.item.rarity,
  type: props.item.type,
} as InertiaForm<Item>)

const modalUpdateItem = ref()

const showModal = () => {
  modalUpdateItem.value.showModal()
}

const clickUpdateItem = () => {
  form.patch(route('item.update', { item: props.item }), {
    preserveState: false,
    preserveScroll: true,
  })
}

defineExpose({
  showModal,
})
</script>

<template>
  <dialog ref="modalUpdateItem" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
      </form>
      <h3 class="mb-6 text-lg font-bold">Update Item</h3>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input v-model="form.name" type="text" placeholder="Shortsword +1" class="input" />
      </label>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input v-model="form.url" type="text" placeholder="https://..." class="input" />
      </label>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <input v-model="form.cost" type="text" placeholder="1000 GP" class="input" />
      </label>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <select v-model="form.rarity" class="select capitalize">
          <option v-for="(rarity, key) in ['common', 'uncommon', 'rare', 'very_rare']" :key="key" :value="rarity" class="capitalize">
            {{ rarity.replace('_', ' ') }}
          </option>
        </select>
      </label>

      <label class="form-control mb-2 w-full">
        <div class="label">
          <span class="label-text">Item name</span>
        </div>
        <select v-model="form.type" class="select capitalize">
          <option v-for="(type, key) in ['item', 'consumable', 'spellscroll']" :key="key" :value="type" class="capitalize">
            {{ type }}
          </option>
        </select>
      </label>

      <button class="btn btn-neutral mt-6" @click="clickUpdateItem()">Update</button>
    </div>
  </dialog>
</template>
