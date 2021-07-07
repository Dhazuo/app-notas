<template>
    <!--#Header-->
    <div class="w-full h-14 shadow-md fixed z-20 bg-red-500 px-2 lg:px-6 py-2 flex justify-between items-center">
        <button @click="sidebarAction" class="p-2 text-white block lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="6" x2="20" y2="6"></line>
                <line x1="4" y1="12" x2="20" y2="12"></line>
                <line x1="4" y1="18" x2="20" y2="18"></line>
            </svg>
        </button>
        <div class="text-xl text-white font-semibold flex space-x-12 items-center">
            <inertia-link :href="route('notes.index')">Page title</inertia-link>
            <div class="space-x-4 hidden lg:flex">
                <navlink-component :href="route('notes.index')" :active="route().current('notes.index')">
                    Todas las notas
                </navlink-component>
                <navlink-component :href="route('notes.categories')" :active="route().current('notes.categories')">
                    Por categorías
                </navlink-component>
            </div>
        </div>
        <button @click="showOptions" class="rounded-full h-12 w-12 bg-white text-gray-500 focus:outline-none hidden lg:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user w-full h-full " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            </svg>
        </button>
        <button @click="showOptionsSm" class="rounded-full h-12 w-12 bg-white text-gray-500 focus:outline-none block lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user w-full h-full " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            </svg>
        </button>
    </div>
    <!--#Sidebar-->
    <div v-show="sidebar" @click="sidebarAction" class="absolute w-full h-full bg-black bg-opacity-50 z-20 block lg:hidden"></div>
    <div v-show="sidebar" class="absolute w-1/2 p-6 h-full bg-red-500 z-30 side -translate-x-full block lg:hidden transition duration-500">
        <button @click="sidebarAction" class="absolute p-2 text-white top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="12" x2="14" y2="12"></line>
                <line x1="4" y1="12" x2="8" y2="16"></line>
                <line x1="4" y1="12" x2="8" y2="8"></line>
                <line x1="20" y1="4" x2="20" y2="20"></line>
            </svg>
        </button>
        <div class="space-y-4 mt-8">
            <navlink-component class="block" :href="route('notes.index')" :active="route().current('notes.index')">
                Todas las notas
            </navlink-component>
            <navlink-component class="block" :href="route('notes.categories')" :active="route().current('notes.categories')">
                Por categorías
            </navlink-component>
        </div>
    </div>

    <!--#Options-->
    <div v-show="options_menu"
         class="options opacity-0 scale-75 transition duration-200 w-1/6 absolute z-20 top-12 right-4 transform translate-y-2 bg-white rounded-md shadow-md border border-gray-300 py-4 origin-top-right">
        <button @click="logout" class="px-2 py-2 hover:bg-gray-100 transition duration-200 font-bold text-gray-600 w-full">
            Cerrar sesión
        </button>
    </div>
    <!--#OptionsSm-->
    <div v-show="options_menu_sm" class="optionsSm flex items-center h-14 transition duration-500 w-full fixed z-0 top-12 transform -translate-y-full bg-white rounded-md shadow-md border border-gray-300">
        <button :disabled="button_logout == false" @click="logout" class="px-2 py-2 hover:bg-gray-100 transition duration-200 font-bold text-gray-600 w-full">
            Cerrar sesión
        </button>
    </div>

    <!--#Content-->
    <div class="w-full pt-16 pb-6 px-6 content opacity-0 transition duration-500">
        <slot name="content"></slot>
    </div>
    </template>

<script>
import NavlinkComponent from "../Components/NavlinkComponent";
export default {
    components: {NavlinkComponent},
    mounted() {
        if (document.querySelector('.content.opacity-0')){
            let opa_anim = document.querySelector('.content.opacity-0');
            setTimeout(() => {
                opa_anim.classList.remove('opacity-0');
                opa_anim.classList.add('opacity-100');
            }, 100)
        }
    },
    data(){
        return{
            button_logout: true,
            options_menu: false,
            options_menu_sm: false,
            sidebar: false
        }
    },
    methods: {
        sidebarAction(){
            if (this.sidebar == false) {
                let side = document.querySelector('.side.-translate-x-full');
                this.sidebar = !this.sidebar
                setTimeout(() => {
                    side.classList.remove('-translate-x-full');
                    side.classList.add('translate-x-0');
                }, 100)
            } else {
                let side = document.querySelector('.side.translate-x-0');
                setTimeout(() => {
                    side.classList.remove('translate-x-0');
                    side.classList.add('-translate-x-full');
                }, 100)
                setTimeout(() => this.sidebar = !this.sidebar, 600)
            }
        },
        showOptions(){
            if (this.options_menu == false) {
                this.options_menu = !this.options_menu;
                let menu_anim = document.querySelector('.options.opacity-0.scale-75');
                setTimeout(() => {
                    menu_anim.classList.remove('opacity-0');
                    menu_anim.classList.add('opacity-100');
                    menu_anim.classList.remove('scale-75');
                    menu_anim.classList.add('scale-100');
                }, 100);
            } else {
                this.options_menu = !this.options_menu;
                let menu_anim = document.querySelector('.options.opacity-100.scale-100');
                menu_anim.classList.remove('opacity-100');
                menu_anim.classList.add('opacity-0');
                menu_anim.classList.remove('scale-100');
                menu_anim.classList.add('scale-75');
            }
        },
        showOptionsSm(){
            if (this.options_menu_sm == false) {
                this.options_menu_sm = !this.options_menu_sm;
                let menu_anim = document.querySelector('.optionsSm.-translate-y-full');
                setTimeout(() => {
                    menu_anim.classList.remove('-translate-y-full');
                    menu_anim.classList.add('translate-y-2');
                }, 100);
            } else {
                let menu_anim = document.querySelector('.optionsSm.translate-y-2');
                setTimeout(() => {
                    menu_anim.classList.remove('translate-y-2');
                    menu_anim.classList.add('-translate-y-full');
                }, 100);
                setTimeout(() => this.options_menu_sm = !this.options_menu_sm, 400)
            }
        },
        logout(){
            if (this.button_logout == true) {
                this.button_logout = false
                axios.post(route('logout'), {})
                    .then(() => {
                        window.location = route('index');
                    })
            } else {
                this.button_logout = false
            }
        }
    },
}
</script>

<style scoped>

</style>
