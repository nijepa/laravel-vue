<template>
    <div class="">
        <header id="page-header">
            <div class="container">
                <div class="row">
                    <div class="col m-auto text-center  has-overlay">
                        <h1>Proizvodi</h1>
                        <p>stranih kompanija</p>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-4 my-5">
                    <nav  @click="getProduct(product)" :key="product.id" class="nav flex-column list-group" v-for="product in allProducts">
                        <a style="height:150px;" href="#" class="nav-link list-group-item list-group-item-action list-group-item-primary">{{product.name}} <img :src="'../img/' + product.photo_id" class="img-fluid mx-auto d-block h-75"></a>
                    </nav>
                </div>

                <div class="col-8 my-5">
                    <div class="card">
                        <transition name="slide" mode="out-in" appear>
                            <div :key="oneProduct.id" v-if="oneProduct.id" class="card-body">
<!--                                <a :href="oneRep.website" target="_blank"><img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block"></a>-->
                                <img :src="'../img/' + oneProduct.photo_id" alt="" class="img-fluid rounded-circle w-50 my-3 mx-auto d-block">
                                <h3>{{oneProduct.name}}</h3>
<!--                                <h5 class="text-muted">{{oneRep.short_desc}}</h5>-->
                                <p class="my-3" v-html="oneProduct.description"></p>
                         <!--       <div v-if="allRepDet.length">
                                    <img :src="'../img/companies/docs/pdfdown.png'" alt="" class="img-fluid my-3">
                                    <div :key="repDet.id" v-for="repDet in allRepDet">
                                        <a :href="'../img/companies/docs/' + repDet.doc_id" target="_blank" class="my-3"><i class="cap-icon ci-download m-1"></i> {{repDet.title}}</a>
                                    </div>
                                </div>-->
                            </div>
                            <div key=2 v-else class="card-body">
                                <i class="cap-icon ci-compass mb-2 activ mx-auto" style="cursor: pointer; font-size: 80px"></i>
                                <!--<img src="img/person3.jpg" alt="" class="img-fluid rounded-circle w-50 mb-3">-->
                                <h3>Zastupanja stranih kompanija</h3>
                                <!--<h5 class="text-muted">CEO</h5>-->
                                <p>Iskustvo, kao i dugogodišnje poslovanje sa pomenutim evropskim firmama i mnogim drugim Vam garantuju kvalitetnu i fer saradnju.</p>
                                <p>Molimo Vas da nam se obratite ako imate bilo kakvo pitanje vezano za dole navedene firme ili njihove proizvodne programe.</p>
                                <p>Jedna od osnovnih karakterisitka i uslova u našem poslovanju jeste kompletan servis koji pružamo na zahtev svih zainteresovanih kupaca u vidu pomoći, asistencije, informacija iz bilo koje od pomenutih oblasti, uzorkovanja, posete tehničara i laboranata, tj. stavljanja u servis svih firmi sa kojima smo potpisali ugovor o ekskluzivnom zastupanju.</p>
                                <p>Klikom na nazive firmi možete pročitati detaljniji opis istih, tj. naći dodatne informacije o njihovim proizvodnim programima, učitati tehnička uputstva...</p>
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

        computed: mapGetters(['allProducts', 'oneProduct', 'allProductDet']),

        methods: {
            ...mapActions(['fetchProductsF', 'fetchProduct', 'resetProductState', 'fetchProductDet']),

            getProduct(product) {
                const selProduct = product;
                this.fetchProduct(selProduct);
                this.fetchProductDet(selProduct);
                //console.log(selRep)
            }
        },

        created() {
            this.fetchProductsF();
        },

        destroyed:function(){
            this.resetProductState();
        }

    }
</script>

<style scoped>

</style>