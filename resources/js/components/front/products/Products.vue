<template>
    <div class="">
        <div class="container">
            <div class="row">

                <div class="col-4 my-5">
                    <nav @click="getProduct(product, product.id)" :key="product.id"
                          class="nav flex-column list-group" v-for="product in allProducts">
                        <a @click="moveTo" :class="{ active : active_el === product.id }" style="height:150px;"
                           class="nav-link list-group-item list-group-item-action list-group-item-primary list-font">{{product.name}}
                            <img :src="'../img/products/' + product.photo_id" class="img-fluid mx-auto d-block h-75">
                        </a>
                    </nav>
                </div>

                <div class="col-8 my-5">
                    <div class="card">
                        <transition name="slide" mode="out-in" appear>
                            <div :key="oneProduct.id" v-if="oneProduct.id" class="card-body">
<!--                                <a :href="oneRep.website" target="_blank"><img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block"></a>-->
                                <img :src="'../img/products/' + oneProduct.photo_id" alt="" class="img-fluid rounded-circle w-50 my-3 mx-auto d-block">
                                <h3>{{ oneProduct.name }}</h3>
<!--                                <h5 class="text-muted">{{oneRep.short_desc}}</h5>-->
                                <h4 class="my-3" v-html="oneProduct.description"></h4>
                                <hr>
                                <p v-html="oneProduct.body"></p>

                                <div v-if="allProductDet.length">
                                    <h1 class="h-color my-3 font-weight-bold">DETALJI</h1>
                                    <div :key="productDet.id" v-for="productDet in allProductDet" class="my-3">
<!--                                        <a :href="'../img/companies/docs/' + repDet.doc_id" target="_blank" class="my-3"><i class="cap-icon ci-download m-1"></i> {{repDet.title}}</a>-->
                                        <h3 class="font-italic">{{ productDet.title }}</h3>
                                        <p v-html="productDet.description"></p>
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

        data() {
            return {
                classe: '',
                active_el: 0,
                isActive: false,
            }
        },

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

            moveTo () {
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            },

            getProduct(product, id) {
                const selProduct = product;
                const selProductID = id;
                this.fetchProduct(selProductID);
                this.fetchProductDet(selProductID);
                this.classe = 'active';
                this.activate(selProductID);
            },

            activate:function(el){
                this.active_el = el;
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
    .h-color {
        color: #1f6fb2;
    }

    .nav-link {
        background-color: white;
    }

    a {
        cursor: pointer;
        text-decoration: none;
    }

    .list-font {
        font-size: 20px;
    }

    @media (max-width: 858px) {
        .list-font {
            font-size: 14px;
        }
    }

    @media (max-width: 780px) {
        .list-font {
            font-size: 13px;
        }
    }

    @media (max-width: 702px) {
        .list-font {
            font-size: 12px;
        }
    }

    @media (max-width: 724px) {
        .list-font {
            font-size: 11px;
        }
    }

    @media (max-width: 623px) {
        .list-font {
            font-size: 10px;
        }
    }
</style>
