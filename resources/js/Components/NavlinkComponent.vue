<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
export default {
    props: ['href', 'active'],
    computed: {
        classes(){
            return this.active ? 'text-center text-base py-2 border-b-4 border-white text-white font-bold' : 'text-center text-base py-2 border-b-4 border-transparent text-white font-bold';
        }
    },
}
</script>

<style scoped>

</style>
