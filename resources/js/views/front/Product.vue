<template>
    <div class="products">
        <transition appear name="sli" mode="out-in">
            <appHeader></appHeader>
        </transition>
        <transition appear name="slid" mode="out-in">
            <appProducts></appProducts>
        </transition>
        <transition appear name="slide" mode="out-in">
            <appFooter></appFooter>
        </transition>
    </div>
</template>

<script>
    import Header from '../../components/front/Header.vue';
    import Footer from '../../components/front/Footer.vue';
    import Products from '../../components/front/products/Products.vue';

    export default {

        name: "Product",

        components: {
            appHeader: Header,
            appFooter: Footer,
            appProducts: Products,
        },

        created() {
            //Scrolls to top when view is displayed
            window.scrollTo(0, 0);
        }

    }
</script>

<style scoped>

</style>