<template>
    <div>
        <!-- PRODUCTS -->
        <section id="authors" class="my-5 text-center">
            <div data-aos="slide-down">
                <div class="container">

                    <div class="row">
                        <div class="col">
                            <div class="info-header mb-5">
                                <h1 class="text-primary pb-3">
                                    Neki od naših gotovih proizvoda
                                </h1>
                                <p class="lead">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias laborum numquam aperiam dolores a porro!
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div :key="product.id" class="col-lg-4 col-md-6" v-for="product in allProducts">
                            <div class="card">
                                <div @click="getProduct(product.id)" class="card-body">
                                    <img :src="'../img/products/' + product.photo_id" alt="" class="img-fluid rounded-circle w-80 mb-3">
                                    <h3>{{product.name}}</h3>
                                    <h5 class="text-muted">{{product.description}}</h5>
                                    <!--<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed commodi nostrum, ab libero voluptas officia.</p>-->
                                    <div id="con" class="d-flex justify-content-center">
                                        <router-link to="/product" class="btn btn-primary btn-lg mt-3"><a><span>Više ... </span></a></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {

        name: "Products",

        computed: mapGetters(['allProducts', 'oneProduct',]),

        methods: {
            ...mapActions(['fetchProducts', 'fetchProduct']),

            getProduct(product) {
                const selProduct = product;
                this.fetchProduct(selProduct);
            }
        },

        created() {
            this.fetchProducts();
        }
    }
</script>
