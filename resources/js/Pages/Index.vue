<template>
    <div class="grid grid-cols-1 lg:grid-cols-5 absolute w-full h-full">
        <div class="col-span-3">
            <img src="/images/photo.jpg" alt="" class="w-full h-full">
        </div>
        <div class="w-full p-6 col-span-2">
            <div class="text-center space-y-8 mt-0 lg:mt-36">
                <h1 class="font-bold text-lg lg:text-2xl">Bienvenido</h1>
                <div class="w-full text-left space-y-6 text-gray-600 font-bold text-sm">
                    <div class="space-y-1">
                        <label for="user">Usuario</label>
                        <input v-model="form.email" id="user" type="text"
                               class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-0 focus:border-blue-500 transition duration-200">
                    </div>
                    <div class="space-y-1">
                        <label for="password">Contraseña</label>
                        <input v-model="form.password" id="password" type="password"
                               class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-0 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
                <div class="w-full flex flex-col flex-col-reverse lg:flex-row justify-between items-center">
                    <inertia-link :href="route('register')" class="underline text-gray-500 font-bold mt-8 lg:mt-0">
                        ¿No tienes una cuenta? Regístrate
                    </inertia-link>
                    <button @click="submit"
                            type="submit"
                            :disabled="button_submit == false"
                            :class="button_submit == false ? 'bg-blue-100 text-white': 'bg-blue-500 hover:bg-blue-600 focus:bg-blue-700 text-white' "
                            class="rounded-md shadow-md  font-bold transition duration-200 py-2 px-4"
                    >Iniciar sesión
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            button_submit: true,
            form: {
                email: '',
                password: '',
                buttonSubmit: true,
            }
        }
    },
    methods: {
        submit() {
            if (this.button_submit == true) {
                this.button_submit = false
                axios.post(route('custom_login'), this.form)
                    .then(({data}) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Usuario validado',
                            showConfirmButton: false,
                            timer: 800
                        }).then(() => {
                            window.location = route('notes.index');
                        });
                    })
                    .catch((err) => {
                        if (this.form.password == '' || this.form.email == '') {
                            let error = err.response.data
                            let template = ""

                            Object.keys(error.errors).forEach((key) => {
                                template += `<li class="mb-2">${error.errors[key]}</li>`
                            });

                            return this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: `<ul>${template}</ul>`,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#3B82F6'
                            }).then(() => this.button_submit = true);
                        } else {
                            return this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Usuario o contraseña incorrectos.',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#3B82F6'
                            }).then(() => this.button_submit = true);
                        }
                    });
            } else {
                this.button_submit = false
            }
        }
    }
}
</script>

<style scoped>

</style>
