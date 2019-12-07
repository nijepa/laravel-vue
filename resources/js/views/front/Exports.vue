<template>
    <div class="production">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appIntro title="Uvoz / Izvoz" desc="širom Evrope"></appIntro>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appExports></appExports>
        </transition>
        <transition appear name="slide" mode="out-in">
            <appFooter></appFooter>
        </transition>
    </div>
</template>

<script>
    import Header from '../../components/front/Header.vue';
    import Footer from '../../components/front/Footer.vue';
    import Intro from '../../components/front/Intro.vue';
    import Exports from '../../components/front/exports/Exports.vue';

    export default {

        name: "Product",

        components: {
            appHeader: Header,
            appFooter: Footer,
            appIntro: Intro,
            appExports: Exports,
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }

    }
</script>

<style scoped>

</style>
