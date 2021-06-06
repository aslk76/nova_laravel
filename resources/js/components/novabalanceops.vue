<template>
<v-app :dark="true">
    <div style="position: relative; width: 100%;">
        <v-select class="weekSelector" style="top: 0; left: 0;"
                v-model="selectedWeek"
                :items="weeks"
                item-text="week"
                item-value="id"
                label="Week"
                single-line
                return-object
        ></v-select>
        <v-btn elevation="6" fab x-small tile text style="color:black; font-size: 10px; position: absolute; top: 15px; left: 160px;" @click="getItems()">
            <span class="material-icons">
                search
            </span>
        </v-btn>
    </div>
    <div>
        <v-data-table
            :headers="headers"
            :items="filteredItems"
            :items-per-page="5"
            class="elevation-1"
        >
        <template v-slot:header.author="{header}">
            {{header.text}}
            <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <span class="material-icons">
                            filter_alt
                        </span>
                    </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                    <v-text-field v-model="authorName"
                    class="pa-4"
                    type="text"
                    label="Enter the author name"
                    ></v-text-field>
                    <v-btn @click="authorName = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        <template v-slot:header.command="{header}">
            {{header.text}}
            <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <span class="material-icons">
                            filter_alt
                        </span>
                    </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                    <v-text-field v-model="commandIssued"
                    class="pa-4"
                    type="text"
                    label="Enter the author name"
                    ></v-text-field>
                    <v-btn @click="commandIssued = ''"
                    small
                    text
                    color="primary"
                    class="ml-2 mb-2"
                    >Clear</v-btn>
                </div>
            </v-menu>
        </template>
        <template v-slot:header.name="{header}">
            {{header.text}}
            <v-menu offset-y :close-on-content-click="false">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <span class="material-icons">
                            filter_alt
                        </span>
                    </v-btn>
                </template>
                <div style="background-color: white; width: 280px">
                    <v-text-field v-model="responsibleName"
                    class="pa-4"
                    type="text"
                    label="Enter the author name"
                    ></v-text-field>
                    <v-btn @click="responsibleName = ''"
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
            authorName: '',
            commandIssued: '',
            responsibleName: '',
            items: [],
            weeks: [
                { id: 1, week: "All weeks"},
                { id: 2, week: "This week"},
                { id: 3, week: "Last week"},
                { id: 4, week: "Two weeks ago"},
            ],
            selectedWeek: {id: 1, week: "All weeks"},
            headers:  [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Operation ID', value: 'operation_id', filterable: false },
              { text: 'Date', value: 'date', filterable: false },
              { text: 'Author', value: 'author' },
              { text: 'Name', value: 'name' },
              { text: 'Realm', value: 'realm', filterable: false },
              { text: 'Operation', value: 'operation', filterable: false },
              { text: 'Command', value: 'command' },
              { text: 'Amount', value: 'amount', filterable: false },
              { text: 'Reason', value: 'reason', filterable: false },
            ],
      }
    },

    methods: {
        getItems() {
            axios
            .get('/getBalanceOps/' + this.selectedWeek.id, { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"operation_id":(\d+),/g, '"operation_id":"$1",'))
                console.log(parsed)
                this.items = parsed
            })
            .catch(error => console.log(error))
        },
        filterAuthor(item) {
            return item.author.toLowerCase().includes(this.authorName.toLowerCase());
        },
        filterCommand(item) {
            return item.command.toLowerCase().includes(this.commandIssued.toLowerCase());
        },
        filterName(item) {
            return item.name.toLowerCase().includes(this.responsibleName.toLowerCase());
        },
    },
    computed: {
        filteredItems() {
            let conditions = [];
            if (this.authorName) {
                conditions.push(this.filterAuthor);
            }

            if (this.commandIssued) {
                conditions.push(this.filterCommand);
            }

            if (this.responsibleName) {
                conditions.push(this.filterName);
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
