<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Cover letter</h3>
                <form method="post" @submit.prevent="apply">
                    <div class="form-group col-md-12">
                        <vue-editor v-model="cover_letter"></vue-editor>
                               </div>
                    <button class="col-md-12 btn btn-success" type="submit">Apply</button>
                </form>
            </div>

        </div>

    </div>
</template>
<script>
    import { VueEditor } from 'vue2-editor'
    export default {
        components: {
            VueEditor
        },

        props: ['job_id','owner_id'],
        mounted(){
            console.log(this.job_id,this.owner_id)
        },
        data(){
            return{
                cover_letter: ''
            }
        },
        methods:{
            apply: function () {
              let data={
                  job_id: this.job_id,
                  owner_id: this.owner_id,
                  cover_letter: this.cover_letter
              }
              axios.post('/applications',data).then((response)=>{
                  this.$toasted.show('Your application has been submitted',{duration: 3000});
                  this.$router.push('/view-jobs')
              }).catch(function () {
                  this.$router.push('/view-jobs');
              })
            }
        }
    }
</script>