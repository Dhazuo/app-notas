<template>
    <notes-layout>
        <template v-slot:content>
            <div class="w-full text-center my-4">
                <h1 class="text-gray-700 text-2xl font-bold">Editando la nota: {{ note.title }}</h1>
            </div>
            <div class="w-full flex justify-center">
                <div class="w-full lg:w-2/3 rounded-md shadow-md p-6 border border-gray-300 text-base font-bold text-gray-600"
                     :class="{'bg-blue-50': form.color_blue == true, 'bg-yellow-50': form.color_yellow == true, 'bg-pink-50': form.color_pink == true, 'bg-white': form.color_blue == false && form.color_yellow == false && form.color_pink == false }"
                >
                    <div class="space-y-4">
                        <div class="ml-auto flex justify-center lg:justify-end space-y-2">
                            <div class="space-y-2">
                                <h2>¡Escoge tu color!</h2>
                                <div class="flex space-x-4 justify-center">
                                    <button @click="changeToBlue"
                                            class="rounded-full h-6 w-6 bg-blue-200 transition duration-200"
                                            :class="{'ring-2 ring-blue-300': form.color_blue == true}"
                                    ></button>
                                    <button @click="changeToYellow"
                                            class="rounded-full h-6 w-6 bg-yellow-200 transition duration-200"
                                            :class="{'ring-2 ring-yellow-300': form.color_yellow == true}"
                                    ></button>
                                    <button @click="changeToPink"
                                            class="rounded-full h-6 w-6 bg-pink-200 transition duration-200"
                                            :class="{'ring-2 ring-pink-300': form.color_pink == true}"
                                    ></button>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2 text-center">
                            <label for="category" class="">Categoría</label>
                            <select v-model="form.category_id" id="category"
                                    class="w-full rounded-md shadow-sm border border-gray-300 focus:ring-0 focus:border-blue-500 transition duration-200 text-center">
                                <option value="1">Sin categoría</option>
                                <option value="2">Personal</option>
                                <option value="3">Trabajo</option>
                                <option value="4">Tareas</option>
                            </select>
                        </div>
                        <div class="space-y-2 text-center">
                            <label for="title">Título</label>
                            <input v-model="form.title" type="text" id="title"
                                   class="w-full rounded-md shadow-sm border border-gray-300 focus:ring-0 focus:border-blue-500 transition duration-200 text-center">
                        </div>
                        <div class="space-y-2 text-center">
                            <label for="content">Contenido</label>
                            <textarea v-model="form.content" type="text" rows="6" id="content"
                                      class="w-full rounded-md shadow-sm border border-gray-300 focus:ring-0 focus:border-blue-500 transition duration-200">{{ form.content }}</textarea>
                        </div>
                        <div class="flex space-x-2 justify-center">
                            <inertia-link :href="route('notes.index')"
                                          class="rounded-md text-base border border-gray-300 px-4 py-2 text-black font-semibold shadow-md bg-white hover:bg-gray-100 transition duration-100 focus:bg-gray-200">
                                Regresar
                            </inertia-link>
                            <button @click.prevent="edit"
                                    type="submit"
                                    :disabled="button_submit == false"
                                    :class="button_submit == false ? 'bg-green-100 text-white': 'bg-green-500 hover:bg-green-600 focus:bg-green-700 text-white' "
                                    class="rounded-md shadow-md  font-bold transition duration-200 py-2 px-4"
                            >Editar
                            </button>
                            <button :disabled="button_delete == false" @click.prevent="destroy"
                                    :class="button_delete == true ? 'bg-red-500 border border-transparent focus:border-red-300 hover:bg-red-600 focus:bg-red-700' : 'bg-red-100'"
                                    class="rounded-md text-base px-4 py-2 text-white font-semibold shadow-md transition duration-200 ">
                                Eliminar
                            </button>
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
    components: {NotesLayout},
    props: {
        note: Object
    },
    data() {
        return {
            button_submit: true,
            button_delete: true,
            form: {
                user_id: this.note.user_id,
                category_id: this.note.category_id,
                title: this.note.title,
                content: this.note.content,
                color_blue: this.note.color_blue,
                color_yellow: this.note.color_yellow,
                color_pink: this.note.color_pink,
            }
        }
    },
    methods: {
        edit() {
            this.button_submit = false
            axios.put(route('notes.update', this.note.id), this.form)
                .then(({data}) => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Información editada con éxito',
                        showConfirmButton: false,
                        timer: 800
                    }).then(() => {
                        window.location = route('notes.show', this.note.id);
                    });
                }).catch((err) => {
                let error = err.response.data
                let template = ""

                Object.keys(error.errors).forEach((key) => {
                    template += `<li class="mb-2">${error.errors[key]}</li>`
                });
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: `<ul>${template}</ul>`,
                    showConfirmButton: true,
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3B82F6'
                })
                .then(() => this.button_submit = true);
            });
        },
        destroy() {
            this.button_delete = false
            this.$swal.fire({
                icon: 'warning',
                title: `¿Desea eliminar la nota ${this.note.title}?`,
                text: 'Esta acción es irreversible.',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Borrar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'bg-red-600 text-white font-bold px-4 py-2 rounded-md shadow-sm hover:bg-red-600 focus:bg-red-700 focus:ring-4 ring-red-200 transition duration-200',
                    cancelButton: 'bg-gray-100 text-black font-bold px-4 py-2 rounded-md shadow-sm hover:bg-gray-200 focus:bg-gray-300 focus:ring-4 ring-gray-50 transition duration-200',
                    actions: 'flex space-x-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(route('notes.destroy', this.note.id))
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
                    this.button_delete = true
                }
            });
        },
        changeToBlue() {
            if (this.form.color_blue == false) {
                this.form.color_blue = true;
                if (this.form.color_pink == true || this.form.color_yellow == true) {
                    this.form.color_pink = false;
                    this.form.color_yellow = false;
                }
            } else {
                this.form.color_blue = false
            }
        },
        changeToYellow() {
            if (this.form.color_yellow == false) {
                this.form.color_yellow = true;
                if (this.form.color_blue == true || this.form.color_pink == true) {
                    this.form.color_blue = false;
                    this.form.color_pink = false;
                }
            } else {
                this.form.color_yellow = false
            }
        },
        changeToPink() {
            if (this.form.color_pink == false) {
                this.form.color_pink = true;
                if (this.form.color_blue == true || this.form.color_yellow == true) {
                    this.form.color_blue = false;
                    this.form.color_yellow = false;
                }
            } else {
                this.form.color_pink = false
            }
        },
    }
}
</script>

<style scoped>

</style>
