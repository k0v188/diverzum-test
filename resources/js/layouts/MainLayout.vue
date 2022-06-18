<template>
<div>
    <v-app class="bg-light">
        <NavbarComponent />
        <div>
            <router-view></router-view>
        </div>
    </v-app>
</div>
</template>

<script>
import NavbarComponent from '../components/NavbarComponent.vue'
    export default {
        name: "MainLayout",
        components: {
            NavbarComponent
        }
    }
</script>

<style lang="scss" scoped>

</style>
