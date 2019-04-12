<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-app>
        <v-navigation-drawer
                style="background-color: #c9e2b3"
                persistent
                :mini-variant="miniVariant"
                :clipped="clipped"
                v-model="drawer"
                enable-resize-watcher
                fixed
                app
        >
            <v-card style="background-color: transparent;" class="text-center">
                    <img src="https://cf.ltkcdn.net/jobs/images/std/145021-425x251-find_jobs_on_career_builder.JPG" style="height: 150px; width: 100%" class="card-img-top" alt="...">
            </v-card>
            <v-list>
                <v-list-tile
                        value="true"
                        v-for="(item, i) in items"
                        :key="i"
                >
                    <v-list-tile-action>
                        <v-icon v-html="item.icon"></v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <router-link :to="item.route"> <v-list-tile-title v-text="item.title"></v-list-tile-title> </router-link>
                    </v-list-tile-content>
                </v-list-tile>

            </v-list>
        </v-navigation-drawer>
        <v-toolbar
                app
                :clipped-left="clipped"
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-btn icon @click.stop="miniVariant = !miniVariant">
                <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"></v-icon>
            </v-btn>
            <v-btn icon @click.stop="clipped = !clipped">
                <v-icon>web</v-icon>
            </v-btn>
            <v-btn icon @click.stop="fixed = !fixed">
                <v-icon>remove</v-icon>
            </v-btn>
            <v-toolbar-title v-text="title">OneDayJobs</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn
                            v-on="on"
                    >
                        <v-icon>menu</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-tile
                    >
                        <v-list-tile-title><button @click="logout()" class="btn btn-default btn-sm">Logout</button></v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
        <v-content>
                <router-view/>
        </v-content>
        <v-navigation-drawer
                temporary
                :right="right"
                v-model="rightDrawer"
                fixed
                app
        >
            <v-list>
                <v-list-tile @click="right = !right">
                    <v-list-tile-action>
                        <v-icon>compare_arrows</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title>Switch drawer (click me)</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-footer :fixed="fixed" app style="background-color: black;">
            <div class="d-md-flex justify-content-between align-items-center">

                <div class="mb-2 mb-md-0">
                    <a href="#" class="text-white mr-3"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="text-white mr-3"><i class="fab fa-twitter-square"></i></a>
                    <a href="#" class="text-white mr-3"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="mb-0 text-white">&copy;Jobs254</div>
                <div class="">
                    <a href="/privacy" class=" btn btn-link text-white">Privacy Policy</a>
                    <a href="/terms" class=" btn btn-link text-white">Terms</a>
                    <a href="/faq" class=" btn btn-link text-white">FAQ</a>
                </div>
            </div>
        </v-footer>
    </v-app>
</template>
<script>
    export default {
        data() {
            return {
                clipped: false,
                drawer: true,
                fixed: false,
                notifications: 20,
                miniVariant: false,
                right: true,
                rightDrawer: false,
                items: [
                    {title: 'Profile', route: "/profile", icon: "far fa-user-circle"}, {
                    title: 'Search Jobs',
                    route: "/view-jobs",
                    icon: "fas fa-binoculars"
                }, {title: 'Post Job', route: "/post-job", icon: "fas fa-user-md"},
                    {
                        title: 'Notifications',
                        route: "/notifications",
                        icon: "fas fa-bell"
                    },
                    {
                    title: 'Account',
                    route: "/account",
                    icon: "fas fa-user-cog"
                }, {title: 'Wallet', route: "/wallet", icon: "fas fa-wallet"}]
            }
        },
        methods: {
            logout: function () {
                axios.post('logout').then((res) => {
                    this.$router.push('/login');
                }).catch((error) => {
                    console.log(error)
                });
            }
        }

    }

</script>