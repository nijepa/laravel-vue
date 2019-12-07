<template>
    <section id="about" class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 v-html="oneAbout.title"></h1>
                    <p v-html="oneAbout.body"></p>
<!--                    <p>Kompanija DONAU se sastoji iz tri zasebna preduzeća. Osnovna firma DONAU TRADE D.O.O. je osnovana 1991. godine i bavi se pre svega izvozom, uvozom i zastupanjem stranih firmi u Srbiji i obrnuto. DONAU TRADING D.O.O. se bavi proizvodnjom nameštaja od masiva i opremanjem enterijera. JINRAN TRADING je orijentisana ka izvoznim poslovima i specifičnim zahtevima...</p>
                    <p>1996. godine kompanija Donau je otkupila proizvodnju za obradu masivmog drveta na Avali i izgradila potpuno nov i unikatan proizvodni program. Pored standardnih baštenskih garnitura, kućnog nameštaja, kuhinja (kreveti, stolice, stolovi, ormani, program za kupatila...) i opremanja entrijera, razvili smo i seriju unikatnog, oslikanog etno nameštaja za kućni i poslovni enterijer zajedno sa izradom specijanih preslikača za drvo/staklo/keramiku koji svoju namenu nalaze za ukrašavanje delova nameštaja, izradu ručica za nameštaj...</p>-->
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <img src="img/donau.jpg" alt="" class="img-rounded img-responsive" >
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "Info",

        computed: mapGetters([ 'oneAbout']),

        methods: {
            ...mapActions([ 'fetchAbout'])
        },

        created() {
            this.fetchAbout(1);
        },
    }
</script>

<style scoped>

</style>
