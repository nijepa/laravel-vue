<template>
    <section id="icon-boxes" class="p-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4" :key="aboutDet.id" v-for="aboutDet in allAboutDet">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="cap-icon mb-4 activ" :class="classes(aboutDet.id)"></i>
                            <p class="mt-4">{{aboutDet.description}}</p>
<!--                            <p>Kada je u pitanju izvoz kompanija u najvećoj meri sarađuje sa domaćim livnicama za koje sa stranim partnerima započinje zajedničke poslove sa obezbeđenim ino-plasmanom. Pored livaca sarađuje se i sa PVC, keramičkom industrijom, proizvođačima peći i kamina i mnogim drugim.</p>-->
                        </div>
                    </div>
                </div>
           <!--     <div class="col-lg-4 col-md-4">
                    <div class="card bg-dark text-white text-center">
                        <div class="card-body">
                            <i class="cap-icon ci-refresh mb-2 activ"></i>
                            <p>Kompanija DONAU obezbeđuje kompletan repromaterijal od poznatih svtskih proizvođača sirovina za keramičku industriju, industriju proizvođača peći i kamina, kao i sirovine i aditive razne druge oblasti (pogledajte listu firmi koje zastupamo ili nam se obratite sa zahtevom.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="cap-icon ci-tools mb-2 activ"></i>
                            <p>Odlična pozicija, kontakti i ugled u Zapadnoj Evropi i na ruskom tržistu Vam garantuju dobar servis i obezbeđuju neprocenjivu pomoć u slučaju da želite da obezbedite kontakt i dugoročnu uvozno-izvoznu saradnju sa bilo kojom inostranom firmom.</p>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {

        name: "Quotes",

        computed: mapGetters([ 'allAboutDet']),

        methods: {
            ...mapActions([ 'fetchAboutDet']),

            classes(id) {
                switch(id) {
                    case 1:
                        return 'ci-load';
                        break;
                    case 2:
                        return 'ci-box-opened';
                        break;
                    case 3:
                        return 'ci-compass';
                        break;
                }
            }
        },

        created() {
            this.fetchAboutDet();
        },
    }
</script>

<style scoped>
    .activ {
        color: white;
        font-size: 80px;
    }
    .activ:hover {
        color:#17a2b8;
        font-size: 80px;
    }
    .card-body {
        min-height: 350px;
    }
</style>