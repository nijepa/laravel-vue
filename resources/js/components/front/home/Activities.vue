<template>
    <section id="home-heading" class="p-5">
        <div class="dark-overlay">
            <div data-aos="zoom-in">
                <div class="row align-items-center" id="abou">
                    <div class="col-md-4 text-center align-self-center">
                        <router-link to="/representations" activeClass="active" tag="li" class="nav-link" href="#" id="navbarDropdown" role="button">
                            <i class="cap-icon ci-compass activ" style="cursor: pointer"></i>
                            <h3 style="cursor: pointer">Zastupanja</h3>
                        </router-link>
                    </div>
                    <div class="col-md-4 text-center align-self-center" >
                        <router-link to="/exports" activeClass="active" tag="li" class="nav-link" href="#" id="navbarDropdow" role="button">
                            <i class="cap-icon ci-refresh mb-2 activ" style="cursor: pointer"></i>
                            <h3>Uvoz / Izvoz</h3>
                        </router-link>
                    </div>
                    <div class="col-md-4 text-center align-self-center">
                        <router-link to="/production" activeClass="active" tag="li" class="nav-link" href="#" id="navbarDropdow" role="button">
                            <i class="cap-icon ci-tools mb-2 activ" style="cursor: pointer"></i>
                            <h3>Proizvodnja</h3>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Activities"
    }
</script>

<style scoped>
    .activ {
        color: white;
        font-size: 80px;
    }
    .activ:hover {
        color:#05618d;
        font-size: 80px;
    }
    .col-md-4 {
        /*position: absolute;*/
        margin-top: 50px; /* account for padding and border if not using box-sizing: border-box; */
    }
</style>