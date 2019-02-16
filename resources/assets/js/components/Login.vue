<template>
    <div class="container col-md-12">
            <div class="center card col-md-4">
                <img src="../../../../public/logo/logo.jpg" style="height: 160px; width: auto" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>
                    <div class="card-header text-center">
                        <span v-if="error!==''" :style="color"><i class="fas fa-exclamation-circle fa-lg"> {{error}}</i></span>
                    </div>
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone fa-lg">Phone Number</i></label>
                            <input type="text" v-model="phone" id="phone" name="phone" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="fas fa-unlock-alt fa-lg">Password</i></label>
                            <input type="password" v-model="password" id="password" name="password" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-lg" type="submit">Login</button>
                            <router-link class="pull-right" style="margin-top: 3%" to="/register">
                                <a>Not registered? click here</a>
                            </router-link>
                        </div>
                    </form>
                </div>
            </div>
    </div>

</template>
<script>
    import axios from 'axios'
    export default {
        data(){
            return{
                phone: '',
                password: '',
                error: '',
                color: 'color: red; font-style: italic;'
            }
        },
        methods:{
            login: function () {
                let data={
                    phone: this.phone,
                    password: this.password,
                }
               axios.post('login',data).then(response=>{
                   this.color='color: #2ca02c; font-style: italic;';
                   this.error='success';
                   this.$router.push('/');

               }).catch(error=>{
                   this.color='color: red; font-style: italic;'
                   this.error=error.response.data.message
               })
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