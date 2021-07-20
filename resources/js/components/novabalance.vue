<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Booster Name"
            single-line
            hide-details
            class="blackComponent"
        ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="-1"
            :search="search"
            class="elevation-1 vueTable"
        >
        </v-data-table>
    </div>
</v-app>
</template>

<script>
  export default {
    data () {
      return {
            dialog: false,
            search: '',
            items: [],
            headers: [
                { text: 'Booster', value: 'name'},
                { text: 'Total Balance', value: 'total_balance', filterable: false },
                { text: 'Balance Operations', value: 'balance_ops', filterable: false },
                { text: 'Balance from MPlus boost', value: 'mplus_booster_total', filterable: false },
                { text: 'Balance from MPlus Adv', value: 'mplus_adv_total', filterable: false },
                { text: 'Balance from Various boost', value: 'various_booster_total', filterable: false },
                { text: 'Balance from Various Adv', value: 'various_adv_total', filterable: false },
                { text: 'Balance from Raids', value: 'raids_total', filterable: false },
            ],
            snackbar: false,
            text: `There was an error in your input. Please, recheck it or contact a Developer.`,
            snackbarBadValue: false,
            loading: false,
            textBadValue: `The amount of payment is over the amount he needs to get paid. Please, recheck it or contact a Developer.`,
        }
    },

    methods: {
        showBalance() {
            axios
            .get('/balanceCheck')
            .then ((response) => {
                this.items = response.data
            })
            .catch(error => console.log(error));
        },
    },


    beforeMount () {
        this.showBalance();
    }
  }
</script>
