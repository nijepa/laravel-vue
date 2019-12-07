<template>
    <div class="col-lg-3 col-6" data-aos="flip-up">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner" v-if="isLoadingP"><CircleLoader :color="`#bbeeff`" /></div>
            <div class="inner" v-if="!isLoadingP">
                <h3>{{ projects.projects.length }}</h3>
                <p>Total Projects</p>
                <h3>{{ projects.aProjects }} - {{ parseInt(projects.aProjects/this.allProjects.length*100) }}<sup style="font-size: 20px">%</sup></h3>
                <h5>Active projects</h5>
            </div>
            <div class="icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <router-link to="/projects" class="small-box-footer" tag="a">
                More info <i class="fas fa-arrow-circle-right"></i>
            </router-link>
            <!--                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import { CircleLoader } from '@saeris/vue-spinners';

    export default {
        name: "Stats",

        components: {
            CircleLoader
        },

        data() {
            return {
                projects: [],
                activeProjects: [],
                isLoadingP: true,
            }
        },

        computed: {
            ...mapGetters(['allProjects', 'allUsers']),
        },

        methods: {
            ...mapActions([
                'fetchProjects',
                'fetchActiveProjects'
            ]),

            loadData() {
                if(this.$gate.isAdmin()) {
                    this.fetchProjects();
                    this.projects = this.$store.state.projects;
                    this.fetchActiveProjects();
                    this.activeProjects = this.$store.state.aProjects;
                    this.isLoadingP = false;
                }
            },
        },

        created() {
            this.loadData();
        }
    }
</script>

<style scoped>

</style>
