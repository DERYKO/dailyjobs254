<template>
    <div class="col-md-9">
            <div class="card" v-for="job in jobs">
                <div class="card-header">
                    <h3>{{job.title}}</h3>
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
                        <router-link :to="{ name: 'job-details', params: { job_id: job.id }}" ><button class="btn btn-link">View Details</button></router-link>
                    </p>
                </div>
            </div>

      </div>
</template>
<script>
    export default {
        mounted(){
            axios.post('view-jobs').then((response)=>{
                this.jobs=response.data.data;
            })
        },
        data(){
            return{
                jobs: [],
            }
        }

    }
</script>