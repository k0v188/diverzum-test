<template>
    <v-data-table
        :headers="headers"
        :items="products"
        :options.sync="options"
        :loading="loading"
        :hide-default-footer="true"
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>Termékek</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            dark
                            class="mb-2"
                            v-bind="attrs"
                            v-on="on"
                        >
                            Új létrehozása
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <v-text-field
                                            v-model="editedItem.company_name"
                                            :error-messages="errors.company_name"
                                            label="Márkanév"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-text-field
                                            v-model="editedItem.company_url"
                                            :error-messages="errors.company_url"
                                            label="Márka honlapja"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-text-field
                                            v-model="editedItem.name"
                                            :error-messages="errors.name"
                                            label="Terméknév"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-select
                                            :items="coupons"
                                            label="Kupon"
                                            item-text="name"
                                            item-value="id"
                                            v-model="editedItem.coupon_id"
                                            persistent-hint
                                            hint="Ha nincs kiválasztva kupon, akkor átirányít a márka honlapjára"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">
                                Mégsem
                            </v-btn>
                            <v-btn color="blue darken-1" text @click="save">
                                Mentés
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5"
                            >Biztosan törölni szeretnéd ezt a
                            terméket?</v-card-title
                        >
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="closeDelete"
                                >Mégsem</v-btn
                            >
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="deleteItemConfirm"
                                >Igen</v-btn
                            >
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:[`item.discount`]="{ item }">
            <span> {{item.discount}} % </span>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
            <v-icon small @click="editItem(item)" class="mx-3">
                fa-pencil
            </v-icon>
            <v-icon small @click="deleteItem(item)"> fa-trash </v-icon>
        </template>
    </v-data-table>
</template>

<script>
import ApiMixins from "../../mixins/api";
export default {
    mixins: [ApiMixins],
    name: "SeetingsProductsPage",
    data: () => ({
        dialog: false,
        dialogDelete: false,
        totalCount: 1,
        loading: true,
        options: {},
        headers: [
            {
                text: "Márkanév",
                align: "start",
                sortable: false,
                value: "company_name",
            },
            { text: "Terméknév", value: "name" },
            { text: "Kupon", value: "coupon.name" },
            { text: "Műveletek", value: "actions", sortable: false },
        ],
        products: [],
        coupons: [],
        editedIndex: -1,
        editedItem: {
            name: "",
            company_name: "",
            company_url: "",
        },
        defaultItem: {
            name: "",
            company_name: "",
            company_url: "",
        },
        types: [
            { text: "Állandó", value: "one" },
            { text: "Egyedi", value: "custom" },
        ],
        errors: [],
        edited: false,
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Új kupon" : "Szerkesztés";
        },
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
    },

    created() {
        this.initialize();
    },

    methods: {
        initialize() {
            if (this.coupons.length == 0) {
                this.get("api/coupons").then((response) => {
                    this.coupons = response;
                    console.log('this.coupons', this.coupons);
                });
            }
            this.get("api/products").then((response) => {
                this.products = response;
                console.log('this.products', this.products);
                this.loading = false;
            });
        },

        editItem(item) {
            this.editedIndex = this.products.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            this.edited = true;
        },

        deleteItem(item) {
            this.editedIndex = this.products.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.delete("api/products/" + this.editedItem.id)
                .then(() => {
                    this.products.splice(this.editedIndex, 1);
                    this.closeDelete();
                })
                .catch((errors) => {
                    console.log('errors', errors);
                });
        },

        close() {
            this.dialog = false;
            this.edited = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        save() {
            this.errors = [];
            if (this.edited) {
                this.put("api/products/" + this.editedItem.id, this.editedItem)
                    .then((response) => {
                        console.log('response', response);
                        Object.assign(this.products[this.editedIndex], response);
                        this.close();
                    })
                    .catch((errors) => {
                        this.errors = errors.response.data.errors;
                    });
            } else {
                this.post("api/products", this.editedItem)
                    .then((response) => {
                        this.initialize();
                        this.close();
                    })
                    .catch((errors) => {
                        this.errors = errors.response.data.errors;
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
