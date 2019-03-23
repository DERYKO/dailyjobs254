<template>
    <form class="col-md-6" method="post" @submit.prevent="save()">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required/>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="rules">Rules</label>
            <textarea class="form-control" id="rules" name="rules" ></textarea>
        </div>
        <div class="form-group">
            <label for="pay_amount">Amount</label>
            <input type="number" class="form-control" id="pay_amount" name="pay_amount" required/>
        </div>
        <div class="form-group">
            <label for="duration">Duration</label>
            <date-range-picker id="duration" className="form-control" v-model="range" :options="options" />
        </div>
        <div class="form-group">
            <vue-google-autocomplete
                    id="map"
                    classname="form-control"
                    placeholder="Start typing"
                    v-on:placechanged="getAddressData"
            >
            </vue-google-autocomplete>
        </div>
        <button class="btn btn-primary btn-lg" type="submit">
            Post Job
        </button>
    </form>

</template>
<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'
    export default {
        components:{VueGoogleAutocomplete},
        mounted(){
        },
        data(){
            return {
                range: ["01/09/2018", "01/10/2018"],
                options: {
                    timePicker: true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                        format: 'M/DD hh:mm A'
                    }
                },
                address: '',
                geocoder: {},
                platform: {},
                center: { lat: 45.508, lng: -73.587 },
                markers: [],
                places: [],
            }
        },
        methods: {
           save: function () {
           },
            getAddressData: function (addressData, placeResultData, id) {
                this.address = addressData;
            }
          }


    }
</script>