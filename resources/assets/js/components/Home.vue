<template>
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><i class="fas fa-igloo fa-lg"> Home</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                </ul>
                <form class="form-inline my-2 my-lg-0 pull-right">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
                                    <img src="https://randomuser.me/api/portraits/men/85.jpg">
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>John Leider</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-toolbar>

                    <v-list class="pt-0" dense>
                        <v-divider></v-divider>

                        <v-list-tile
                                v-for="item in items"
                                :key="item.title"
                                @click=""
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
                items: [{title: 'Profile', route: "/profile"},{title: 'Jobs', route: "/view-jobs"},{title: 'Post Job',route: "/post-job"},{title: 'Account', route: "/account", icon: "settings"}]
            }
        }

    }

</script>