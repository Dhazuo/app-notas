<template>
    <notes-layout>
        <template v-slot:content>
            <div v-if="notes.length == 0" class="w-full text-center text-4xl space-y-4">
                <h1>
                    No hay nada por aquí...
                </h1>
                <div class="w-full flex justify-center">
                    <inertia-link :href="route('notes.create')"
                                  class="rounded-full text-sm px-4 py-2 text-white font-bold shadow-md bg-blue-500 hover:bg-blue-600 border border-transparent focus:border-blue-300 transition duration-100 focus:bg-blue-700">
                        Crea tu primera nota
                    </inertia-link>
                </div>
            </div>
            <div v-else class="w-full">
                <div class="flex justify-end my-4">
                    <inertia-link :href="route('notes.create')"
                                  class="rounded-full text-sm px-4 py-2 text-white font-bold shadow-md bg-blue-500 hover:bg-blue-600 border border-transparent focus:border-blue-300 transition duration-100 focus:bg-blue-700">
                        Crear nota
                    </inertia-link>
                </div>
                <div class="w-full space-y-8">
                    <div class="space-y-4">
                        <div class="text-gray-700 font-bold text-base flex space-x-3 items-center">
                            <h1 class="px-4 py-2 rounded-full cursor-default bg-white shadow-sm border border-gray-300">Sin ninguna categoría</h1>
                            <button @click="table_1 = !table_1">
                                <svg v-if="table_1 == true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                    <line x1="12" y1="9" x2="12" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                        <div v-show="table_1" class="overflow-x-auto w-full rounded-md border border-gray-300  shadow-md bg-white">
                            <div v-if="returnNoneCategory.length == 0" class="w-full text-center">
                                <h1 class="text-gray-700 font-bold text-2xl py-4">No hay notas en esta categoría</h1>
                            </div>
                            <table v-else class="table-auto w-full shadow-sm">
                                <thead class="w-full text-gray-500 text-sm uppercase">
                                <tr class="w-full border-b border-gray-300 bg-gray-50">
                                    <th class="p-4 text-left">Títutlo</th>
                                    <th class="p-4 text-left">Contenido</th>
                                    <th class="p-4">Fecha de creación</th>
                                    <th class="p-4">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="w-full text-gray-600 text-sm">
                                <tr v-for="note in returnNoneCategory" class="w-full border-b border-gray-300"
                                    :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }">
                                    <td class="p-4">
                                        <inertia-link :href="route('notes.show', note.id)" class="text-blue-500">
                                            {{ note.title }}
                                        </inertia-link>
                                    </td>
                                    <td class="p-4 truncate">
                                        <p> {{ note.content.substr(0, 40) + '...' }} </p>
                                    </td>
                                    <td class="p-4 truncate text-center">
                                        <h3> {{ note.created_at }} </h3>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-2 justify-center">
                                            <inertia-link :href="route('notes.edit', note.id)"
                                                          class="text-green-800 hover:text-green-700">Editar
                                            </inertia-link>
                                            <button :disabled="button_submit == false" @click="deleteNote(note)" class="text-red-800 hover:text-red-700">Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="text-gray-700 font-bold text-base flex space-x-3 items-center">
                            <h1 class="px-4 py-2 rounded-full cursor-default bg-white shadow-sm border border-gray-300">Personal</h1>
                            <button @click="table_2 = !table_2">
                                <svg v-if="table_2 == true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                    <line x1="12" y1="9" x2="12" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                        <div v-show="table_2" class="overflow-x-auto w-full rounded-md border border-gray-300  shadow-md bg-white">
                            <div v-if="returnPersonalCategory.length == 0" class="w-full text-center">
                                <h1 class="text-gray-700 font-bold text-2xl py-4">No hay notas en esta categoría</h1>
                            </div>
                            <table v-else class="table-auto w-full shadow-sm">
                                <thead class="w-full text-gray-500 text-sm uppercase">
                                <tr class="w-full border-b border-gray-300 bg-gray-50">
                                    <th class="p-4 text-left">Títutlo</th>
                                    <th class="p-4 text-left">Contenido</th>
                                    <th class="p-4">Fecha de creación</th>
                                    <th class="p-4">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="w-full text-gray-600 text-sm">
                                <tr v-for="note in returnPersonalCategory" class="w-full border-b border-gray-300"
                                    :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }">
                                    <td class="p-4">
                                        <inertia-link :href="route('notes.show', note.id)" class="text-blue-500">
                                            {{ note.title }}
                                        </inertia-link>
                                    </td>
                                    <td class="p-4 truncate">
                                        <p> {{ note.content.substr(0, 40) + '...' }} </p>
                                    </td>
                                    <td class="p-4 truncate text-center">
                                        <h3> {{ note.created_at }} </h3>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-2 justify-center">
                                            <inertia-link :href="route('notes.edit', note.id)"
                                                          class="text-green-800 hover:text-green-700">Editar
                                            </inertia-link>
                                            <button :disabled="button_submit == false" @click="deleteNote(note)" class="text-red-800 hover:text-red-700">Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="text-gray-700 font-bold text-base flex space-x-3 items-center">
                            <h1 class="px-4 py-2 rounded-full cursor-default bg-white shadow-sm border border-gray-300">Trabajo</h1>
                            <button @click="table_3 = !table_3">
                                <svg v-if="table_3 == true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                    <line x1="12" y1="9" x2="12" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                        <div v-show="table_3" class="overflow-x-auto w-full rounded-md border border-gray-300  shadow-md bg-white">
                            <div v-if="returnJobCategory.length == 0" class="w-full text-center">
                                <h1 class="text-gray-700 font-bold text-2xl py-4">No hay notas en esta categoría</h1>
                            </div>
                            <table v-else class="table-auto w-full shadow-sm">
                                <thead class="w-full text-gray-500 text-sm uppercase">
                                <tr class="w-full border-b border-gray-300 bg-gray-50">
                                    <th class="p-4 text-left">Títutlo</th>
                                    <th class="p-4 text-left">Contenido</th>
                                    <th class="p-4">Fecha de creación</th>
                                    <th class="p-4">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="w-full text-gray-600 text-sm">
                                <tr v-for="note in returnJobCategory" class="w-full border-b border-gray-300"
                                    :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }">
                                    <td class="p-4">
                                        <inertia-link :href="route('notes.show', note.id)" class="text-blue-500">
                                            {{ note.title }}
                                        </inertia-link>
                                    </td>
                                    <td class="p-4 truncate">
                                        <p> {{ note.content.substr(0, 40) + '...' }} </p>
                                    </td>
                                    <td class="p-4 truncate text-center">
                                        <h3> {{ note.created_at }} </h3>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-2 justify-center">
                                            <inertia-link :href="route('notes.edit', note.id)"
                                                          class="text-green-800 hover:text-green-700">Editar
                                            </inertia-link>
                                            <button :disabled="button_submit == false" @click="deleteNote(note)" class="text-red-800 hover:text-red-700">Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="text-gray-700 font-bold text-base flex space-x-3 items-center">
                            <h1 class="px-4 py-2 rounded-full cursor-default bg-white shadow-sm border border-gray-300">Tareas</h1>
                            <button @click="table_4 = !table_4">
                                <svg v-if="table_4 == true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="12" x2="15" y2="12"></line>
                                    <line x1="12" y1="9" x2="12" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                        <div v-show="table_4" class="overflow-x-auto w-full rounded-md border border-gray-300  shadow-md bg-white">
                            <div v-if="returnTasksCategory.length == 0" class="w-full text-center">
                                <h1 class="text-gray-700 font-bold text-2xl py-4">No hay notas en esta categoría</h1>
                            </div>
                            <table v-else class="table-auto w-full shadow-sm">
                                <thead class="w-full text-gray-500 text-sm uppercase">
                                <tr class="w-full border-b border-gray-300 bg-gray-50">
                                    <th class="p-4 text-left">Títutlo</th>
                                    <th class="p-4 text-left">Contenido</th>
                                    <th class="p-4">Fecha de creación</th>
                                    <th class="p-4">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="w-full text-gray-600 text-sm">
                                <tr v-for="note in returnTasksCategory" class="w-full border-b border-gray-300"
                                    :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }">
                                    <td class="p-4">
                                        <inertia-link :href="route('notes.show', note.id)" class="text-blue-500">
                                            {{ note.title }}
                                        </inertia-link>
                                    </td>
                                    <td class="p-4 truncate">
                                        <p> {{ note.content.substr(0, 40) + '...' }} </p>
                                    </td>
                                    <td class="p-4 truncate text-center">
                                        <h3> {{ note.created_at }} </h3>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-2 justify-center">
                                            <inertia-link :href="route('notes.edit', note.id)"
                                                          class="text-green-800 hover:text-green-700">Editar
                                            </inertia-link>
                                            <button :disabled="button_submit == false" @click="deleteNote(note)" class="text-red-800 hover:text-red-700">Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </notes-layout>
