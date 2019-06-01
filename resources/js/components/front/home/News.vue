<template>
    <section id="news">>
        <div class="info-header mb-5">
            <h1 class="text-center text-primary pb-3">
                Vesti
            </h1>
            <p class="lead pb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus obcaecati alias rerum dolore fugiat debitis?</p>
        </div>
<!--        <hooper :itemsToShow="1" :centerMode="true" :infiniteScroll="true" :autoPlay="true" :playSpeed="5000" class="hoop">
            <slide :key="news.id" v-for="news in allNews">
                <div class="container">
                    <img :src="'../img/news/' + news.pic_id" style="opacity:0.8;background:rgba(0,0,0,0.6);">
                    <h4 class="top-center ">{{news.title}}</h4>
                    <p class="centered lead ">{{news.body}}</p>
                </div>
            </slide>
            <hooper-navigation class="text-primary" slot="hooper-addons"></hooper-navigation>
            <hooper-pagination slot="hooper-addons"></hooper-pagination>
            <hooper-progress slot="hooper-addons"></hooper-progress>
        </hooper>-->
    </section>
</template>

<script>
    //import { Hooper, Slide, Progress as HooperProgress, Pagination as HooperPagination, Navigation as HooperNavigation } from 'hooper'
    //import 'hooper/dist/hooper.css'
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: 'News',
/*        components: {
            Hooper,
            Slide,
            HooperProgress,
            HooperPagination,
            HooperNavigation
        },*/
        computed: mapGetters(['allNews']),
        methods: {
            ...mapActions(['fetchNews'])
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