<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
        <div style="text-align: center; padding-top: 10px;">
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color: red; font-size: 10px;"
                @click="showPayments('horde')"
            ><img :src="'/images/hordeicon64.png'"></v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                text
                tile
                style="color:blue; font-size: 10px;"
                @click="showPayments('alliance')"
            ><img :src="'/images/allianceicon64.png'"></v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color:black; font-size: 10px;"
                @click="showPayments('all')"
            ><img :src="'/images/allicon64.png'"></v-btn>
        </div>
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Boost Realm"
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
        <template v-slot:item.paid="{ item }">
            <v-text-field
                v-model="item.paid"
          ></v-text-field>
        </template>

        <template v-slot:item.actions="{ item }">
            <v-btn elevation="2" fab x-small class="save-button-dialog" color="grey darken-1" @click="sendPayment(item)">
                <span class="material-icons">
                    save
                </span>
            </v-btn>
        </template>
        </v-data-table>
        <v-snackbar v-model="snackbar">
        {{ text }}
        <template v-slot:action="{ attrs }">
            <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbar = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>
        <v-snackbar v-model="snackbarBadValue">
        {{ textBadValue }}
        <template v-slot:action="{ attrs }">
            <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbarBadValue = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>
        </div>
        <v-dialog v-model="loading" fullscreen full-width no-click-animation>
        <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
            <v-layout justify-center align-center>
                <v-progress-circular
                    indeterminate
                    color="primary">
                </v-progress-circular>
            </v-layout>
        </v-container>
        </v-dialog>
    </v-app>
</template>

<script>
  export default {
    data () {
      return {
            dialog: false,
            search: '',
            items: [],
            actualFaction : '',
            headers: [
                { text: 'Booster', value: 'booster'},
                { text: 'Previous Balance', value: 'pre_balance', filterable: false },
                { text: 'Pending', value: 'pending', filterable: false },
                { text: 'Paid', value: 'paid', filterable: false },
                { text: 'Actions', value: 'actions', filterable: false },
            ],
            snackbar: false,
            text: `There was an error in your input. Please, recheck it or contact a Developer.`,
            snackbarBadValue: false,
            loading: false,
            textBadValue: `The amount of payment is over the amount he needs to get paid. Please, recheck it or contact a Developer.`,
        }
    },

    methods: {
        showPayments(faction) {
            axios
            .get('/payments/' + faction)
            .then ((response) => {
                this.items = response.data
                this.actualFaction = faction;
            })
            .catch(error => console.log(error));
        },
        sendPayment(item) {
            this.loading = true;
            //if (item.pre_balance >= item.paying) {
                axios
                .post('/payments/save', {
                    item: item,
                })
                .then ((response) => {
                    console.log(response)
                    this.loading = false;
                    if (response.data == 'wrongvalue') {
                        this.snackbar = true;
                    } else {
                        this.showPayments(this.actualFaction);
                    }
                })
                .catch(function (error) {
                    this.loading = false;
                    console.log(error);
                });
            // } else {
            //     this.snackbarBadValue = true;
            // }
        },
    },


    beforeMount () {
        this.showPayments('all');
    }
  }
</script>
