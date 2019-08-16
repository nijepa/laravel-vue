<template>
    <!-- ABOUT SECTION -->
    <section id="about" class="py-5 text-center bg-light">
        <div class="container" >
            <div data-aos="zoom-out-down">
                <div class="row">
                    <div class="col">

                        <div class="info-header mb-5">
                            <h1 class="text-primary pb-3">
                                Zašto DONAU?
                            </h1>
                            <p class="lead pb-3">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus obcaecati alias rerum dolore fugiat debitis?
                            </p>
                        </div>

                        <!-- ACCORDION -->
                        <div id="accordion" :key="about.id" v-for="about in allAbouts">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <div :href="'#collapse' + about.id" data-toggle="collapse" data-parent="#accordion" class="accor"  @click="onAccor(about.id)">
                                            <i :class="{'cap-icon ci-arrow-down': clicked2 == false, 'cap-icon ci-arrow-up': clicked2 == true}"></i>  {{about.caption}}
                                        </div>
                                    </h5>
                                </div>

                                <div :id="'collapse' + about.id" class="collapse">
                                    <div class="card-body">
                                        {{ about.description }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col">
                <router-link to="/about" activeClass="active" tag="a" class="btn btn-primary btn-lg mt-3">
                    <a><span>Više ... </span></a>
                </router-link>
            </div>
        </div>
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {

        name: "Faq",

        data() {
            return {
                show1: '',
                show2: '',
                show2: '',
                clicked1: true,
                clicked2: false,
                clicked3: false,
            }
        },

        computed: mapGetters(['allAbouts']),

        methods: {
            ...mapActions(['fetchAboutF']),

            onAccor(id) {
                if (id === 1) {
                    this.clicked1 = !this.clicked1
                } else if (id === 2) {
                    this.clicked2 = !this.clicked2
                } else {
                    this.clicked3 = !this.clicked3
                }
            }
        },

        created() {
            this.fetchAboutF();
        }
    }
</script>

<style scoped>
    i {
        cursor: pointer;
        color: black;
    }
    i:hover {
        color:#05618d;
    }
    .accor {
        cursor: pointer;
        color: black;
    }
    .accor:hover {
        color:#05618d;
    }
</style>