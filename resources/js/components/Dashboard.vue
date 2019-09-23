<template>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{ projects.projects.length }}</h3>
                            <p>Total Projects</p>
                            <h3>{{ filteredProjects.length }} - {{ parseInt(filteredProjects.length/projects.projects.length*100) }}<sup style="font-size: 20px">%</sup></h3>
                            <h5>Active projects</h5>

                        </div>
                        <div class="icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-cyan">
                        <div class="inner">
                            <h3>{{ meetings.meetings.length }}</h3>
                            <p>Total meetings</p>
                            <h3>{{ filteredMeetings.length }} - {{ parseInt(filteredMeetings.length/meetings.meetings.length*100) }}<sup style="font-size: 20px">%</sup></h3>
                            <h5>Active meetings</h5>
                        </div>
                        <div class="icon">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ meetings.meetings.length }}</h3>

                            <p>TO DO</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>E-mails</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        
        </div><!-- /.container-fluid -->
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "Dashboard",

        data() {
            return {
                projects: [],
                meetings: [],
                users: [],
            }
        },

        computed: {
            ...mapGetters(['allProjects', 'allMeetings', 'allUsers']),

            filteredProjects() {
                let result = this.projects.projects;

                return result.filter(item => {
                    return item.finished === 0
                });
            },

            filteredMeetings() {
                let result = this.meetings.meetings;

                return result.filter(item => {
                    return item.finished === 0
                });
            }
        },
        methods: {
            ...mapActions([
                'fetchProjects',
                'fetchMeetings',
                'fetchUsers'
            ]),

            loadData() {
                if(this.$gate.isAdmin()) {
                    this.fetchProjects();
                    this.projects = this.$store.state.projects;
                    this.fetchMeetings();
                    this.meetings = this.$store.state.meetings;
                    this.fetchUsers();
                    this.users = this.$store.state.users;
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