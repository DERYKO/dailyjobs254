<template>
    <div class="col-md-9">
        <div  v-if="jobs.length<1" class="text-center col-md-9">
            <span style="font-size: 50px; color: black">No jobs available for now</span>
        </div>
            <div class="card" v-for="job in jobs">
                <div class="card-header">
                    <p><span class="pull-left" style="color: black; border: solid black; margin: 1%">{{job.job.title}}</span><img :src="job.job.user.photo_url" class="pull-right" height="40px" width="40px" style="border-radius: 40%"/></p>
                </div>
                <div class="card-body">
                    <p style="text-align: justify; font-style: italic">
                        {{job.job.description}}
                    </p>
                    <p>
                        Duration:  {{job.job.duration}} days
                    </p>
                    <p>
                        Amount: {{job.job.pay_amount}} Ksh
                    </p>
                    <p>
                        Reporting date and time: {{job.job.start_time}}
                    </p>
                </div>
                <div class="card-footer" v-if="job.forecast.length">
                    <div class="scrolling-wrapper" style="overflow-x: scroll;overflow-y: hidden;white-space: nowrap;">
                        <v-card style="display: inline-block; height: auto; width: auto" v-for="prediction in job.forecast">
                            <v-card-title primary-title>
                                {{prediction.prediction}}
                            </v-card-title>
                            <v-img :src="getPath(prediction.icon_code)" style="width: 55px; height: 63px;">
                            </v-img>
                            <v-card-title primary-title>
                                {{prediction.time}} ({{days[new Date(prediction.time).getDay()]}})
                            </v-card-title>
                        </v-card>
                    </div>
                </div>
                <div class="text-center">
                    <router-link :to="{ name: 'job-details', params: { job_id: job.job.id }}" ><button class="btn btn-success">View Details</button></router-link>
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
                days: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']
            }
        },
        methods:{
            getPath: function (code) {
                return "icons/png/"+this.pad(code)+".png";
            },
            pad(num) {
                if (num<10){
                    return "0"+num;
                }else{
                    return num;
                }
            }
        }

    }
</script>
