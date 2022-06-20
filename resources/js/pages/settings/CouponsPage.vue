<template>
    <v-data-table
        :headers="headers"
        :items="coupons"
        :options.sync="options"
        :server-items-length="totalCount"
        :loading="loading"
        :hide-default-footer="true"
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>Kuponok</v-toolbar-title>
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
                                            v-model="editedItem.name"
                                            :error-messages="errors.name"
                                            label="Név"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-text-field
                                            v-model="editedItem.discount"
                                            :error-messages="errors.discount"
                                            type="number"
                                            label="Kedvezmény"
                                            suffix="%"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-select
                                            :items="types"
                                            label="Típus"
                                            v-model="editedItem.type"
                                            :error-messages="errors.type"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-checkbox
                                            v-model="editedItem.active"
                                            :error-messages="errors.active"
                                            label="Aktív"
                                        ></v-checkbox>
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
                            kupont?</v-card-title
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
        <template v-slot:[`item.type`]="{ item }">
            <span v-if="item.type == 'one'">Állandó</span>
            <span v-if="item.type == 'custom'">Egyedi</span>
        </template>
        <template v-slot:[`item.active`]="{ item }">
            <div v-if="item.active">
                <v-icon small>fa-check</v-icon>
            </div>
        </template>
        <template v-slot:[`item.discount`]="{ item }">
            <span> {{ item.discount }} % </span>
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
    name: "SeetingsCouponsPage",
    data: () => ({
        dialog: false,
        dialogDelete: false,
        totalCount: 1,
        loading: true,
        options: {},
        headers: [
            {
                text: "Név",
                align: "start",
                sortable: false,
                value: "name",
            },
            { text: "Kód", value: "code" },
            { text: "Típus", value: "type" },
            { text: "Kedzemény", value: "discount" },
            { text: "Aktív", value: "active" },
            { text: "Műveletek", value: "actions", sortable: false },
        ],
        coupons: [],
        editedIndex: -1,
        editedItem: {
            name: "",
            type: "one",
            discount: 0,
            active: true,
        },
        defaultItem: {
            name: "",
            type: "one",
            discount: 0,
            active: true,
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
            this.get("api/coupons").then((response) => {
                this.coupons = response;
                this.loading = false;
            });
        },

        editItem(item) {
            this.editedIndex = this.coupons.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            this.edited = true;
        },

        deleteItem(item) {
            this.editedIndex = this.coupons.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.delete("api/coupons/" + this.editedItem.id)
                .then(() => {
                    this.coupons.splice(this.editedIndex, 1);
                    this.closeDelete();
                })
                .catch((errors) => {
                    console.log("errors", errors);
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
            console.log("edit", this.edited);
            this.errors = [];
            if (this.edited) {
                console.log("edit", this.editedItem);
                this.put("api/coupons/" + this.editedItem.id, this.editedItem)
                    .then((response) => {
                        Object.assign(this.coupons[this.editedIndex], response);
                        this.close();
                    })
                    .catch((errors) => {
                        this.errors = errors.response.data.errors;
                    });
            } else {
                this.post("api/coupons", this.editedItem)
                    .then((response) => {
                        this.coupons.push(response);
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
