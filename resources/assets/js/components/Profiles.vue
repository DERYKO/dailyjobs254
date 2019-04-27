<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout>
        <v-flex xs12 sm10 offset-sm1>
            <v-card>
                <v-container v-bind="{ [`grid-list-${users.length}`]: true }" fluid>
                    <v-layout row wrap>
                        <v-flex
                                v-for="user in users"
                                :key="n"
                                xs4
                                style="margin: 3%"
                        >
                            <v-card-title primary-title class="text-center">
                                <h5>{{user.first_name +' '+ user.last_name}}</h5>
                            </v-card-title>
                            <v-card flat tile>
                                <v-img
                                        :src="user.photo_url==null ? 'https://cdn.vuetifyjs.com/images/cards/desert.jpg': user.photo_url"
                                        width="150px"
                                        height="150px"
                                ></v-img>
                            </v-card>
                            <v-card-footer>
                                <div class="text-center">
                                    <v-dialog
                                            v-model="dialog"
                                            width="500"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-btn fab dark color="teal" v-on="on">
                                                <v-icon dark>list</v-icon>
                                            </v-btn>

                                        </template>

                                        <v-card>
                                            <v-card-title
                                                    class="headline grey lighten-2"
                                                    primary-title
                                            >
                                                User Profile
                                            </v-card-title>

                                            <v-card-text>
                                                <h5>{{user.email}}</h5>
                                                <table style="font-size: large" class="table table-striped">
                                                    <thead>
                                                    Education
                                                    </thead>
                                                    <thead>
                                                    <th>
                                                        Institution
                                                    </th>
                                                    <th>
                                                        Course
                                                    </th>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-if="user.education.length" v-for="education in user.education">
                                                        <td>{{education.institution}}</td>
                                                        <td>{{education.course}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table  class="table table-striped">
                                                    <thead>
                                                    Experience
                                                    </thead>
                                                    <thead>
                                                    <th>
                                                        Company
                                                    </th>
                                                    <th>
                                                        Start Year
                                                    </th>
                                                    <th>End Year</th>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-if="user.experience.length" v-for="experience in user.experience">
                                                        <td>{{experience.company}}</td>
                                                        <td>{{experience.start_year}}</td>
                                                        <td>{{experience.end_year}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </v-card-text>

                                            <v-divider></v-divider>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                        fab dark color="pink"
                                                        @click="dialog = false"
                                                >
                                                    <v-icon dark>favorite</v-icon>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </div>
                            </v-card-footer>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </v-flex>
    </v-layout>
</template>
<script>
    export default {
        mounted(){
            axios.post('profiles').then((response)=>{
                this.users=response.data.data
            })
        },
        data(){
            return{
                users: [],
            }
        }
    }
</script>