<template>
    <div class="">
        <div class="container">
            <div class="row">

                <div class="col-4 my-5">
                    <nav  @click="getProduct(product, product.id)" :key="product.id"
                          class="nav flex-column list-group" v-for="product in allProducts">
                        <a style="height:150px;" class="nav-link list-group-item list-group-item-action list-group-item-primary">{{product.name}}
                            <img :src="'../img/' + product.photo_id" class="img-fluid mx-auto d-block h-75">
                        </a>
                    </nav>
                </div>

                <div class="col-8 my-5">
                    <div class="card">
                        <transition name="slide" mode="out-in" appear>
                            <div :key="oneProduct.id" v-if="oneProduct.id" class="card-body">
<!--                                <a :href="oneRep.website" target="_blank"><img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block"></a>-->
                                <img :src="'../img/' + oneProduct.photo_id" alt="" class="img-fluid rounded-circle w-50 my-3 mx-auto d-block">
                                <h3>{{ oneProduct.name }}</h3>
<!--                                <h5 class="text-muted">{{oneRep.short_desc}}</h5>-->
                                <p class="my-3" v-html="oneProduct.description"></p>

                                <div >
                                    <img :src="'../img/companies/docs/pdfdown.png'" alt="" class="img-fluid my-3">
                                    <div :key="productDet.id" v-for="productDet in allProductDet">
<!--                                        <a :href="'../img/companies/docs/' + repDet.doc_id" target="_blank" class="my-3"><i class="cap-icon ci-download m-1"></i> {{repDet.title}}</a>-->
                                        <p>{{ productDet.title }}</p>
                                    </div>
                                </div>
                            </div>
                            <div key=2 v-else class="card-body">
                                <i class="cap-icon ci-shopping-cart-full mb-2 activ mx-auto" style="cursor: pointer; font-size: 80px"></i>
                                <!--<img src="img/person3.jpg" alt="" class="img-fluid rounded-circle w-50 mb-3">-->
                                <h3 class="mt-3 mb-3">Naši proizvodi</h3>
                                <!--<h5 class="text-muted">CEO</h5>-->
                                <p>Proizvodi koje prodajemo</p>
                                <p>Molimo Vas da nam se obratite ako imate bilo kakvo pitanje vezano za navedene proizvode.</p>
                                <p>Klikom na nazive proizvoda možete pročitati detaljniji opis istih, tj. naći dodatne informacije.</p>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {

        name: "Products",

        computed:
            mapGetters([
                'allProducts',
                'oneProduct',
                'allProductDet'
            ]),

        methods: {
            ...mapActions([
                'fetchProducts',
                'fetchProduct',
                'resetProductState',
                'fetchProductDet'
            ]),

            getProduct(product, id) {
                const selProduct = product;
                const selProductID = id;
                this.fetchProduct(selProductID);
                this.fetchProductDet(selProductID);
            }
        },

        created() {
            this.fetchProducts();
        },

        destroyed:function(){
            this.resetProductState();
        }
    }
</script>

<style scoped>
    .nav-link {
        background-color: white;
    }
</style>