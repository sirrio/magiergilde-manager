<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Character} from "@/types";

const props = defineProps<{
    characters: Character
}>()

const clickCreateNewCharacter = () => {
    router.visit(route('character.create'))
}

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
                    <h2 class="">Your character</h2>
                    <p>You can manager your character here</p>
                </div>

                <div class="grid grid-cols-4">
                    <div class="card bg-base-100" v-for="(character , key) of characters" :key="key">
                        <div class="card-body">
                            <h3 class="card-title">{{ character.name }}</h3>
                            <p>{{ character.class }}</p>
                            <button class="btn btn-neutral " @click="clickShowCharacter(character.id)">Details
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <button @click="clickCreateNewCharacter" class="btn btn-neutral">Create new character</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
