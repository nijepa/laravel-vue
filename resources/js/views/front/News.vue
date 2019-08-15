<template>
    <div class="products">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appNews></appNews>
        </transition>
        <transition appear name="slide" mode="out-in">
            <appFooter></appFooter>
        </transition>
    </div>
</template>

<script>
    import Header from '../../components/front/Header.vue';
    import Footer from '../../components/front/Footer.vue';
    import News from '../../components/front/news/News.vue';

    export default {
        name: "News",

        components: {
            appHeader: Header,
            appFooter: Footer,
            appNews: News,
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }
    }
</script>

<style scoped>

</style>