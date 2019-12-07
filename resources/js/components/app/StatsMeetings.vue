<template>
    <div class="col-lg-3 col-6" data-aos="flip-down">
        <!-- small box -->
        <div class="small-box bg-cyan">
            <div v-if="isLoadingM" class="inner"><CircleLoader :color="`#bbeeff`" /></div>
            <div v-if="!isLoadingM" class="inner">
                <h3>{{ meetings.meetings.length }}</h3>
                <p>Total meetings</p>
                <h3>{{ meetings.aMeetings }} - {{ parseInt(meetings.aMeetings/this.allMeetings.length*100) }}<sup style="font-size: 20px">%</sup></h3>
                <h5>Active meetings</h5>
            </div>
            <div class="icon">
                <i class="fa fa-handshake"></i>
            </div>
            <router-link to="/meetings" class="small-box-footer" tag="a">
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
                meetings: [],
                activeMeetings: [],
                isLoadingM: true
            }
        },

        computed: {
            ...mapGetters(['allMeetings', 'allUsers']),
        },

        methods: {
            ...mapActions([
                'fetchMeetings',
                'fetchActiveMeetings'
            ]),

            loadData() {
                if(this.$gate.isAdmin()) {
                    this.fetchMeetings();
                    this.meetings = this.$store.state.meetings;
                    this.fetchActiveMeetings();
                    this.activeMeetings = this.$store.state.aMeetings;
                    this.isLoadingM = false;
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
