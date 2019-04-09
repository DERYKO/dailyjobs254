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
                <p><router-link :to="{ name: 'apply', params: { owner_id: owner_id, job_id: id}}"><button class="btn btn-success btn-lg col-md-12">Apply</button></router-link></p>
            </div>
</template>
<script>
    export default {
        props:['job_id'],
        mounted(){
          axios.post('get-job/'+this.job_id).then((response)=>{
              navigator.geolocation.getCurrentPosition(this.initialize,this.fail);
              const marker = {
                  lat: response.data.latitude,
                  lng: response.data.longitude
              };
              this.markers.push({ position: marker });
              this.places.push(this.currentPlace);
              this.center = marker;
              this.owner_id=response.data.owner_id;
              this.id=response.data.id;
              this.title=response.data.title;
              this.description=response.data.description;
              this.amount=response.data.pay_amount;
          }).catch(function () {
              this.$router.push('/view-jobs');
          })
        },
        data(){
            return{
                center: {lat: 1.2921, lng: 36.8219},
                id: null,
                owner_id: null,
                markers: [],
                places: [],
                description: '',
                title: '',
                amount: null,
            }
        },
        methods:{
            initialize: function (position) {
                const marker={
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                }
                var im = 'http://www.robotwoods.com/dev/misc/bluecircle.png';
                var oMarker = new google.maps.Marker({
                    position: marker,
                    sName: "Current Location",
                });
                this.markers.push(oMarker);
            },
            fail: function () {
                alert('navigator.geolocation failed, may not be supported');
            }
        }
    }

</script>