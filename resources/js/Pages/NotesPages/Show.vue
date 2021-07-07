<template>
    <notes-layout>
        <template v-slot:content>
            <div class="w-full border border-gray-300 rounded-md p-6 shadow-md text-center relative"
                 :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }"                        >
                <h1 class="text-base lg:text-2xl text-gray-700 font-bold mb-4">{{ note.title }}</h1>
                <inertia-link :href="route('notes.index')"
                              class="absolute top-4 right-1 lg:right-4 rounded-md text-base border border-gray-300 px-4 py-2 text-black font-semibold shadow-md bg-white hover:bg-gray-100 transition duration-100 focus:bg-gray-200">
                    Regresar
                </inertia-link>
                <h3 v-if="note.category_id == 1" class="text-sm text-gray-500">Sin categoría</h3>
                <h3 v-if="note.category_id == 2" class="text-sm text-gray-500">Personal</h3>
                <h3 v-if="note.category_id == 3" class="text-sm text-gray-500">Trabajo</h3>
                <h3 v-if="note.category_id == 4" class="text-sm text-gray-500">Tareas</h3>
                <hr class="my-4">
                <div class="w-full flex justify-center">
                    <div class="w-2/3 whitespace-pre">
                        <p class="text-sm lg:text-xl text-gray-600">
                            {{ note.content }}
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </notes-layout>
</template>

<script>
import NotesLayout from "../../Layouts/NotesLayout";

export default {
    components: {NotesLayout},
    props: {
        'note': Object
    }
}
</script>

<style scoped>

</style>
