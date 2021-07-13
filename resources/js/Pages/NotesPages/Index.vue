<template>
    <notes-layout>
        <template v-slot:content>
            <div v-if="notes.length == 0" class="w-full text-center text-4xl space-y-4">
                <h1>
                    No hay nada por aquí...
                </h1>
                <div class="w-full flex justify-center">
                    <inertia-link :href="route('notes.create')" class="rounded-full text-sm px-4 py-2 text-white font-bold shadow-md bg-blue-500 hover:bg-blue-600 border border-transparent focus:border-blue-300 transition duration-100 focus:bg-blue-700">
                        Crea tu primera nota
                    </inertia-link>
                </div>
            </div>
            <div v-else class="w-full">
                <div class="flex justify-end my-4">
                    <inertia-link :href="route('notes.create')" class="rounded-full text-sm px-4 py-2 text-white font-bold shadow-md bg-blue-500 hover:bg-blue-600 border border-transparent focus:border-blue-300 transition duration-100 focus:bg-blue-700">
                        Crear nota
                    </inertia-link>
                </div>
                <div class="overflow-x-auto w-full rounded-md border border-gray-300  shadow-md bg-white">
                    <table class="table-auto w-full shadow-sm">
                        <thead class="w-full text-gray-500 text-sm uppercase">
                        <tr class="w-full border-b border-gray-300 bg-gray-50">
                            <th class="p-4 text-left">Títutlo</th>
                            <th class="p-4 text-left">Contenido</th>
                            <th class="p-4">Fecha de creación</th>
                            <th class="p-4">Categoría</th>
                            <th class="p-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="w-full text-gray-600 text-sm">
                        <tr v-for="note in notes" class="w-full border-b border-gray-300"
                            :class="{'bg-blue-50': note.color_blue == true, 'bg-yellow-50': note.color_yellow == true, 'bg-pink-50': note.color_pink == true, 'bg-white': note.color_blue == false && note.color_yellow == false && note.color_pink == false }"                        >
                            <td class="p-4">
                                <inertia-link :href="route('notes.show', note.id)" class="text-blue-500">
                                    {{ note.title }}
                                </inertia-link>
                            </td>
                            <td class="p-4">
                                <p> {{ note.content.substr(0, 40) + '...' }} </p>
                            </td>
                            <td class="p-4 truncate text-center">
                                <h3> {{ note.created_at }} </h3>
                            </td>
                            <td class="p-4 truncate text-center">
                                <h3 v-if="note.category_id == 1" class="p-2 rounded-full shadow-sm border border-gray-300 bg-white cursor-default"> Ninguna </h3>
                                <h3 v-if="note.category_id == 2" class="p-2 rounded-full shadow-sm border border-gray-300 bg-white cursor-default"> Personal </h3>
                                <h3 v-if="note.category_id == 3" class="p-2 rounded-full shadow-sm border border-gray-300 bg-white cursor-default"> Trabajo </h3>
                                <h3 v-if="note.category_id == 4" class="p-2 rounded-full shadow-sm border border-gray-300 bg-white cursor-default"> Tareas </h3>
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2 justify-center">
                                    <inertia-link :href="route('notes.edit', note.id)" class="text-green-800 hover:text-green-700">Editar</inertia-link>
                                    <button :disabled="button_submit == false" @click="deleteNote(note)" class="text-red-800 hover:text-red-700">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </notes-layout>
</template>

<script>
import NotesLayout from "../../Layouts/NotesLayout";

export default {
    name: "Index",
    components: {NotesLayout},
    props: {
        notes: Array
    },
    data(){
        return{
            button_submit: true
        }
    },
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
                                window.location = route('notes.index');
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
                                    window.location = route('notes.index');
                                });
                            }
                        });
                } else {
                    this.button_submit = true
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
