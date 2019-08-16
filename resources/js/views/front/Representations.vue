<template>
    <div class="representations">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appIntro title="Zastupanja" desc="stranih kompanija"></appIntro>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appRepresentations></appRepresentations>
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
    import Representations from '../../components/front/representations/Companies.vue';

    export default {

        components: {
            appHeader: Header,
            appFooter: Footer,
            appRepresentations: Representations,
            appIntro: Intro
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }
    }
</script>