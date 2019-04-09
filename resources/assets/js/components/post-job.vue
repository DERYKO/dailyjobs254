<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="post" @submit.prevent="save()">
                <ul v-for="error in errors"><li>{{error}}</li></ul>
                <div class="form-group col-md-9">
                    <label for="title">Title</label>
                    <input v-model="title" type="text" class="form-control" id="title" name="title" required/>
                </div>
                <div class="form-group col-md-9">
                    <label for="description">Description</label>
                    <textarea v-model="description" class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group col-md-9">
                    <label for="rules">Rules</label>
                    <textarea v-model="rules" class="form-control" id="rules" name="rules" ></textarea>
                </div>
                <div class="form-group col-md-9">
                    <label for="pay_amount" style="color: red">Amount(Please note Must! be paid when posting a job)*</label>
                    <input v-model="pay_amount" type="number" class="form-control" id="pay_amount" name="pay_amount" required/>
                </div>
                <div class="form-group col-md-9">
                    <label for="duration">Duration</label>
                    <date-range-picker className="form-control" id="duration" v-model="range" :options="options" required/>
                </div>
                <div class="form-group col-md-9">
                    <h4>Job Location</h4>
                    <div>
                        <label>
                            <gmap-autocomplete
                                    class="form-control col-md-9"
                                    @place_changed="setPlace">
                            </gmap-autocomplete>
                        </label>
                        <br/>

                    </div>
                    <br>
                    <gmap-map
                            :center="center"
                            :zoom="12"
                            style="width:100%;  height: 400px;"
                    >
                        <gmap-marker
                                :key="index"
                                v-for="(m, index) in markers"
                                :position="m.position"
                                @click="center=m.position"
                        ></gmap-marker>
                    </gmap-map>
                </div>
                <button class="col-md-9 btn btn-primary btn-lg" type="submit">
                    Post Job
                </button>
                </form>
            </div>
        </div>

    </div>

</template>
<script>
    import moment from 'moment'
    export default {
        mounted(){
            this.geolocate();
        },
        data(){
            return {
                errors: [],
                range: ["01/09/2018", "01/10/2018"],
                options: {
                    timePicker: true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                        format: 'M/DD hh:mm A'
                    }
                },
                center: { lat: 45.508, lng: -73.587 },
                markers: [],
                places: [],
                currentPlace: null,
                title: '',
                description: '',
                pay_amount: '',
                rules: '',
                duration: '',

            }
        },
        methods: {
           save: function () {
               var a = moment(this.range[0], 'DD/MM/YYYY');
               var b = moment(this.range[1], 'DD/MM/YYYY');
               var days = b.diff(a, 'days');
               let data={
                   title: this.title,
                   description: this.description,
                   pay_amount: this.pay_amount,
                   start_time: this.range[0],
                   job_location_address: {lat: this.markers[0].position.lat, long: this.markers[0].position.lng},
                   rules: this.rules,
                   latitude: this.markers[0].position.lat,
                   longitude: this.markers[0].position.lng,
                   duration: days,
               }
               axios.post('save-job',data).then((response)=>{
                   this.$router.push('/view-jobs');
               }).catch((error)=>{
                    this.errors.push(error.message);
               })
           },
            setPlace(place) {
                this.currentPlace = place;
                this.addMarker();
            },
            addMarker() {
                if (this.currentPlace) {
                    this.markers=[];
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.markers.push({ position: marker });
                    this.places.push(this.currentPlace);
                    this.center = marker;
                    this.currentPlace = null;
                }
            },
            geolocate: function() {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            }
          }


    }
</script>