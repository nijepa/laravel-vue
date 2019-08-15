<template>
    <div>
        <!-- NEWS -->
        <section id="news" class="my-5 text-center">
            <div data-aos="flip-down">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="info-header mb-5">
                                <h1 class="text-primary pb-3">
                                    Vesti
                                </h1>
                                <p class="lead">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias laborum numquam aperiam dolores a porro!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div :key="news.id" class="col-lg-12 col-md-12" v-for="news in allNews">
                            <div class="card">
                                <div @click="getNews(news)" class="card-body">
                                    <img :src="'../img/news/' + news.pic_id" alt="" class="img-fluid rounded-circle w-80 mb-3">
                                    <h3>{{news.title}}</h3>
                                    <h5 class="text-muted" v-html="news.body"></h5>
                                    <!--<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed commodi nostrum, ab libero voluptas officia.</p>-->
                                    <div class="d-flex justify-content-center">
                                        <!--                                        <a href="#" class="btn btn-primary btn-lg mt-3"><span>Više ... </span></a>-->
                                        <router-link to="/products" class="btn btn-primary btn-lg mt-3"><a><span>Više ... </span></a></router-link>
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

        name: "News",

        computed: mapGetters(['allNews', 'oneNews',]),

        methods: {
            ...mapActions(['fetchNews', 'fetchNewsD']),

            getNews(news) {
                const selNews = news;
                this.fetchNews(selNews);
            }
        },

        created() {
            this.fetchNews();
        }
    }
</script>

<style scoped>
    .container {
        position: relative;
        text-align: center;
        color: rgb(0, 1, 2);
    }
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .top-center {
        position: absolute;
        top: 8px;
        left: 40%;
    }
    @media(min-width: 768px) {
        .hoop {
            height: 500px;
        }
    }
</style>