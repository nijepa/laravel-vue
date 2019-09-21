<template>
    <div class="container" data-aos="fade-right">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background: url('./img/user-profile-bg.jpg') center center;">
                        <h3 class="widget-user-username">{{ form.name }}</h3>
                        <h5 class="widget-user-desc">{{ form.type }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">User Activity</h3>

                                <div class="timeline"  v-for="day in days" >
                                    <div class="timeline-month">
                                        {{ day.created_at | dayMonthYear}}
                                        <span>3 Entries</span>
                                    </div>
                                    <div class="timeline-section" v-for="(activity, i) in day.activities" :key="i">
                                        <div class="timeline-date">
                                            {{ activity.created_at | customTime }}
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="timeline-box" >
                                                    <div class="box-title">
                                                        <i :class="subjectType(activity.subject_type.substring(4))"  aria-hidden="true"></i>
                                                        {{ activity.subject_type.substring(4) }} - {{ activity.description }} <i :class="descType(activity.description)"  aria-hidden="true"></i>
                                                    </div>
                                                    <div class="box-content d-flex align-items-center">
                                                        <div class="box-item mr-5"><strong>{{ activity.subject_type.substring(4) }}</strong>:
<!--                                                            {{ subjectType(activity.subject_type.substring(4)) }}-->
                                                            {{ activity.subject_type.substring(4) === 'User' ?
                                                                activity.subject.name :
                                                                activity.subject_type.substring(4) === 'Project' ?
                                                                activity.subject.title :
                                                                activity.subject_type.substring(4) === 'Meeting' ?
                                                                activity.subject.title :
                                                                activity.subject.caption }}
                                                        </div>
                                                        <a class="btn btn-xs btn-primary mr-auto">Details</a>

                                                        <!--<div class="box-item"><strong>Loss Territory</strong>: {{ activity.description }}</div>
                                                        <div class="box-item"><strong>Time</strong>:  {{ activity.created_at | customTime }}</div>-->
                                                    </div>
                                                    <div class="box-footer">- {{ activity.causer.name }}</div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                               <!-- <div class="timeline" v-for="(activity, i) in activities" :key="i">
                                    &lt;!&ndash; timeline time label &ndash;&gt;
                                    <div class="time-label">
                                        <span class="bg-danger">
                                          {{ activity.created_at | customDate }}
                                        </span>
                                    </div>
                                    &lt;!&ndash; /.timeline-label &ndash;&gt;
                                    &lt;!&ndash; timeline item &ndash;&gt;
                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> {{ activity.created_at | customTime }}</span>

                                            <h3 class="timeline-header"><a href="#">{{ activity.subject_type.substring(4) }}</a> - {{ activity.description }}</h3>

                                            <div class="timeline-body">
                                                {{activity.properties.attributes.name}} {{activity.subject.name}}
                                            </div>
                                        </div>
                                    </div>
                                    &lt;!&ndash; END timeline item &ndash;&gt;
                                </div>-->
                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-12">
                                            <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
                                        <div class="col-sm-12">
                                            <textarea  v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                            <has-error :form="form" field="bio"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                        <div class="col-sm-12">
                                            <input type="file" @change="updatePhoto" name="photo" class="form-input">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>
                                        <div class="col-sm-12">
                                            <input type="password"
                                                   v-model="form.password"
                                                   class="form-control"
                                                   id="password"
                                                   placeholder="Passport"
                                                   :class="{ 'is-invalid': form.errors.has('password') }"
                                            >
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update <span><i class="fas fa-save"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        data() {
            return {
                user: '',
                type: '',
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),
                activities: []
            }
        },
        methods: {
            getProfilePhoto() {
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },

            updatePhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            },

            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        toast.fire({
                            type: 'success',
                            title: 'Profile updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },

            subjectType(subject) {
                switch (subject) {
                    case 'User':
                        return 'fas fa-user';
                    case 'Project':
                        return 'fas fa-project-diagram ';
                    case 'ProjectDet':
                        return 'fas fa-tasks ';
                    case 'Meeting':
                        return 'fas fa-handshake ';
                    case 'MeetingDet':
                        return 'fas fa-handshake ';
                }
            },

            descType(subject) {
                switch (subject) {
                    case 'created':
                        return 'fas fa-plus';
                    case 'updated':
                        return 'fas fa-edit ';
                    case 'deleted':
                        return 'fas fa-minus ';
                }
            },

            sortDays() {

            }
        },

        computed: {
            days () {
                const map = {};

                for (const activity of this.activities) {
                    const day = activity.created_at.slice(0, 10);

                    map[day] = map[day] || { created_at: day, activities: [] };
                    map[day].activities.push(activity)
                }

                let result = Object.keys(map).sort().map(day => map[day]);

                return  _.orderBy(result,'created_at', 'desc');
            },

        },

        created() {
            this.type = this.$gate.authType();
            this.user = this.$gate.authUser();

            axios.get("api/profile")
                .then(({ data }) => (this.form.fill(data)))
                .catch();

            axios.get("api/activities")
                .then(({data}) => (this.activities = data))
                .catch();
        }
    }
