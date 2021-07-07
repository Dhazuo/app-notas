<template>
    <notes-layout>
        <template v-slot:content>
            <div class="w-full text-center my-4">
                <h1 class="text-gray-700 text-2xl font-bold">Crea tu nota</h1>
            </div>
            <div class="w-full flex justify-center">
                <div
                    class="w-full lg:w-2/3 rounded-md shadow-md p-6 border border-gray-300 text-base font-bold text-gray-600"
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
                                      class="w-full rounded-md shadow-sm border border-gray-300 focus:ring-0 focus:border-blue-500 transition duration-200"></textarea>
                        </div>
                        <div class="flex space-x-2 justify-center">
                            <inertia-link :href="route('notes.index')"
                                          class="rounded-md text-base border border-gray-300 px-4 py-2 text-black font-semibold shadow-md bg-white hover:bg-gray-100 transition duration-100 focus:bg-gray-200">
                                Regresar
                            </inertia-link>
                            <button @click.prevent="create"
                                    type="submit"
                                    :disabled="button_submit == false"
                                    :class="button_submit == false ? 'bg-blue-100 text-white': 'bg-blue-500 hover:bg-blue-600 focus:bg-blue-700 text-white' "
                                    class="rounded-md shadow-md  font-bold transition duration-200 py-2 px-4"
                            >Crear
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
    data() {
        return {
            button_submit: true,
            form: {
                user_id: 1,
                category_id: 1,
                title: '',
                content: '',
                color_blue: false,
                color_yellow: false,
                color_pink: false,
            }
        }
    },
    methods: {
        create() {
            this.button_submit = false
            axios.post(route('notes.store'), this.form)
                .then(({data}) => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Información guardada con éxito',
                        showConfirmButton: false,
                        timer: 800
                    }).then(() => {
                        window.location = route('notes.index');
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
