<template>
                <v-layout>
                    <v-flex xs12 sm6 offset-sm2>
                        <v-card>
                            <v-img src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                                    aspect-ratio="2.75"
                            ></v-img>

                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Profile Information</h3>
                                    <div>  <ul style="list-style: none;">
                                        <li><span>Name</span><span>  {{user.first_name+" "+user.last_name}}</span></li>
                                        <li><span>Phone</span><span>  {{user.phone}}</span></li>
                                        <li><span>Email</span><span>  {{user.email}}</span></li>
                                        <li><span>ID Number/Passport Number</span><span>  {{user.id_no}}</span></li>
                                        <li><span>Phone</span><span>  {{user.phone}}</span></li>
                                    </ul>
                                    </div>
                                    <v-btn large>Edit</v-btn>
                                </div>
                            </v-card-title>
                        </v-card>
                    </v-flex>
                </v-layout>

</template>
<script>
    export default {
     mounted(){
         axios({
             method: 'post',
             url: 'user',
         }).then((response)=> {
             console.log(response)
             this.user=response.data;
         });
     },
     data(){
         return{
             user: {}
         }
     }
    }
</script>