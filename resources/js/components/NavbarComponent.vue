<template>
    <v-card elevation="1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarToggler"
                aria-controls="navbarToggler"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand"
                ><router-link to="/">Diverzum Teszt</router-link></a
            >

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <template>
                        <li class="nav-item active my-2">
                            <v-btn
                                color="primary"
                                elevation="2"
                                class="mr-3"
                                :to="{ name: 'settings' }"
                                >Beállítások</v-btn
                            >
                        </li>
                    </template>
                </ul>
            </div>
        </nav>
    </v-card>
</template>

<script>

export default {
    name: "NavbarComponent",
};
</script>
<style lang="scss">

</style>
