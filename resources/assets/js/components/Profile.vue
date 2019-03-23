<template>
    <div>
        <img src="images/profile.jpg" style="border-radius: 30%" width="200dp" height="250dp"/>
        <ul style="list-style: none;">
            <li><span style="color: #b6a338; font-size: xx-large; font-weight: bold">Name</span><span>  {{user.first_name+" "+user.last_name}}</span></li>
            <li><span style="color: #b6a338; font-size: xx-large; font-weight: bold">Phone</span><span>  {{user.phone}}</span></li>
            <li><span style="color: #b6a338; font-size: xx-large; font-weight: bold">Email</span><span>  {{user.email}}</span></li>
            <li><span style="color: #b6a338; font-size: xx-large; font-weight: bold">ID Number/Passport Number</span><span>  {{user.id_no}}</span></li>
            <li><span style="color: #b6a338; font-size: xx-large; font-weight: bold">Phone</span><span>  {{user.phone}}</span></li>
        </ul>

    </div>

</template>
<script>
    export default {
     mounted(){
         axios({
             method: 'post',
             url: 'user',
         }).then((response)=> {
             console.log(response)
             this.user=response.data;
         });
     },
     data(){
         return{
             user: {}
         }
     }
    }
</script>