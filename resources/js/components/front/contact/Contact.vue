<template>
    <div>
        <section id="contact" class="py-3">
            <div class="container">
                <div class="row">

                    <div class="col-md-4">
                        <div data-aos="fade-down-right">
                            <div class="card p-4">
                                <div class="card-body" :key="owner.id" v-for="owner in allOwner">
                                    <h4>Kontaktirajte nas</h4>
                                    <p>Lorem ipsum, dolor sit. Suscipit ad laboriosam eligendi mollitia magni explicabo?</p>
                                    <h4>Adresa</h4>
                                    <p>{{owner.address}}</p>
                                    <h4>Email</h4>
                                    <p>{{owner.email}}</p>
                                    <h4>Telefon</h4>
                                    <p>{{owner.phone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div data-aos="fade-down-left">
                            <div class="card p-4">
                                <div class="card-body">
                                    <h3 class="text-center">Please fill out this form to contact us</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Ime">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Prezime">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Telefon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" placeholder="Poruka"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="Potvrdite" class="btn btn-primary btn-block">
                                            </div>
                                        </div>
                                    </div>
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

        name: "Contact",

        computed: mapGetters(['allOwner']),

        methods: {
            ...mapActions(['fetchOwner'])
        },

        created() {
            this.fetchOwner();
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