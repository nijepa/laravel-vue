<template>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <Stats />
                <StatsMeetings />
                <div class="col-lg-6 col-6">
                    <Chart style="height: 240px;" data-aos="flip-up"></Chart>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <Todo ></Todo>
                <Chat :user="user" data-aos="zoom-in-left"></Chat>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import Todo from './app/Todo';
    import Chat from './app/Chat';
    import Chart from './app/Chart';
    import Stats from './app/Stats';
    import StatsMeetings from './app/StatsMeetings';
    import { CircleLoader } from '@saeris/vue-spinners';

    export default {
        name: "Dashboard",

        components: {
            Todo, Chat, Chart, Stats, StatsMeetings, CircleLoader
        },

        data() {
            return {
                user: {}
            }
        },

        mounted() {
            this.user = window.user.user;
        },

        computed: {
            // ...mapGetters(['allProjects', 'allMeetings', 'allUsers']),

  /*          filteredMeetings() {
                let res = this.meetings.meetings;

                this.activeMeetings = res.filter(item => {
                    return item.finished === 0
                });

                this.isLoadingM = false;
            },

            filteredProjects() {
                let result = this.projects.projects;

                this.activeProjects = result.filter(item => {
                    return item.finished === 0
                });

                this.isLoadingP = false;
            }*/

        },

        methods: {
            ...mapActions([
               /* 'fetchProjects',
                'fetchMeetings',*/
               // 'fetchUsers'
            ]),

            /*loadData() {
                if(this.$gate.isAdmin()) {
                    this.fetchProjects();
                    this.projects = this.$store.state.projects;
                    this.fetchMeetings();
                    this.meetings = this.$store.state.meetings;
                 /!*   this.fetchUsers();
                    this.users = this.$store.state.users;*!/
                }
            },*/
        },

        created() {
            // this.loadData();
        }
    }
</script>

<style scoped>

</style>
