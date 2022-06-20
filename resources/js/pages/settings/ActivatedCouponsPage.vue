<template>
    <v-data-table
        :headers="headers"
        :items="coupons"
        :server-items-length="totalCount"
        :loading="loading"
        :hide-default-footer="true"
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>Aktivált kuponok</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
            </v-toolbar>
        </template>
        <template v-slot:[`item.discount`]="{ item }">
            <span> {{ item.discount }} % </span>
        </template>
    </v-data-table>
</template>

<script>
import ApiMixins from "../../mixins/api";
export default {
    mixins: [ApiMixins],
    name: "SettingsActivatedCouponsPage",
    data: () => ({
        dialog: false,
        dialogDelete: false,
        totalCount: 1,
        loading: true,
        options: {},
        headers: [
            {
                text: "Kód",
                align: "start",
                sortable: false,
                value: "code",
            },
            { text: "Márkanév", value: "company_name", sortable: false },
            { text: "Terméknév", value: "name", sortable: false },
            { text: "Kedzemény", value: "discount", sortable: false },
            { text: "Aktiválva", value: "created_at", sortable: false },
        ],
        coupons: [],
    }),

    created() {
        this.initialize();
    },

    methods: {
        initialize() {
            this.get("api/activated-coupons").then((response) => {
                this.coupons = response;
                this.loading = false;
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
