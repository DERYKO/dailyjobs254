<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><img src="https://cf.ltkcdn.net/jobs/images/std/145021-425x251-find_jobs_on_career_builder.JPG" width="100px" height="auto"/></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                </ul>
                <form class="form-inline my-2 my-lg-0 pull-right">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    <div class="text-xs-center">
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn
                                        color="primary"
                                        dark
                                        v-on="on"
                                >
                                    Dashboard
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-tile
                                >
                                    <v-list-tile-title>
                                        <form @submit.prevent="logout">
                                            <button type="submit" class="btn btn-default">Logout</button>
                                        </form>
                                    </v-list-tile-title>
                                </v-list-tile>
                            </v-list>
                        </v-menu>
                    </div>
                </form>
            </div>
        </nav>
        <div class="col-md-3">
            <v-card height="350px">
                <v-navigation-drawer
                        v-model="drawer"
                        class="blue lighten-4"
                        permanent
                        absolute
                >
                    <v-toolbar flat class="transparent">
                        <v-list class="pa-0">
                            <v-list-tile avatar>
                                <v-list-tile-avatar>
                                    <img src="https://cf.ltkcdn.net/jobs/images/std/145021-425x251-find_jobs_on_career_builder.JPG">
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Jobs Around You</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-toolbar>

                    <v-list class="pt-0" dense>
                        <v-divider></v-divider>

                        <v-list-tile
                                v-for="item in items"
                                :key="item.title"
                        >
                            <v-list-tile-action>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title><router-link tag="li" :to="item.route"><a class="v-list__tile--link">{{item.title}}</a></router-link></v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-navigation-drawer>
            </v-card>
        </div>
        <div class="col-md-9">
            <router-view ></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                drawer: null,
                items: [{title: 'Profile', route: "/profile", icon: "far fa-user-circle"},{title: 'Jobs', route: "/view-jobs" ,icon: "fas fa-binoculars"},{title: 'Post Job',route: "/post-job", icon: "fas fa-user-md"},{title: 'Account', route: "/account", icon: "fas fa-user-cog"},{title: 'Wallet', route: "/wallet", icon: "fas fa-wallet"}]
            }
        },
        methods: {
            logout: function () {
                axios.post('logout').then((res)=>{
                    this.$router.push('/login');
                }).catch((error)=>{
                     console.log(error)
                });
            }
        }

    }

</script>