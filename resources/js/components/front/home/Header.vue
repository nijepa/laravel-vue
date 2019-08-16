<template>
    <nav class="navbar navbar-expand-md navbar-light fixed-top py-4" id="main-nav">
        <div class="container">
            <a href="#home" class="navbar-brand">
                <img src="img/donau.jpg" width="50" height="50" alt="">
                <h3 class="d-inline align-middle ml-2">DONAU TRADE</h3>
            </a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#home" v-smooth-scroll class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" v-smooth-scroll class="nav-link">O nama</a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/representations" class="nav-link"><a>Zastupanja</a></router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#news" v-smooth-scroll class="nav-link">Vesti</a>
                    </li>
                    <li class="nav-item">
                        <a href="#authors" v-smooth-scroll class="nav-link">Proizvodi</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" v-smooth-scroll class="nav-link">Kontakt</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Header"
    }
</script>