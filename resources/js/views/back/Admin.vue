<template>

<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <div class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <!--<input v-model="search" @keyup="searchIt" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" @click="searchIt">
                        <i class="fa fa-search"></i>
                    </button>
                </div>-->
            </div>
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="cap-icon ci-comment-dots siz"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown" @click="markAsRead">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="cap-icon ci-notification-alt siz"></i>
                    <span class="badge badge-warning navbar-badge">{{ unreadNotifications.length }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ unreadNotifications.length }}</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" v-for="notification in createdProjectNotifications" :key="notification.id">
                        <i class="fa fa-project-diagram mr-2"></i> {{ notification.data.createdProject.title }} - project created
                        <span class="float-right text-muted text-sm">on {{ notification.created_at }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" v-for="notification in createdUserNotifications" :key="notification.id">
                        <i class="fa fa-user-plus mr-2"></i> {{ notification.data.createdUser.name }} - user registered
                        <span class="float-right text-muted text-sm">on {{notification.created_at }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" v-for="notification in createdProjectDetailNotifications" :key="notification.id">
                        <i class="fa fa-tasks mr-2"></i> {{ notification.data.createdProjectDetail.caption }} - project task created
                        <span class="float-right text-muted text-sm">on {{ notification.created_at }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                            class="fa fa-th-large"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">DONAU</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="'/img/profile/'+user.photo" class="img-circle elevation-2" alt="User Image">
<!--                    <img src="/img/profile/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">-->
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        {{ user.name }}
                        <p>{{ user.type }}</p>
<!--                        {{ Auth::user()->name }}-->
<!--                        <p>{{ Auth::user()->type }}</p>-->
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt text-purple"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-header">MANAGE</li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog text-yell"></i>
                            <p>
                                Users
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!--                            @can('isAdmin')-->
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="fa fa-users nav-icon text-orange"></i>
                                    <p>Users</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/roles" class="nav-link">
                                    <i class="fa fa-user-tag nav-icon text-yellow"></i>
                                    <p>Roles</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/permissions" class="nav-link">
                                    <i class="fa fa-user-lock nav-icon text-yellow"></i>
                                    <p>Permissions</p>
                                </router-link>
                            </li>
                            <!--                            @endcan-->
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-list-ol text-green"></i>
                            <p>
                                Lists
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
<!--                            @can('isAdmin')-->
                       <!--     <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="fa fa-users nav-icon text-orange"></i>
                                    <p>Users</p>
                                </router-link>
                            </li>-->
                            <li class="nav-item">
                                <router-link to="/companies" class="nav-link">
                                    <i class="fa fa-building nav-icon text-teal"></i>
                                    <p>Companies</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/cities" class="nav-link">
                                    <i class="fa fa-city nav-icon text-teal"></i>
                                    <p>Cities</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/countries" class="nav-link">
                                    <i class="fa fa-globe-europe nav-icon text-teal"></i>
                                    <p>Countries</p>
                                </router-link>
                            </li>
<!--                            @endcan-->
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-t <i fas fa-atlas text-pink"></i>
                            <p>
                                Front
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
<!--                            @can('isAdmin')-->
                                <li class="nav-item">
                                    <router-link to="/abouts" class="nav-link">
                                        <i class="fas fa-certificate nav-icon text-purp"></i>
                                        <p>About</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/reps" class="nav-link">
                                        <i class="fas fa-flag nav-icon text-purp"></i>
                                        <p>Representations</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/products" class="nav-link">
                                        <i class="fas fa-boxes nav-icon text-purp"></i>
                                        <p>Products</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/contacts" class="nav-link">
                                        <i class="far fa-address-book nav-icon text-purp"></i>
                                        <p>Contacts</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/newsb" class="nav-link">
                                        <i class="far fa-newspaper nav-icon text-purp"></i>
                                        <p>News</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/export" class="nav-link">
                                        <i class="fas fa-sync-alt nav-icon text-purp"></i>
                                        <p>Export</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/production" class="nav-link">
                                        <i class="fas fa-tools nav-icon text-purp"></i>
                                        <p>Production</p>
                                    </router-link>
                                </li>
<!--                            @endcan-->
                        </ul>
                    </li>

                    <li class="nav-header">APPLICATION</li>
                    <!--<li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram text-blue"></i>
                            <p>
                                Projects
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
&lt;!&ndash;                            @can('isAdmin')&ndash;&gt;-->
                                <li class="nav-item">
                                    <router-link to="/projects" class="nav-link">
                                        <i class="fas fa-project-diagram nav-icon text-blue"></i>
                                        <p>Projects</p>
                                    </router-link>
                                </li>
        <!--                        <li class="nav-item">
                                    <router-link to="/representations" class="nav-link">
                                        <i class="fas fa-hands-helping nav-icon text-cyan"></i>
                                        <p>Add</p>
                                    </router-link>
                                </li>
&lt;!&ndash;                            @endcan&ndash;&gt;
                        </ul>
                    </li>-->

                    <li class="nav-item">
                        <router-link to="/meetings" class="nav-link">
                            <i class="nav-icon fas fa-handshake text-cyan"></i>
                            <p>Meetings</p>
                        </router-link>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-file-alt text-purpl"></i>
                            <p>
                                Reports
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!--                            @can('isAdmin')-->
                            <li class="nav-item">
                                <router-link to="/projects" class="nav-link">
                                    <i class="fas fa-certificate nav-icon text-purpli"></i>
                                    <p>Activities</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/representations" class="nav-link">
                                    <i class="fas fa-hands-helping nav-icon text-purpli"></i>
                                    <p>Notifications</p>
                                </router-link>
                            </li>
                            <!--                            @endcan-->
                        </ul>
                    </li>

                    <li class="nav-header">PERSONAL</li>

                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fas fa-user text-orange"></i>
                            <p>Profile</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" @click="logout" >
                            <i class="nav-icon fas fa-sign-out-alt text-red ilink"></i>
                            <p class="plink">
                                Logout
                            </p>
                        </a>


                        <!--<a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt text-red"></i>
                            <p>
                                {{ __('Logout') }}
                            </p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>-->
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019 <a href="https://adminlte.io">DONAU - Belgrade</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->


</template>

<script>
    export default {
        name: "Admin",

        props: ["user"],

        data() {
            return {
                allNotifications: [],
                unreadNotifications: [],
                createdUserNotifications: [],
                createdProjectNotifications: [],
                createdProjectDetailNotifications: [],
            }
        },

        watch:{
            allNotifications(val){
                this.unreadNotifications =  this.allNotifications.filter(notification => {
                    return notification.read_at == null;
                });
            }
        },
        methods: {
            logout() {
                axios.post("/logout").then(response => window.location.reload());
            },

            markAsRead() {
                axios.get("api/mark-all-read/" + this.user.id).then(response=>{
                    this.unreadNotifications = [];
                });
            },

            filterNotifications() {
                this.createdUserNotifications = this.unreadNotifications.filter(notification => {
                    return notification.type == `App\\Notifications\\UserRegistered`;
                });
                this.createdProjectNotifications = this.unreadNotifications.filter(notification => {
                    return notification.type == `App\\Notifications\\ProjectCreated`;
                });
                this.createdProjectDetailNotifications = this.unreadNotifications.filter(notification => {
                    return notification.type == `App\\Notifications\\ProjectDetailCreated`;
                });
            }
        },

        created() {
            this.allNotifications = this.user.notifications;
            this.unreadNotifications =  this.allNotifications.filter(notification => {
                return notification.read_at == null;
            });
            this.filterNotifications();

         /*   Echo.join(`chat`)
                .here((users) => {
                    //
                })
                .joining((user) => {
                    console.log(user.name);
                })
                .leaving((user) => {
                    console.log(user.name);
                });*/
            Echo.private("App.User." + this.user.id).notification(notification => {
                console.log(this.user);
                this.allNotifications.unshift(notification.notification);

            });
        }
    }
</script>

<style scoped>
    .plink {
        color: white;
        cursor: pointer;
    }
    .ilink {
        cursor: pointer;
    }
    .siz {
        font-size: 35px;
        color: #1b4b72;
    }
    .badge {
        font-size: 15px;
    }
</style>