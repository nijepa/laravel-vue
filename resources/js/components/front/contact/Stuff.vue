<template>
    <section id="staff" class="py-5 text-center bg-dark text-white">
        <div class="container">
            <h1>Naš tim</h1>
            <hr>
            <div class="row">
                <div class="col-md-4" :key="contact.id" v-for="contact in allContacts">
                    <div data-aos="zoom-out-up">
                        <img :src="'img/profile/'+contact.photo_id" alt="" class="img-fluid rounded-circle mb-2">
                        <h4>{{contact.name}}</h4>
                        <h5 class="text-muted">{{contact.title}}</h5>
                        <div class="d-flex justify-content-center">
                            <a :href="'mailto:' + contact.email"><i @mouseover="hover1 = true" @mouseleave="hover1 = false" :class="{'cap-icon ci-envelope m-2': hover1 == false, 'cap-icon ci-envelope-out m-2': hover1 == true}"></i></a>
                            <a :href="'tel:'+ contact.phone"><i @mouseover="hover2 = true" @mouseleave="hover2 = false" :class="{'cap-icon ci-mobile m-2': hover2 == false, 'cap-icon ci-phone m-2': hover2 == true}"></i></a>
                            <a :href="'tel:'+ contact.whatsapp"><i @mouseover="hover3 = true" @mouseleave="hover3 = false" :class="{'cap-icon ci-whatsapp-squared m-2': hover3 == false, 'cap-icon ci-whatsapp-circled m-2': hover3 == true}"></i></a>
                            <a :href="'url:'+contact.facebook" target="_top"><i @mouseover="hover4 = true" @mouseleave="hover4 = false" :class="{'cap-icon ci-facebook-squared m-2': hover4 == false, 'cap-icon ci-facebook-circled m-2': hover4 == true}"></i></a>
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

        name: "Stuff",

        data() {
            return {
                hover1: false,
                hover2: false,
                hover3: false,
                hover4: false,
            }
        },

        computed: mapGetters(['allContacts']),

        methods: {
            ...mapActions(['fetchContactsF'])
        },

        created() {
            this.fetchContactsF();
        }
    }
</script>

<style scoped>
    a {
        color: ghostwhite;
        text-decoration: none;
        font-size: 1.5rem;
    }
</style>