</template>

<script>
import NotesLayout from "../../Layouts/NotesLayout";

export default {
    props: {
        notes: Array
    },
    data() {
        return {
            button_submit: true,
            table_1: false,
            table_2: false,
            table_3: false,
            table_4: false
        }
    },
    components: {NotesLayout},
    methods: {
        deleteNote(note){
            this.button_submit = false
            this.$swal.fire({
                icon: 'warning',
                title: `¿Deseas eliminar la nota ${note.title}?`,
                text: 'Esta acción es irreversible.',
                showCancelButton: true,
                confirmButtonText: 'Borrar',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-600 text-white font-bold px-4 py-2 rounded-md shadow-sm hover:bg-red-600 focus:bg-red-700 focus:ring-4 ring-red-200 transition duration-200',
                    cancelButton: 'bg-gray-100 text-black font-bold px-4 py-2 rounded-md shadow-sm hover:bg-gray-200 focus:bg-gray-300 focus:ring-4 ring-gray-50 transition duration-200',
                    actions: 'flex space-x-2'
                }
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(route('notes.destroy', note.id))
                        .then(({data}) => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Nota eliminada con éxito',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                window.location = route('notes.categories');
                            });
                        })
                        .catch((err) => {
                            if (err.response.status === 404) {
                                this.$swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Esta nota no existe',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#3B82F6'
                                }).then(() => {
                                    window.location = route('notes.categories');
                                });
                            }
                        });;
                } else {
                    this.button_submit = true
                }
            })
        },
    },
    computed: {
        returnNoneCategory() {
            const category_1 = this.notes.filter(note => note.category_id == 1);
            return category_1
        },
        returnPersonalCategory(){
            const category_2 = this.notes.filter(note => note.category_id == 2);
            return category_2
        },
        returnJobCategory(){
            const category_3 = this.notes.filter(note => note.category_id == 3);
            return category_3
        },
        returnTasksCategory(){
            const category_4 = this.notes.filter(note => note.category_id == 4);
            return category_4
        },
    },
}
</script>

<style scoped>

</style>
