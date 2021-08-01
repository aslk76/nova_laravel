<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
    <div style="text-align: center">
        <!-- <v-btn
            elevation="6"
            fab
            large
            tile
            text
            style="color: red; font-size: 10px;"
            @click="showHordeBoosters()"
        >HORDE</v-btn>
        <v-btn
            elevation="6"
            fab
            large
            text
            tile
            style="color:blue; font-size: 10px;"
            @click="showAllianceBoosters()"
        >ALLIANCE</v-btn>
    </div> -->
    <v-select class="weekSelector blackComponent"
        v-model="selectedWeek"
        :items="weeks"
        item-text="week"
        item-value="id"
        label="Week"
        single-line
        return-object
    ></v-select>
    <v-divider></v-divider>
    <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Booster Name"
            single-line
            hide-details
            class="blackComponent"
        ></v-text-field>
    <v-data-table
        :headers="headers"
        :items="items"
        :items-per-page="10"
        :search="search"
        class="elevation-1 vueTable"
    >
    <template v-slot:item.balance="{ item }">
        {{item.balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
    </template>
    <v-text-field
            v-model="searchCount"
            append-icon="mdi-magnify"
            label="Search for Booster Name"
            single-line
            hide-details
            class="blackComponent"
        ></v-text-field>
    <v-data-table
        :headers="headersCount"
        :items="itemsCount"
        :items-per-page="10"
        :search="searchCount"
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
            items: [],
            itemsCount: [],
            search:'',
            searchCount:'',
            weeks: [
                { id: 1, week: "This week"},
                { id: 2, week: "Last week"},
            ],
            selectedWeek: {id: 1, week: "This week"},
            headers:  [
              { text: 'Name', value: 'name'},
              { text: 'Balance', value: 'balance', filterable: false },
            ],
            headersCount:  [
              { text: 'Name', value: 'name'},
              { text: 'This week', value: 'currweek', filterable: false },
              { text: 'Last week', value: 'lastweek', filterable: false },
              { text: 'Total', value: 'totalboost', filterable: false },
            ],
      }
    },

    methods: {
        showHordeBoosters() {
            axios
            .get('/topboosters/Horde/' + this.selectedWeek.id)
            .then ((response) => {
                console.log(response.data.balance);
                this.items = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        },
        showAllianceBoosters() {
            axios
            .get('/topboosters/Alliance/' + this.selectedWeek.id)
            .then ((response) => {
                this.items = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        },
        showCountBoosters() {
            axios
            .get('/topboosters/count')
            .then ((response) => {
                this.itemsCount = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        }
    },
    created () {
        this.showHordeBoosters();
        this.showCountBoosters();
    }
  }
</script>
