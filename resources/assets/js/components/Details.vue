<template>
    <div class="col-md-12">
        <h2 class="text-center">{{title}}</h2>
        <gmap-map
                class="col-md-12"
                :center="center"
                :zoom="12"
                style="width:100%;  height: 500px;"
        >
            <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    @click="center=m.position"
            ></gmap-marker>
        </gmap-map>
        <p style="font-weight: bold; color: black">Description: {{description}}</p>
        <p style="font-weight: bold; color: black">Amount: {{amount}} Ksh</p>
        <p style="font-weight: bold; color: black">Distance in kilometres from your current position: {{distance}} Km(s)</p>
        <p style="font-weight: bold; color: black">Estimated Minimum Fare: {{400*distance/150<20?20*2:Math.round(400*distance/150)*2}} Ksh</p>
        <p style="font-weight: bold; color: black">Possible maximum profit: {{95/100 *(amount-(Math.round(400*distance/150)*2))}} Ksh</p>
        <p>
            <router-link :to="{ name: 'apply', params: { owner_id: owner_id, job_id: id}}">
                <button class="btn btn-success btn-lg col-md-12">Apply</button>
            </router-link>
        </p>
    </div>
</template>
<script>
    export default {
        props: ['job_id'],
        mounted() {
            axios.post('get-job/' + this.job_id).then((response) => {
                navigator.geolocation.getCurrentPosition(this.initialize, this.fail);
                const marker = {
                    lat: response.data.latitude,
                    lng: response.data.longitude
                };
                this.latitude=response.data.latitude;
                this.longitude=response.data.longitude;
                this.markers.push({position: marker});
                this.places.push(this.currentPlace);
                this.center = marker;
                this.owner_id = response.data.owner_id;
                this.id = response.data.id;
                this.title = response.data.title;
                this.description = response.data.description;
                this.amount = response.data.pay_amount;
            }).catch(function () {
                this.$router.push('/view-jobs');
            })
        },
        data() {
            return {
                center: {lat: 1.2921, lng: 36.8219},
                id: null,
                owner_id: null,
                markers: [],
                places: [],
                description: '',
                title: '',
                amount: null,
                latitude: null,
                longitude: null,
                distance: null
            }
        },
        methods: {
            initialize: function (position) {
                const marker = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                }
                this.distance=this.calcCrow(this.latitude,this.longitude,marker.lat,marker.lng).toFixed(1)

            },
            fail: function () {
                alert('navigator.geolocation failed, may not be supported');
            },
            calcCrow(lat1, lon1, lat2, lon2) {
                var R = 6371; // km
                var dLat = this.toRad(lat2 - lat1);
                var dLon = this.toRad(lon2 - lon1);
                var lat1 = this.toRad(lat1);
                var lat2 = this.toRad(lat2);

                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                return d;
            },

            // Converts numeric degrees to radians
            toRad(Value) {
                return Value * Math.PI / 180;
            }

        }
    }

</script>