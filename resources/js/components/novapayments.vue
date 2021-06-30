<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
        <v-select class="weekSelector blackComponent" style="top: 0; left: 0;"
                v-model="selectedWeek"
                :items="weeks"
                item-text="week"
                item-value="id"
                label="Week"
                single-line
                return-object
        ></v-select>
        <v-btn elevation="6" fab x-small tile text style="color:black; font-size: 10px; position: absolute; top: 15px; left: 160px;" @click="getAll()">
            <span class="material-icons">
                search
            </span>
        </v-btn>
        <div class="row justify-content-center">
            <table class="table table-bordered table-dark table-custom" style="width: 39%; text-align: center; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in itemsTotal">
                        <td>{{item.Total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="display: flex;">
            <div class="col-6 statisticsList">
                <table class="table table-striped table-bordered table-dark table-custom" style="width: 40%">
                    <thead>
                        <tr>
                            <th>REALM</th>
                            <th>SALES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in itemsSales">
                            <td>{{item.name.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                            <td>{{item.Sales.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6 statisticsList2">
                <table class="table table-striped table-bordered table-dark table-custom" style="width: 40%">
                    <thead>
                        <tr>
                            <th>REALM</th>
                            <th>EARNS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in itemsEarns">
                            <td>{{item.name.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                            <td>{{item.Earns.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</v-app>
</template>

<script>
  export default {
    data () {
      return {
            dialog: false,
            search: '',
            itemsSales: [],
            itemsEarns: [],
            itemsTotal: [],
            weeks: [
                { id: 1, week: "This week"},
                { id: 2, week: "Last week"},
            ],
            selectedWeek: {id: 1, week: "This week"},
        }
    },

    methods: {
        getSales() {
            axios
            .get('/getSales/' + this.selectedWeek.id)
            .then ((response) => {
                this.itemsSales = response.data
            })
            .catch(error => console.log(error))
        },

        getEarns() {
            axios
            .get('/getEarns/' + this.selectedWeek.id)
            .then ((response) => {
                this.itemsEarns = response.data
            })
            .catch(error => console.log(error))
        },


        getTotal() {
            axios
            .get('/getTotal/' + this.selectedWeek.id)
            .then ((response) => {
                console.log(response.data[0])
                this.itemsTotal = response.data
            })
            .catch(error => console.log(error))
        },
        getAll() {
            this.getSales();
            this.getEarns();
            this.getTotal();
        }
    },

    beforeMount () {
        this.getAll();
    }
  }
</script>
