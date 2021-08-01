<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
            <!-- <v-select class="weekSelector blackComponent"
                v-model="selectedWeek"
                :items="weeks"
                item-text="week"
                item-value="id"
                label="Week"
                single-line
                return-object
            ></v-select> -->
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Realm"
            single-line
            hide-details
            class="blackComponent"
        ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="filteredItems"
            :items-per-page="5"
            :search="search"
            class="elevation-1 vueTable"
            @click:row="showDialog"
        >
        <template v-slot:item.amount="{ item }">
             {{item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
        </template>
        <template v-slot:item.collected="{ item }">
            <v-simple-checkbox
            v-model="item.collected"
            enabled
            @click="onCheckboxClicked(item, 'collected', item.collected)"
            ></v-simple-checkbox>
        </template>
        <template v-slot:item.missing="{ item }">
            <v-simple-checkbox
            v-model="item.missing"
            enabled
            @click="onCheckboxClicked(item, 'missing', item.missing)"
            ></v-simple-checkbox>
        </template>
        <template v-slot:header.date_import="{header}">
            <span>{{header.text}}</span>
            <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <span class="material-icons">
                            filter_alt
                        </span>
                    </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                    <v-text-field v-model="importDate"
                    class="pa-4"
                    type="text"
                    label="Enter a date"
                    ></v-text-field>
                    <v-btn @click="importDate = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        </v-data-table>
        <v-snackbar v-model="snackbarBadValue">
            {{ text }}
            <template v-slot:action="{ attrs }">
                <v-btn
                color="pink"
                text
                v-bind="attrs"
                @click="text = false"
                >
                Close
                </v-btn>
            </template>
        </v-snackbar>
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
            text: `There was an error, please, check if the server is off or ask Abufel.`,
            snackbarBadValue: false,
            boostDate: '',
            factions: ["Horde", "Alliance"],
            // weeks: [
            //     { id: 1, week: "This week"},
            //     { id: 2, week: "Last week"}
            // ],
            // selectedWeek: {id: 1, week: "This week"},
          headers: [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Import Date', value: 'import_date', filterable: false },
              { text: 'Advertiser Name', value: 'name', filterable: false },
              { text: 'Raid paid in', value: 'paidin' },
              { text: 'Amount', value: 'amount', filterable: false},
              { text: 'Collected', value: 'collected', filterable: false },
              { text: 'Missing', value: 'missing', filterable: false },
          ],
      }
    },

    methods: {
        getItems() {
            axios
            .get('/getArchiveRaids')
            .then ((response) => {
                this.items = response.data
            })
            .catch(this.snackbarError = true)
        },
        onCheckboxClicked(item, check, status) {
            axios
            .post('/changeCheckboxRaids', {
                id: item.id,
                check: check,
                status: status
            })
            .then ((response) => {
                console.log(response)
            })
            .catch(this.snackbarError = true)
            if ((check == 'collected') && (status == true)) {
                const index = this.items.indexOf(item)
                this.items.splice(index, 1)
            }
            if ((check == 'missing') && (status == true)) {
                const index = this.items.indexOf(item)
                this.items.splice(index, 1)
            }
        },
        filterDate(item) {
            return item.import_date.toLowerCase().includes(this.importDate.toLowerCase());
        },

    },
    computed: {
        filteredItems() {
            let conditions = [];

            if (this.boostDate) {
                conditions.push(this.filterDate);
            }

            if (conditions.length > 0) {
                return this.items.filter((item) => {
                    return conditions.every((condition) => {
                        return condition(item);
                    })
                })
            }
            return this.items;
        }
    },
    created () {
        this.getItems();
    }
  }
</script>
