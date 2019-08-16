<template>
    <nav class="navbar navbar-expand-md navbar-light fixed-top py-4" id="main-nav">
        <div class="container">
            <router-link to="/" activeClass="active"  >
                <a class="navbar-brand">
                    <img src="img/donau.jpg" width="50" height="50" alt="">
                    <h3 class="d-inline align-middle ml-2">DONAU TRADE</h3>
                </a>
            </router-link>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <router-link to="/" activeClass="active" tag="li" class="nav-item nav-link"><i class='cap-icon ci-home'></i></router-link>
                    <router-link to="/about" activeClass="active" tag="li" class="nav-item nav-link">O Nama</router-link>
                    <router-link to="/representations" activeClass="active" tag="li" class="nav-item nav-link">Zastupanja</router-link>
                    <router-link to="/news" activeClass="active" tag="li" class="nav-item nav-link">Vesti</router-link>
                    <router-link to="/products" activeClass="active" tag="li" class="nav-item nav-link">Proizvodi</router-link>
                    <router-link to="/contact" activeClass="active" tag="li" class="nav-item nav-link">Kontakt</router-link>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: 'Header'
    }
</script>

<style scoped>
    a {
        text-decoration: none;
    }

    .nav-item {
        cursor: pointer;
    }
</style>