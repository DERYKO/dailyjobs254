<template>
    <table class="table table-bordered">
        <thead>
        <th>
            Transcations
        </th>
        <th>
            Balance
        </th>
        <th>
            Actions
        </th>
        </thead>
        <tbody>
        <tr v-if="transcations.length" v-for="transcation in transcations">
            <td>{{transcation.transfer_type}}</td>
            <td>{{transcation.amount}}</td>
            <td>{{transcation.created_at}}</td>
        </tr>
        <tr v-if="!transcations.length">
            <td colspan="3">No previous history of transcations</td>
        </tr>
        <tr>
            <td>Account Balance</td>
            <td>{{balance.balance}} Ksh</td>
            <td>
                <button class="btn btn-success" @click="cashout()">Cash out</button>
            </td>
        </tr>
        </tbody>

    </table>
</template>
<script>
    export default {
        mounted() {
            axios.post('wallet').then((response) => {
                this.balance = response.data.balance;
                this.transcations = response.data.transcations;
            })
        },
        data() {
            return {
                balance: {},
                transcations: []
            }
        },
        methods:{
            cashout: function(){
                if(this.balance.balance<500){
                    this.$toasted.show('Balance must be more than 500Ksh in order to withdraw',{duration: 3000});
                }else{

                }
            }
        }
    }
</script>