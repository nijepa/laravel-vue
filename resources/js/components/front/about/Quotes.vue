<template>
    <section id="icon-boxes" class="p-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4" :key="aboutDet.id" v-for="aboutDet in allAboutDet">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="cap-icon mb-4 activ" :class="classes(aboutDet.id)"></i>
                            <p class="mt-4" v-html="aboutDet.description"></p>
                        </div>
                    </div>
                </div>
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
                    case 2:
                        return 'ci-box-opened';
                    case 3:
                        return 'ci-compass';
                }
            }
        },

        created() {
            this.fetchAboutDet(1);
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
