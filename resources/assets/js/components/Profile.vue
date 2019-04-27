<template>
     <div class="container">
         <div class="row">
             <div class="col-md-5">
                 <v-flex style="margin-top: 2%" xs12 sm6 offset-sm2 v-if="this.user.first_name==undefined">
                     <v-progress-circular
                             :size="50"
                             color="red"
                             indeterminate
                             v-if="!edit"
                     ></v-progress-circular>
                 </v-flex>
                 <v-flex xs12 sm8 offset-sm2 v-if="!edit && this.user.first_name!=undefined">
                     <v-card class="text-center">
                         <img style="border-radius: 50%; height: 150px; width: 150px" :src="user.photo_url==null ? 'https://cdn.vuetifyjs.com/images/cards/desert.jpg': user.photo_url"
                         />

                         <v-card-title primary-title>
                             <div>
                                 <h3 class="headline mb-0">Profile Information</h3>
                                 <div>
                                     <ul style="list-style: none;">
                                         <li><span>Name</span><span>  {{user.first_name + " " + user.last_name}}</span></li>
                                         <li><span>Phone</span><span>  {{user.phone}}</span></li>
                                         <li><span>Email</span><span>  {{user.email}}</span></li>
                                         <li><span>ID Number/Passport Number</span><span>  {{user.id_no}}</span></li>
                                     </ul>
                                 </div>
                                 <button class="btn btn-success" v-on:click="view">Edit</button>
                             </div>
                         </v-card-title>
                     </v-card>
                 </v-flex>
                 <form v-if="edit" @submit.prevent="updateUser()" enctype="multipart/form-data">
                     <div class="form-group">
                         <input type="file" accept="image/*" id="file" class="form-control" ref="file"
                                v-on:change="handleFileUpload()"/>
                     </div>
                     <div class="form-group">
                         <label for="first_name">First Name</label>
                         <input type="text" v-model="user1.first_name" id="first_name" class="form-control"
                                :placeholder="user.first_name"/>
                     </div>
                     <div class="form-group">
                         <label for="last_name">Last Name</label>
                         <input type="text" v-model="user1.last_name" id="last_name" class="form-control"
                                :placeholder="user.last_name"/>
                     </div>
                     <div class="form-group">
                         <label for="email">Email</label>
                         <input type="text" v-model="user1.email" id="email" class="form-control" :placeholder="user.email"/>
                     </div>
                     <div class="form-group">
                         <label for="id_no">ID Number</label>
                         <input type="number" v-model="user1.id_no" id="id_no" class="form-control"
                                :placeholder="user.id_no"/>
                     </div>
                     <div class="form-group">
                         <button class="btn btn-success" type="submit">Update</button>
                     </div>

                 </form>
             </div>
             <div class="col-md-7">
                 <table  class="table table-striped">
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
                     <tr>
                         <td>
                             <input type="text" placeholder="Institution" class="form-control" v-model="education.institution"/>
                         </td>
                         <td>
                             <input type="text" placeholder="Course" class="form-control" v-model="education.course"/>
                         </td>
                         <td>
                             <button class="btn btn-success btn" @click="addEducation()"><v-icon>fas fa-cart-plus</v-icon>Add Institution</button>
                         </td>
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
                     <tr>
                         <td>
                             <input type="text" placeholder="Company name" class="form-control" v-model="experience.company" required/>
                         </td>
                         <td>
                             <input type="date" placeholder="Start Year" class="form-control" v-model="experience.start_year" required/>
                         </td>
                         <td>
                             <input type="date" placeholder="End Year" class="form-control" v-model="experience.end_year"/>
                         </td>
                         <td>
                             <button class="btn btn-success" @click="addExperience()"><v-icon>fas fa-cart-plus</v-icon>Add Institution</button>
                         </td>
                     </tr>
                     </tbody>
                 </table>
             </div>

         </div>

     </div>
</template>
<script>
    export default {
        mounted() {
            axios.post('user', {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.user = response.data;
            });
        },
        data() {
            return {
                user: {},
                user1: {},
                edit: false,
                education: {},
                experience: {}
            }
        },
        methods: {
            view: function () {
                this.edit = true;
            },
            handleFileUpload: function () {
                this.user1.photo_url = this.$refs.file.files[0];
            },
            updateUser: function () {
                let formData = new FormData();
                formData.append("photo_url", this.user1.photo_url);
                formData.append("first_name", this.user1.first_name != undefined ? this.user1.first_name : this.user.first_name);
                formData.append("last_name", this.user1.last_name != undefined ? this.user1.last_name : this.user.last_name);
                formData.append("phone", this.user1.phone != undefined ? this.user1.phone : this.user.phone);
                formData.append("email", this.user1.email != undefined ? this.user1.email : this.user.email);
                formData.append("id_no", this.user1.id_no != undefined ? this.user1.id_no : this.user.id_no);
                axios.post('user/update/' + this.user.id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    this.edit=false;
                    this.user=response.data.user;
                }).catch(function () {
                    this.$router.push('/login');
                })

            },
            addEducation(){
                let data={
                  'institution': this.education.institution,
                   'course': this.education.course
                };
                axios.post('education',data).then((response)=>{
                    this.user = response.data;
                })

            },
            addExperience(){
                let data={
                    'company': this.experience.company,
                    'start_year': this.experience.start_year,
                    'end_year': this.experience.end_year
                };
                axios.post('experience',data).then((response)=>{
                    this.user = response.data;
                })
            }
        }
    }
</script>