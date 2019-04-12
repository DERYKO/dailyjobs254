<template>
    <div class="col-md-10">
        <div>
             <table class="table table-striped" style="font-size: 20px">
                 <thead>
                 <th>
                     Job Name
                 </th>
                 <th>
                     Job description
                 </th>
                 <th>
                    Amount
                 </th>
                 <th>
                    No of Applicants
                 </th>
                 </thead>
                 <tbody v-for="job in jobs">
                 <tr v-if="job.active==1">
                     <td style="background-color: #b1b7ba;color: black; font-size: large">{{job.title}}</td>
                     <td>{{job.description}}</td>
                     <td>{{job.pay_amount}}</td>
                     <td>{{job.applications.length}}</td>
                     <td v-if="job.applications.length>0"><button  class="btn btn-success" v-on:click="view()">View Applicants</button></td>
                 </tr>
                 <tr style="background-color: #b6a338" v-if="applicants" v-for="applications in job.applications">
                     <td>
                         {{ applications.applicant_id}}
                     </td>
                     <td v-html="applications.cover_letter">
                     </td>
                     <td>
                       <button class="btn btn-success" @click="acceptBid(applications)">Accept bid</button>
                     </td>

                 </tr>
                 </tbody>

             </table>
        </div>
    </div>
</template>
<script>
    export default {
        mounted(){
            axios.post('notifications').then((response)=>{
                this.jobs=response.data.jobs
                console.log(this.jobs)
            })
        },
        data(){
            return{
                jobs: [],
                applicants: false

            }
        },
        methods: {
            view(){
                this.applicants=true;
            },
            acceptBid(application){
              axios.post('accept-bid',application).then((response)=>{
                  this.applicants=false
                  this.$toasted.show('Bid accepted',{duration: 3000});
                  this.jobs=response.data.jobs
                 this.$router.push('/notifications')
                })
            }
        }
    }
</script>