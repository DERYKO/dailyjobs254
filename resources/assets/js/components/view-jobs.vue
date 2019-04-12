<template>
    <div class="col-md-9">
        <div  v-if="jobs.length<1" class="text-center col-md-9">
            <span style="font-size: 50px; color: black">No jobs available for now</span>
        </div>
            <div class="card" v-for="job in jobs">
                <div class="card-header">
                    <p><span class="pull-left" style="font-size: larger;color: black; background-color: #b1b7ba">{{job.title}}</span><img :src="job.user.photo_url" class="pull-right" height="90px" width="90px" style="border-radius: 40%"/></p>
                </div>
                <div class="card-body">
                    <p style="text-align: justify; font-style: italic">
                        {{job.description}}
                    </p>
                    <p>
                        Duration:  {{job.duration}} days
                    </p>
                    <p>
                        Amount: {{job.pay_amount}} Ksh
                    </p>
                    <p>
                        Reporting date and time: {{job.start_time}}
                    </p>
                    <p>
                        Job location: {{job.job_location_address}}
                    </p>
                    <p>
                        <router-link :to="{ name: 'job-details', params: { job_id: job.id }}" ><button class="btn btn-success">View Details</button></router-link>
                    </p>
                </div>
            </div>
      </div>
</template>
<script>
    export default {
        mounted(){
            axios.post('view-jobs').then((response)=>{
                console.log(response.data.data)
                this.jobs=response.data.data;
            }).catch(function () {
                this.$router.push('/login');
            })
        },
        data(){
            return{
                jobs: [],
            }
        }

    }
</script>