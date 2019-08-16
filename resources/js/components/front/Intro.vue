<template>
    <header id="page-header" class="">
        <div class="container">
            <div class="row">
                <div class="col m-auto text-center has-overlay">
                    <h1>{{title}}</h1>
                    <p>{{desc}}</p>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: "Intro",

        props: ['title', 'desc']
    }
</script>

<style scoped>

</style>