<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p style="text-align: center">{{title}}</p>
                <gmap-map
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
                <p style="text-align: center">{{description}}</p>
                <p class="text-center" style="font-size: large; ">{{amount}} Ksh</p>
                <p class="text-center"><button class="btn btn-success btn-lg col-md-9">Apply</button></p>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props:['job_id'],
        mounted(){
          axios.post('get-job/'+this.job_id).then((response)=>{

              const marker = {
                  lat: response.data.latitude,
                  lng: response.data.longitude
              };
              console.log(marker)
              this.markers.push({ position: marker });
              this.places.push(this.currentPlace);
              this.center = marker;
              this.title=response.data.title;
              this.description=response.data.description;
              this.amount=response.data.pay_amount;
          })
        },
        data(){
            return{
                center: {lat: 1.2921, lng: 36.8219},
                markers: [],
                places: [],
                description: '',
                title: '',
                amount: null,
            }
        }
    }

</script>