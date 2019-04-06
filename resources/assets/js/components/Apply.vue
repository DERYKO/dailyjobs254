<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="post" @submit.prevent="apply">
                    <div class="form-group col-md-12">
                        <label for="cover_letter">Cover Letter</label>
                        <textarea v-model="cover_letter" id="cover_letter" name="cover_letter" cols="150" rows="10" class="form-control" required></textarea>
                    </div>
                    <button class="col-md-12 btn btn-success">Apply</button>

                </form>

            </div>

        </div>

    </div>
</template>
<script>
    export default {
        props: ['job_id','owner_id'],
        mounted(){

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
                  this.$toasted.show('Your application has been submitted');
                  this.$router.push('/view-jobs')
              })
            }
        }
    }
</script>