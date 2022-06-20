<template>
    <v-container>
        <h3 class="text-center my-3">Percenként az adott kupont csak 1x használhatod fel!</h3>
        <v-row>
            <v-col
                cols="12"
                sm="6"
                md="4"
                v-for="product in products"
                :key="product.id"
            >
                <v-card
                    class="mx-auto card-outter"
                    max-width="344"
                    outlined
                    height="100%"
                >
                    <v-img
                        height="250"
                        src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                    ></v-img>

                    <v-card-title> <strong> {{ product.company_name }}</strong></v-card-title>

                    <v-card-title class="pt-0">{{ product.name }}</v-card-title>

                    <v-card-text>
                        <div v-if="product.coupon == null">
                            Nincs elérhető kupon
                        </div>
                        <div v-if="product.coupon != null">
                            <div v-if="product.coupon.type == 'one'">
                                Egyféle kuponkód,a kupon nem változik
                            </div>
                            <div v-if="product.coupon.type == 'custom'">
                                Egyedi kuponkód, beváltás után új kód
                                generálódik
                            </div>
                            <div>
                                <strong>{{ product.coupon.code }}</strong>
                            </div>
                        </div>
                    </v-card-text>

                    <v-card-actions class="justify-center card-actions">
                        <v-btn color="primary" @click="selectProduct(product)">
                            Beváltás
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5"
                        >Itt tudod beváltani a kuponodat!</span
                    >
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    label="Kuponkód"
                                    v-model="coupon"
                                    :error-messages="errors.coupon"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-alert dense outlined type="error" v-if="error != ''">
                            {{ error }}
                        </v-alert>
                        <v-alert dense text type="success" v-if="success != ''">
                            A kupon beváltásra került
                        </v-alert>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        v-if="!success"
                        @click="
                            dialog = false;
                            selectedProduct = null;
                        "
                    >
                        Mégsem
                    </v-btn>
                    <v-btn
                        v-if="!success"
                        color="blue darken-1"
                        text
                        @click="checkCoupon()"
                    >
                        Beváltom
                    </v-btn>
                    <v-btn
                        v-if="success"
                        color="blue darken-1"
                        text
                        @click="dialog = false"
                    >
                        Bezárás
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import ApiMixins from "../mixins/api";
export default {
    name: "HomePage",
    mixins: [ApiMixins],
    data: () => ({
        loading: true,
        products: [],
        dialog: false,
        coupon: "",
        errors: [],
        error: "",
        selectedProduct: null,
        success: false,
    }),

    created() {
        this.initialize();
    },

    methods: {
        initialize() {
            this.get("api/products").then((response) => {
                this.products = response;
                this.loading = false;
            });
        },

        selectProduct(product) {
            this.success = false;
            if (!product.coupon) {
                window.open(product.company_url, "_blank").focus();
            } else {
                this.dialog = true;
                this.selectedProduct = product;
            }
        },

        checkCoupon() {
            this.errors = [];
            this.error = "";
            let data = {
                coupon: this.coupon,
                product_id: this.selectedProduct.id,
            };
            this.post("/api/check", data)
                .then(() => {
                    this.selectedProduct = null;
                    this.success = true;
                    this.initialize();
                })
                .catch((errors) => {
                    if (errors.response.data.errors) {
                        this.errors = errors.response.data.errors;
                    } else {
                        this.error = errors.response.data.message;
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.card-outter {
    padding-bottom: 50px;
}
.card-actions {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>