</script>

<style scoped>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 250px !important;
    }
    .widget-user .card-footer{
        padding: 0;
    }

    .timeline{
        margin-top:20px;
        position:relative;

    }

    .timeline:before{
        position:absolute;
        content:'';
        width:4px;
        height:calc(100% + 50px);
        background: rgb(138,145,150);
        background: -moz-linear-gradient(left, rgba(138,145,150,1) 0%, rgba(122,130,136,1) 60%, rgba(98,105,109,1) 100%);
        background: -webkit-linear-gradient(left, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(98,105,109,1) 100%);
        background: linear-gradient(to right, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(98,105,109,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8a9196', endColorstr='#62696d',GradientType=1 );
        left:14px;
        top:5px;
        border-radius:4px;
    }

    .timeline-month{
        position:relative;
        padding:4px 15px 4px 35px;
        background-color: #04d4ff;
        display:inline-block;
        width:auto;
        border-radius:40px;
        border:1px solid #17191B;
        border-right-color:black;
        margin-bottom:30px;
    }

    .timeline-month span{
        position:absolute;
        top:-1px;
        left:calc(100% - 10px);
        z-index:-1;
        white-space:nowrap;
        display:inline-block;
        background-color:#111;
        padding:4px 10px 4px 20px;
        border-top-right-radius:40px;
        border-bottom-right-radius:40px;
        border:1px solid black;
        box-sizing:border-box;
    }

    .timeline-month:before{
        position:absolute;
        content:'';
        width:20px;
        height:20px;
        background: rgb(138,145,150);
        background: -moz-linear-gradient(top, rgba(138,145,150,1) 0%, rgba(122,130,136,1) 60%, rgba(112,120,125,1) 100%);
        background: -webkit-linear-gradient(top, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
        background: linear-gradient(to bottom, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8a9196', endColorstr='#70787d',GradientType=0 );
        border-radius:100%;
        border:1px solid #17191B;
        left:5px;
    }

    .timeline-section{
        padding-left:35px;
        display:block;
        position:relative;
        margin-bottom:30px;
    }

    .timeline-date{
        margin-bottom:15px;
        padding:2px 15px;
        background:linear-gradient(#74cae3, #5bc0de 60%, #4ab9db);
        position:relative;
        display:inline-block;
        border-radius:20px;
        border:1px solid #17191B;
        color:#fff;
        text-shadow:1px 1px 1px rgba(0,0,0,0.3);
    }
    .timeline-section:before{
        content:'';
        position:absolute;
        width:30px;
        height:1px;
        background-color:#444950;
        top:12px;
        left:20px;
    }

    .timeline-section:after{
        content:'';
        position:absolute;
        width:10px;
        height:10px;
        background:linear-gradient(to bottom, rgba(138,145,150,1) 0%,rgba(122,130,136,1) 60%,rgba(112,120,125,1) 100%);
        top:7px;
        left:11px;
        border:1px solid #17191B;
        border-radius:100%;
    }

    .timeline-section .col-sm-4{
        margin-bottom:15px;
    }

    .timeline-box{
        position:relative;

        background-color: #a7daeb;
        border-radius:15px;
        border-top-left-radius:0px;
        border-bottom-right-radius:0px;
        border:1px solid #17191B;
        transition:all 0.3s ease;
        overflow:hidden;
    }

    .box-icon{
        position:absolute;
        right:5px;
        top:0px;
    }

    .box-title{
        padding:5px 15px;
        border-bottom: 1px solid #17191B;
    }

    .box-title i{
        margin-right:5px;
    }

    .box-content{
        padding:5px 15px;
        background-color: #dbffff;
    }

    .box-content strong{
        color:#666;
        font-style:italic;
        margin-right:5px;
    }

    .box-item{
        margin-bottom:5px;
    }

    .box-footer{
        padding:5px 15px;
        border-top: 1px solid #17191B;
        background-color: #a7daeb;
        text-align:right;
        font-style:italic;
    }



</style>