<template>
    <div class="about">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appIntro title="O Nama" desc="wwwwwwwwwww"></appIntro>
        </transition>
        <transition appear name="slide" mode="out-in">
            <appInfo></appInfo>
        </transition>
        <transition appear name="sli" mode="out-in">
            <appQuotes></appQuotes>
        </transition>
        <appManagers></appManagers>
        <appFooter></appFooter>
    </div>
</template>

<script>
    import Header from '../../components/front/Header.vue';
    import Footer from '../../components/front/Footer.vue';
    import Intro from '../../components/front/Intro.vue';
    import Info from '../../components/front/about/Info.vue';
    import Quotes from '../../components/front/about/Quotes.vue';
    import Managers from '../../components/front/about/Managers.vue';

    export default {

        components: {
            appHeader: Header,
            appFooter: Footer,
            appIntro: Intro,
            appInfo: Info,
            appQuotes: Quotes,
            appManagers: Managers
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }
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