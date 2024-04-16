<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Character} from "@/types";
import CreateCharacterModal from "@/Modals/CreateCharacterModal.vue";
import {ref} from "vue";

const props = defineProps<{
    characters: Character
}>()

const createCharacterModal = ref()

const clickShowCharacter = (id: Number) => {
    router.visit(route('character.show', {character: id}))
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="prose mb-12">
                    <h2>Your characters</h2>
                    <p>You can manager your characters here</p>
                </div>

                <div class="card bg-neutral text-neutral-content" v-if="characters.length === 0">
                    <div class="card-body text-center">
                        <font-awesome-icon :icon="['fas', 'circle-exclamation']" size="7x"/>
                        <h3 class="font-semibold text-xl">No character yet</h3>
                    </div>
                </div>

                <div v-else class="grid grid-cols-4">
                    <div class="card bg-neutral text-neutral-content" v-for="(character , key) of characters" :key="key">
                        <div class="card-body">
                            <h3 class="card-title">{{ character.name }}</h3>
                            <p>{{ character.character_classes[0].name }}</p>
                            <button class="btn" @click="clickShowCharacter(character.id)">Details
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <button @click="createCharacterModal.showModal()" class="btn btn-neutral">Create new character</button>
                </div>
            </div>
        </div>
        <create-character-modal ref="createCharacterModal"></create-character-modal>
    </AuthenticatedLayout>
</template>
