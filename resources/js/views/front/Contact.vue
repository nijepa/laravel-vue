<template>
    <div class="contact">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appIntro title="Kontakt" desc="stranih kompanija"></appIntro>
        </transition>
        <transition appear name="slide" mode="out-in">
            <appContact></appContact>
        </transition>
        <appMap></appMap>
        <appStuff></appStuff>
        <appFooter></appFooter>
    </div>
</template>

<script>
    import Header from '../../components/front/Header.vue';
    import Footer from '../../components/front/Footer.vue';
    import Intro from '../../components/front/Intro.vue';
    import Contact from '../../components/front/contact/Contact.vue';
    import Map from '../../components/front/contact/Map.vue';
    import Stuff from '../../components/front/contact/Stuff.vue';

    export default {

        components: {
            appHeader: Header,
            appFooter: Footer,
            appIntro: Intro,
            appStuff: Stuff,
            appContact: Contact,
            appMap: Map
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }
    }
</script>