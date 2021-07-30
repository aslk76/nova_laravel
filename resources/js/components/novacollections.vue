<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div>
        <v-data-table
            :headers="headers"
            :items="filteredItems"
            :items-per-page="5"
            class="elevation-1 vueTable"
        >
        <template v-slot:item.amount="{ item }">
             {{item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
        </template>
        <template v-slot:header.collector="{header}">
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
                    <v-text-field v-model="collectorName"
                    class="pa-4"
                    type="text"
                    label="Enter the collector name"
                    ></v-text-field>
                    <v-btn @click="collectorName = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        <template v-slot:header.trialadv="{header}">
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
                    <v-text-field v-model="trialAdvertiser"
                    class="pa-4"
                    type="text"
                    label="Enter the trial advertiser"
                    ></v-text-field>
                    <v-btn @click="trialAdvertiser = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        <template v-slot:header.date_collected="{header}">
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
                    <v-text-field v-model="dateCollected"
                    class="pa-4"
                    type="text"
                    label="Enter the date when it was collected"
                    ></v-text-field>
                    <v-btn @click="dateCollected = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        <template v-slot:header.collection_id="{header}">
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
                    <v-text-field v-model="collectionId"
                    class="pa-4"
                    type="text"
                    label="Enter the collection id"
                    ></v-text-field>
                    <v-btn @click="collectionId = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        </v-data-table>
    </div>
</v-app>
</template>

<script>
  export default {
    data () {
      return {
            search: '',
            collectorName: '',
            trialAdvertiser: '',
            dateCollected: '',
            collectionId: '',
            items: [],
            headers:  [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Collection ID', value: 'collection_id', filterable: false },
              { text: 'Date Collected', value: 'date_collected', filterable: false },
              { text: 'Collector', value: 'collector', filterable: false },
              { text: 'Trial Advertiser', value: 'trialadv' },
              { text: 'Realm', value: 'realm', filterable: false },
              { text: 'Amount', value: 'amount', filterable: false },
            ],
      }
    },

    methods: {
        getItems() {
            axios
            .get('/getCollections', { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"collection_id":(\d+),/g, '"collection_id":"$1",'))
                console.log(parsed)
                this.items = parsed
            })
            .catch(error => console.log(error))
        },
        filterCollector(item) {
            return item.author.toLowerCase().includes(this.collectorName.toLowerCase());
        },
        filterTrial(item) {
            return item.command.toLowerCase().includes(this.trialAdvertiser.toLowerCase());
        },
        filterDateCollected(item) {
            return item.name.toLowerCase().includes(this.dateCollected.toLowerCase());
        },
        filterCollectionId(item) {
            return item.operation_id.toLowerCase().includes(this.collectionId.toLowerCase());
        },
    },
    computed: {
        filteredItems() {
            let conditions = [];
            if (this.collectorName) {
                conditions.push(this.filterCollector);
            }

            if (this.trialAdvertiser) {
                conditions.push(this.filterTrial);
            }

            if (this.dateCollected) {
                conditions.push(this.filterDateCollected);
            }

            if (this.collectionId) {
                conditions.push(this.filterCollectionId);
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
