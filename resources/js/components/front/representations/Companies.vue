<template>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-8 my-3">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a @click="switchMenu('Info')" class="nav-item nav-link active" href="#">Info <span class="sr-only">(current)</span></a>
                                <div v-if="allRepDetAbout.length">
                                    <a class="nav-item nav-link" href="#">O Firmi</a>
                                </div>
                                <div v-if="allRepDetProduct.length">
                                    <a @click="switchMenu('Product')" class="nav-item nav-link" href="#">Proizvodi</a>
                                </div>
                                <div v-if="allRepDetDownload.length">
                                    <a @click="switchMenu('Download')" class="nav-item nav-link" href="#">Downloads</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-4 mb-3">
                    <nav @click="getRep(rep, rep.id)" :key="rep.id"
                         class="nav flex-column list-group" v-for="rep in allReps">
                        <a @click="moveTo" :class="{ active : active_el === rep.id }"
                           class="nav-link list-group-item list-group-item-action list-group-item-primary list-font">{{rep.name}}
                            <img :src="'../img/companies/logosSmall/' + rep.logo_small_id" class="img-fluid mx-auto d-block" alt="">
                        </a>
                    </nav>
                </div>

                <div class="col-8 mb-3">
                    <div class="card">
                        <transition name="slide" mode="out-in" appear>
       <!--                     <div :key="oneRep.id" v-if="oneRep.id" class="card-body">
                                <a :href="oneRep.website" target="_blank">
                                    <img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block" alt="">
                                </a>
                                <img :src="'../img/companies/' + oneRep.photo_id"
                                     alt="" class="img-fluid rounded-circle w-50 my-3 mx-auto d-block">
                                <h3>{{oneRep.name}}
                                    <a :href="oneRep.website" target="_blank"><i class='cap-icon ci-website' :title="oneRep.website"></i></a>
                                </h3>
                                <h5 class="text-muted">{{oneRep.short_desc}}</h5>
                                <p class="my-3" v-html="oneRep.description"></p>

                                <div v-if="allRepDet.length">
                                    <img :src="'../img/companies/docs/pdfdown.png'" alt="" class="img-fluid my-3">
                                    <div :key="repDet.id" v-for="repDet in allRepDet">
                                        <a :href="'../img/companies/docs/' + repDet.doc_id" target="_blank" class="my-3">
                                            <i class="cap-icon ci-download m-1"></i> {{repDet.title}}
                                        </a>
                                    </div>
                                </div>
                            </div>-->

                            <div :key="oneRep.id" v-if="oneRep.id" class="card-body">
                                <a :href="oneRep.website" target="_blank">
                                    <img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block" alt="">
                                </a>
                                <img :src="'../img/companies/' + oneRep.photo_id"
                                     alt="" class="img-fluid rounded-circle w-50 my-3 mx-auto d-block">
                                <h3>{{oneRep.name}}
                                    <a :href="oneRep.website" target="_blank"><i class='cap-icon ci-website' :title="oneRep.website"></i></a>
                                </h3>
                                <div v-if="activeMenuItem === 'Info'" class="card-body">
                                    <h5 class="text-muted">{{oneRep.short_desc}}</h5>
                                    <p class="my-3" v-html="oneRep.description"></p>
                                </div>
                                <div v-if="activeMenuItem === 'Download'">
                                    <img :src="'../img/companies/docs/pdfdown.png'" alt="" class="img-fluid my-3">
                                    <div :key="repDet.id" v-for="repDet in allRepDet">
                                        <a :href="'../img/companies/docs/' + repDet.doc_id" target="_blank" class="my-3">
                                            <i class="cap-icon ci-download m-1"></i> {{repDet.title}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div key=2 v-else class="card-body">
                                <i class="cap-icon ci-compass activ mx-auto" style="cursor: pointer; font-size: 80px"></i>
                                <h3 class="mt-3 mb-3">Zastupanja stranih kompanija</h3>
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

        name: "Companies",

        data() {
            return {
                classe: '',
                active_el: 0,
                isActive: false,
                activeMenuItem: 'Info'
            }
        },

        computed:
            mapGetters([
                'allReps',
                'oneRep',
                'allRepDet',
                'allRepDetDownload',
                'allRepDetAbout',
                'allRepDetProduct'
            ]),

        methods: {
            ...mapActions([
                'fetchReps',
                'fetchRep',
                'resetRepState',
                'fetchRepDet',
                'fetchRepDetDownload',
                'fetchRepDetAbout',
                'fetchRepDetProduct'
            ]),

            moveTo () {
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            },

            switchMenu(menuItem) {
                this.activeMenuItem = menuItem;
            },

            getRep(rep, id) {
                const selRep = rep;
                const selRepID = id;
                const infoT = 'Download';
                const infoA = 'About';
                const infoP = 'Product';
                //console.log(id);
                this.fetchRep(selRepID);
                this.fetchRepDet(selRepID);
                let obj = {
                    repDet: selRepID,
                    infoType: infoT,
                };
                let objA = {
                    repDet: selRepID,
                    infoType: infoA,
                };
                let objP = {
                    repDet: selRepID,
                    infoType: infoP,
                };
                console.log(obj);
                this.fetchRepDetDownload(obj);
                this.fetchRepDetAbout(objA);
                this.fetchRepDetProduct(objP);
                this.classe = 'active';
                this.activate(selRepID);
            },

            activate:function(el){
                this.active_el = el;
            },
        },

        created() {
            this.fetchReps();
        },

        destroyed:function(){
            this.resetRepState();
        }
    }
</script>

<style scoped>
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

    @keyframes slide-in {
        from {
            transform: translateX(-30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slide-out {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(-30px);
            opacity: 0;
        }
    }
</style>
