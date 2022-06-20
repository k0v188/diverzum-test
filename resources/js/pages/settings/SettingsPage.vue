<template>
    <div class="mt-5 container-fluid">
        <v-row>
            <v-col cols="12" xs="12" md="3">
                <v-card class="mx-auto">
                    <v-list nav>

                        <v-list-item link :to="{ name: 'settings-coupons' }">
                            <v-list-item-content>
                                <v-list-item-title>Kuponok</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link :to="{ name: 'settings-products' }">
                            <v-list-item-content>
                                <v-list-item-title>Termékek</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                </v-card>
            </v-col>
            <v-col cols="12" xs="12" md="9">
                <router-view></router-view>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: 'SettingsPage',
    }
</script>

<style lang="scss" scoped>

</style>
