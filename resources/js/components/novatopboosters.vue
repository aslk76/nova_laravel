<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
    <div style="text-align: center">
        <v-btn
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
    </div>
    <v-select class="weekSelector blackComponent"
        v-model="selectedWeek"
        :items="weeks"
        item-text="week"
        item-value="id"
        label="Week"
        single-line
        return-object
    ></v-select>
    <v-data-table
        :headers="headers"
        :items="items"
        :items-per-page="10"
        class="elevation-1 vueTable"
    ></v-data-table>
    </div>
</v-app>
</template>

<script>
  export default {
    data () {
      return {
            items: [],
            weeks: [
                { id: 1, week: "This week"},
                { id: 2, week: "Last week"},
            ],
            selectedWeek: {id: 1, week: "This week"},
            headers:  [
              { text: 'Name', value: 'name', filterable: false },
              { text: 'Balance', value: 'balance', filterable: false },
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
    },
    created () {
        this.showHordeBoosters();
    }
  }
</script>
