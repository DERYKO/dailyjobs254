<template>
    <div class="container col-md-12">
        <div class="center card col-md-5">
            <div class="card-body">
                <button @click="back"><i class="fas fa-arrow-circle-left fa-2x">Back</i></button>
                <h5 class="card-title text-center">Create Account</h5>
                <ul><li  v-for="error in errors"><span style="color: red">{{error[0]}}</span></li></ul>
                <form @submit.prevent="register">
                  <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input type="text" v-model="first_name" id="first_name" name="first_name" class="form-control" required/>
                  </div>
                <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" v-model="last_name" id="last_name" name="last_name" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" v-model="phone" name="phone" id="phone" class="form-control" required/>
                </div>
                <div class="form-group">
                   <label>Email</label>
                   <input type="email" v-model="email" id="email" name="email" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label for="id_no">ID NO/PASSPORT NO</label>
                    <input type="number" v-model="id_no" id="id_no" name="id_no" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" v-model="password" id="password" name="password" class="form-control" required/>
                </div>
                 <button type="submit" class="btn btn-success btn-lg">Register</button>
                </form>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data(){
            return{
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                id_no: '',
                password: '',
                errors: [],
            }
        },
        methods:{
            register: function () {
                let data={
                    first_name: this.first_name,
                    last_name: this.last_name,
                    phone: this.phone,
                    email: this.email,
                    id_no: this.id_no,
                    password: this.password
                }
                axios.post('register',data).then((response)=>{
                    console.log(response.data)
                    this.$router.push('/login')
                }).catch((errors)=>{
                    this.errors=errors.response.data.errors;
                    console.log(this.errors);
                })
            },
            back: function () {
               this.$router.back();
            }
        }

    }
</script>
<style>
    .container {
        display: flex;
        justify-content: center;
    }
    .center {
        width: 800px;
    }
</style>