<template>
    <div class="col-md-9">
        <table class="table table-bordered col-md-12">
            <tbody>
            <tr class="text-center">
                <td>
                    <button class="btn btn-success btn-lg " @click="isactive()">My Active jobs</button>
                </td>
                <td>
                    <button class="btn btn-dark btn-lg" @click="iscompleted()">Completed jobs</button>
                </td>
                <td>
                    <button class="btn btn-dark btn-lg" @click="ismounted()">Search jobs</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="card" v-if="completed" v-for="comp in complete">
            <div class="card-header">
                <p><span class="pull-left" style="color: black; border: solid black; margin: 1%">{{comp.title}}</span>
                </p>
            </div>
            <div class="card-body">
                <p style="text-align: justify; font-style: italic">
                    {{comp.description}}
                </p>
                <p>
                    Duration:  {{comp.duration}} days
                </p>
                <p>
                    Amount: {{comp.pay_amount}} Ksh
                </p>
                <p>
                    Reporting date and time: {{comp.start_time}}
                </p>
            </div>
        </div>
        <div class="card" v-if="active" v-for="comp in running">
            <div class="card-header">
                <p><span class="pull-left" style="color: black; border: solid black; margin: 1%">{{comp.title}}</span>
                </p>
            </div>
            <div class="card-body">
                <p style="text-align: justify; font-style: italic">
                    {{comp.description}}
                </p>
                <p>
                    Duration:  {{comp.duration}} days
                </p>
                <p>
                    Amount: {{comp.pay_amount}} Ksh
                </p>
                <p>
                    Reporting date and time: {{comp.start_time}}
                </p>
            </div>
            <div class="card-footer">
                No of applicants: <span style="color: black; font-weight: bold">{{comp.applications.length}}</span>
                <button class="pull-right btn btn-warning btn-sm" v-if="comp.applications.length"
                        @click="applicant(comp.applications)">View Applicants
                </button>
            </div>
        </div>
        <div class="card" v-if="applicants && applications.length" v-for="apply in paginatedD">
            <div class="card-header">
                {{ apply.applicant_id}}
            </div>
            <div class="card-body text-center" v-html="apply.cover_letter">
            </div>
            <div class="card-footer text-center">
                Applied on {{apply.created_at}}.
                <button class="btn btn-success btn-sm pull-right">Accept application</button>
            </div>
        </div>
        <p v-if="applicants && applications.length" style="margin-bottom: 8%">
            <button
                    class="pull-left btn btn-warning btn-lg"
                    :disabled="Number === 0"
                    @click="prevP">
                <v-icon>far fa-hand-point-left</v-icon>
                Previous
            </button>
            <button
                    class="pull-right btn btn-warning btn-lg"
                    :disabled="Number >= pageC -1"
                    @click="nextP">
                <v-icon>far fa-hand-point-right</v-icon>
                Next
            </button>
        </p>
        <div v-if="jobs.length<1 && job_tab" class="text-center col-md-9">
            <span style="font-size: 50px; color: black">No jobs available for now</span>
        </div>
        <div v-if="jobs.length>1 && job_tab" class="card" v-for="job in paginatedData">
            <div class="card-header">
                <p><span class="pull-left"
                         style="color: black; border: solid black; margin: 1%">{{job.job.title}}</span><img
                        :src="job.job.user.photo_url" class="pull-right" height="40px" width="40px"
                        style="border-radius: 40%"/></p>
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
                    <v-card style="display: inline-block; height: auto; width: auto" v-for="prediction in job.forecast" :key="prediction.id">
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
                <router-link :to="{ name: 'job-details', params: { job_id: job.job.id }}">
                    <button class="btn btn-success">View Details</button>
                </router-link>
            </div>
        </div>
        <p v-if="jobs.length>1 && job_tab" style="margin-bottom: 8%">
            <button
                    class="pull-left btn btn-warning btn-lg"
                    :disabled="pageNumber === 0"
                    @click="prevPage">
                <v-icon>far fa-hand-point-left</v-icon>
                Previous
            </button>
            <button
                    class="pull-right btn btn-warning btn-lg"
                    :disabled="pageNumber >= pageCount -1"
                    @click="nextPage">
                <v-icon>far fa-hand-point-right</v-icon>
                Next
            </button>
        </p>

    </div>
</template>
<script>
    export default {
        mounted() {
            axios.post('view-jobs').then((response) => {
                console.log(response.data.data)
                this.jobs = response.data.data;
            }).catch(function () {
                this.$router.push('/login');
            })
        },
        data() {
            return {
                Number: 0,
                s: 1,
                pageNumber: 0,
                jobs: [],
                size: 3,
                job_tab: true,
                active: false,
                complete: [],
                running: [],
                completed: false,
                applicants: false,
                applications: [],
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
            }
        },
        methods: {
            getPath: function (code) {
                return "icons/png/" + this.pad(code) + ".png";
            },
            pad(num) {
                if (num < 10) {
                    return "0" + num;
                } else {
                    return num;
                }
            },
            iscompleted() {
                this.job_tab = false;
                this.completed = true;
                this.active = false;
                this.applicants = false;
                axios.post('completed').then((response) => {
                    this.complete = response.data;
                })
            },
            isactive() {
                this.job_tab = false;
                this.completed = false;
                this.active = true;
                this.applicants = false;
                axios.post('active').then((response) => {
                    this.running = response.data;
                })
            },
            applicant(applied) {
                this.job_tab = false;
                this.completed = false;
                this.active = false;
                this.applicants = true;
                this.applications = applied;
                console.log(applied);
            },
            ismounted() {
                this.job_tab = true;
                this.completed = false;
                this.active = false;
                this.applicants = false;
            },
            nextPage(){
                this.pageNumber++;
            },
            prevPage(){
                this.pageNumber--;
            },
            nextP(){
                this.Number++;
            },
            prevP(){
                this.Number--;
            }
        },
        computed:{
            pageCount(){
                let l = this.jobs.length,
                    s = this.size;
                return Math.floor(l/s);
            },
            paginatedData(){
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                return this.jobs
                    .slice(start, end);
            },
            pageC(){
                let l = this.applications.length,
                    s = this.s;
                return Math.floor(l/s);
            },
            paginatedD(){
                const start = this.Number * this.s,
                    end = start + this.s;
                return this.applications
                    .slice(start, end);
            }
        }

    }
</script>
