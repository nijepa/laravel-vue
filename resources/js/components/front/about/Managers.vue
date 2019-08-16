<template>
    <div>
        <section id="authors" class="my-5 text-center">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="info-header mb-5">
                            <h1 class="text-primary pb-3">
                                Naši tuljani
                            </h1>
                            <p class="lead">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias laborum numquam aperiam dolores a porro!
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6" :key="contact.id" v-for="contact in allContacts">
                        <div class="card">
                            <div class="card-body">
                                <img src="img/person3.jpg" alt="" class="img-fluid rounded-circle w-50 mb-3">
                                <h3>{{contact.name}}</h3>
                                <h5 class="text-muted">{{contact.title}}</h5>
                                <div class="d-flex justify-content-center">
                                    <a :href="'mailto:' + contact.email"><i @mouseover="hover1 = true" @mouseleave="hover1 = false" :class="{'cap-icon ci-envelope m-2': hover1 == false, 'cap-icon ci-envelope-out m-2': hover1 == true}"></i></a>
                                    <a :href="'tel:'+ contact.phone"><i @mouseover="hover2 = true" @mouseleave="hover2 = false" :class="{'cap-icon ci-mobile m-2': hover2 == false, 'cap-icon ci-phone m-2': hover2 == true}"></i></a>
                                    <a :href="'tel:'+ contact.whatsapp"><i @mouseover="hover3 = true" @mouseleave="hover3 = false" :class="{'cap-icon ci-whatsapp-squared m-2': hover3 == false, 'cap-icon ci-whatsapp-circled m-2': hover3 == true}"></i></a>
                                    <a :href="'url:'+ contact.facebook" target="_top"><i @mouseover="hover4 = true" @mouseleave="hover4 = false" :class="{'cap-icon ci-facebook-squared m-2': hover4 == false, 'cap-icon ci-facebook-circled m-2': hover4 == true}"></i></a>
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

        name: "Managers",

        computed: mapGetters([ 'allContacts']),

        methods: {
            ...mapActions([ 'fetchContactsF'])
        },

        created() {
            this.fetchContactsF();
        },

        data() {
            return {
                hover1: false,
                hover2: false,
                hover3: false,
                hover4: false,
            }
        }
    }
</script>

<style scoped>
    i {
        font-size: 30px;
        cursor: pointer;
        color: black;
    }

    a {
        color: ghostwhite;
        text-decoration: none;
        font-size: 1.5rem;
    }
</style>