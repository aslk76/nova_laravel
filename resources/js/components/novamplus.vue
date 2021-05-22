<template>
<v-app :dark="true">
    <div>
        <div style="text-align: center">
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color: red; font-size: 10px;"
                @click="showHordeRuns()"
            >HORDE</v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                text
                tile
                style="color:blue; font-size: 10px;"
                @click="showAllianceRuns()"
            >ALLIANCE</v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color:black; font-size: 10px;"
                @click="getItems()"
            >ALL</v-btn>
            </div>
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Boost Realm"
            single-line
            hide-details
        ></v-text-field>
        </v-card-title>
        <!-- TODO: BE ABLE TO EDIT TABLE -->
        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="5"
            :search="search"
            class="elevation-1"
            @click:row="showDialog"
        >
        <template v-slot:item.collected="{ item }">
            <v-simple-checkbox
            v-model="item.collected"
            enabled
            @click="onCheckboxClicked(item.id, item.collected)"
            ></v-simple-checkbox>
        </template>
        </v-data-table>
        <template>
        <v-dialog v-model="dialog">
            <v-card>
            <v-data-table
                :headers="headersFromDialog"
                :items="itemsFromDialog"
                :items-per-page="1"
                :search="search"
                class="elevation-1"
            ></v-data-table>
            </v-card>
        </v-dialog>
        </template>
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
          itemsFromDialog: [],
          headersFromDialog:  [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Boost Faction', value: 'boost_faction', filterable: false },
              { text: 'Boost ID', value: 'boost_id', filterable: false },
              { text: 'Boost Date', value: 'boost_date', filterable: false },
              { text: 'Boost Realm', value: 'boost_realm' },
              { text: 'Boost Pot', value: 'boost_pot', filterable: false },
              { text: 'Adv Name', value: 'adv_name', filterable: false },
              { text: 'Adv Realm', value: 'adv_realm', filterable: false },
              { text: 'Adv Cut', value: 'adv_cut', filterable: false },
              { text: 'Tank Name', value: 'tank_name', filterable: false },
              { text: 'Tank Realm', value: 'tank_realm', filterable: false },
              { text: 'Tank Cut', value: 'tank_cut', filterable: false },
              { text: 'Healer Name', value: 'healer_name', filterable: false },
              { text: 'Healer Realm', value: 'healer_realm', filterable: false },
              { text: 'Healer Cut', value: 'healer_cut', filterable: false },
              { text: 'DPS1 Name', value: 'dps1_name', filterable: false },
              { text: 'DPS1 Realm', value: 'dps1_realm', filterable: false },
              { text: 'DPS1 Cut', value: 'dps1_cut', filterable: false },
              { text: 'DPS2 Cut', value: 'dps2_name', filterable: false },
              { text: 'DPS2 Realm', value: 'dps2_realm', filterable: false },
              { text: 'DPS2 Cut', value: 'dps2_cut', filterable: false },
            //   { text: 'Collected', value: 'collected', filterable: false },
            //   { text: 'Edited', value: 'edited_at', filterable: false },
          ],
          headers: [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Boost Faction', value: 'boost_faction', filterable: false },
              { text: 'Boost ID', value: 'boost_id', filterable: false },
              { text: 'Boost Date', value: 'boost_date', filterable: false },
              { text: 'Boost Realm', value: 'boost_realm' },
              { text: 'Boost Pot', value: 'boost_pot', filterable: false },
              { text: 'Adv Name', value: 'adv_name', filterable: false },
            //   { text: 'Adv Realm', value: 'adv_realm', filterable: false },

            //   { text: 'Adv Cut', value: 'adv_cut', filterable: false },
            //   { text: 'Tank Name', value: 'tank_name', filterable: false },
            //   { text: 'Tank Realm', value: 'tank_realm', filterable: false },
            //   { text: 'Tank Cut', value: 'tank_cut', filterable: false },
            //   { text: 'Healer Name', value: 'healer_name', filterable: false },
            //   { text: 'Healer Realm', value: 'healer_realm', filterable: false },
            //   { text: 'Healer Cut', value: 'healer_cut', filterable: false },
            //   { text: 'DPS1 Name', value: 'dps1_name', filterable: false },
            //   { text: 'DPS1 Realm', value: 'dps1_realm', filterable: false },
            //   { text: 'DPS1 Cut', value: 'dps1_cut', filterable: false },
            //   { text: 'DPS2 Cut', value: 'dps2_name', filterable: false },
            //   { text: 'DPS2 Realm', value: 'dps2_realm', filterable: false },
            //   { text: 'DPS2 Cut', value: 'dps2_cut', filterable: false },
              { text: 'Collected', value: 'collected', filterable: false },
            //   { text: 'Edited', value: 'edited_at', filterable: false },


          ],
      }
    },

    methods: {
        getItems() {
            axios
            .get('/getAll')
            .then ((response) => {
                this.items = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        },
        onCheckboxClicked(id, status) {
            axios
            .post('/changeCheckbox', {
                id: id,
                status: status
            })
            .then ((response) => {
                console.log(response)
            })
            .catch(error => console.log(error))
        },
        showAllianceRuns() {
            axios
            .get('/getAllAllianceRuns')
            .then ((response) => {
                this.items = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        },
        showHordeRuns() {
            axios
            .get('/getAllHordeRuns')
            .then ((response) => {
                this.items = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
        },

        showDialog(row) {
            axios
            .get('/getSpecificRun/' + row.id)
            .then ((response) => {
                this.itemsFromDialog = response.data
                console.log(response.data)
            })
            .catch(error => console.log(error))
            this.dialog = true;
        },

    },

    created () {
        this.getItems();
    }
  }
</script>
