<template>
    <div class="container">
        <div class="row">
            <div class="col-4 my-5">
                <nav @click="getNews(news, news.id)" :key="news.id"
                     class="nav flex-column list-group" v-for="news in allNews">
                    <a :class="{ active : active_el === news.id }"  style="height:150px;"
                       class="nav-link list-group-item list-group-item-action list-group-item-primary list-font">{{news.title}}
                        <img :src="'../img/news/' + news.pic_id" class="img-fluid mx-auto d-block h-75">
                    </a>
                </nav>
            </div>

            <div class="col-8 my-5">
                <div class="card">
                <transition name="slide" mode="out-in" appear>
                    <div :key="oneNews.id" v-if="oneNews.id" class="card-body">
                        <!--                                <a :href="oneRep.website" target="_blank"><img :src="'../img/companies/' + oneRep.logo_id" class="img-fluid mx-auto d-block"></a>-->
                        <img :src="'../img/news/' + oneNews.pic_id" alt="" class="img-fluid w-250 my-3 mx-auto d-block">
                        <h3>{{ oneNews.title }}</h3>
                        <!--                                <h5 class="text-muted">{{oneRep.short_desc}}</h5>-->
                        <p class="my-3" v-html="oneNews.body"></p>

                        <div v-if="allNewsDet.length">
                            <div id="gallery" >
                                <ul >
                                    <li :id="newsDet.id" :key="newsDet.id" v-for="newsDet in allNewsDet">
                                        <div class="mosaicItem">
                                            <a :href="'#p'+newsDet.id">
                                                <img class="img-fluid w-200 d-block" :src="'../img/news/' + newsDet.photo_id" alt="" />
                                                <div class="text">{{ newsDet.description }}</div>
                                            </a>
                                        </div>
                                        <div class="popin" :id="'p'+newsDet.id">
                                            <a :href="'#'+newsDet.id">
                                                <div class="overlay"></div>
                                                <div class="imgBox"><img :src="'../img/news/' + newsDet.photo_id" alt="" /></div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div key=2 v-else class="card-body">
                        <i class="cap-icon ci-picture mb-2 activ mx-auto" style="cursor: pointer; font-size: 80px"></i>
                        <!--<img src="img/person3.jpg" alt="" class="img-fluid rounded-circle w-50 mb-3">-->
                        <h3 class="mt-3 mb-3">Vesti</h3>
                        <!--<h5 class="text-muted">CEO</h5>-->
                        <p>Vesti i aktivnosti</p>
                        <p>Molimo Vas da nam se obratite ako imate bilo kakvo pitanje vezano za navedene proizvode.</p>
                    </div>
                </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {

        name: "News",

        data() {
            return {
                classe: '',
                active_el: 0,
                isActive: false,
            }
        },

        computed:
            mapGetters([
                'allNews',
                'oneNews',
                'allNewsDet'
            ]),

        methods: {
            ...mapActions([
                'fetchNewsB',
                'fetchNewsD',
                'resetNewsState',
                'fetchNewsDet'
            ]),

            moveTo () {
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            },

            getNews(news, id) {
                const selNews = news;
                const selNewsID = id;
                this.fetchNewsD(selNewsID);
                this.fetchNewsDet(selNewsID);
                this.classe = 'active';
                this.activate(selNewsID);
            },

            activate:function(el){
                this.active_el = el;
            }
        },

        created() {
            this.fetchNewsB();
        },

        destroyed:function(){
            this.resetNewsState();
        }
    }
</script>

<style lang="scss" scoped>
    .nav-link {
        background-color: white;
    }

    a {
        cursor: pointer;
        text-decoration: none;
    }

    .list-font {
        font-size: 20px;
    }

    @media (max-width: 858px) {
        .list-font {
            font-size: 14px;
        }
    }

    @media (max-width: 780px) {
        .list-font {
            font-size: 13px;
        }
    }

    @media (max-width: 702px) {
        .list-font {
            font-size: 12px;
        }
    }

    @media (max-width: 724px) {
        .list-font {
            font-size: 11px;
        }
    }

    @media (max-width: 623px) {
        .list-font {
            font-size: 10px;
        }
    }

    #gallery {

        ul {
            list-style-type: none;
            li {
                display: inline-block;
                position: relative;
                overflow: hidden;
                .mosaicItem {
                    width: 200px;
                    height: 200px;

                    & > a {
                        .text {
                            position: absolute;
                            bottom: -50px;
                            left: 0;
                            width: 100%;
                            height: 50px;
                            background: rgba(0,0,0,0.8);
                            color: white;
                            font-family: 'Open Sans', sans-serif;
                            text-align: center;
                            font-weight: 600;
                            line-height: 50px;
                            transition: all .5s ease-in-out;
                            opacity: 0;
                        }

                        &:hover .text{
                            bottom: 0;
                            opacity: 1;
                        }
                    }
                }

                .popin {
                    display: flex;
                    text-align: center;
                    position: fixed;
                    top: -100%;
                    transition: 2s all ease ;
                    opacity: 0;
                    width: 100%;
                    height: 100%;
                    left: 0;
                    justify-content: center;
                    align-items: center;
                    z-index: 999;
                    &:target {
                        top: 0;
                        opacity: 1;

                        .imgBox {
                            position: relative;
                            z-index: 998;

                            &:before {
                                content: '✖';
                                position: absolute;
                                right: 10px;
                                top: 10px;
                                color: white;
                                z-index: 999;
                            }

                            img {
                                border: 3px solid white;
                            }
                        }
                    }

                    .overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        background: rgba(0,0,0,0.7);
                        width: 100%;
                        height: 100%;
                        z-index: 899;
                    }
                }
            }
        }
    }
</style>
