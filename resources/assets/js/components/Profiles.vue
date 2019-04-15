
<template>
    <v-layout>
        <v-flex xs12 sm10 offset-sm1>
            <v-card>
                <v-container v-bind="{ [`grid-list-${users.length}`]: true }" fluid>
                    <v-layout row wrap>
                        <v-flex
                                v-for="user in users"
                                :key="n"
                                xs4
                        >
                            <v-card-title primary-title class="text-center">
                                <h2>{{user.first_name +' '+ user.last_name}}</h2>
                                <div>
                                    <p><v-icon>fas fa-envelope-open-text</v-icon> {{user.email}}</p>
                                    <p><v-icon>fas fa-phone-volume</v-icon> {{user.phone}}</p>
                                </div>
                            </v-card-title>
                            <v-card flat tile>
                                <v-img
                                        :src="user.photo_url==null ? 'https://cdn.vuetifyjs.com/images/cards/desert.jpg': user.photo_url"
                                        width="150px"
                                        height="150px"
                                ></v-img>
                            </v-card>
                            <v-card-footer>
                                <v-btn fab dark color="teal">
                                    <v-icon dark>list</v-icon>
                                </v-btn>
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