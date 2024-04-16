<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    name: '',
    class: ''
});

const clickCreateNewCharacter = () => {
    form.put(route('character.store'))
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl p-9 mx-auto">
            <h1>Create new character</h1>

            <label class="input input-bordered flex items-center gap-2">
                Name
                <input type="text" class="grow" v-model="form.name" placeholder="Peter"/>
            </label>

            <label class="input input-bordered flex items-center gap-2">
                Class
                <input type="text" class="grow" v-model="form.class" placeholder="Fighter"/>
            </label>

            <button class="btn" @click="clickCreateNewCharacter()">Create</button>
        </div>
    </AuthenticatedLayout>
</template>
