<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
        <!-- <div style="text-align: center">
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
        </div> -->
        <div class="row justify-content-center">
            <table class="table table-bordered table-dark table-custom" style="width: 39%; text-align: center; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in itemsTotal">
                        <td>{{item.Total}}</td>
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
                            <td>{{item.name}}</td>
                            <td>{{item.Sales}}</td>
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
                            <td>{{item.name}}</td>
                            <td>{{item.Earns}}</td>
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
        }
    },

    methods: {
        getSales() {
            axios
            .get('/getSales')
            .then ((response) => {
                this.itemsSales = response.data
            })
            .catch(error => console.log(error))
        },

        getEarns() {
            axios
            .get('/getEarns')
            .then ((response) => {
                this.itemsEarns = response.data
            })
            .catch(error => console.log(error))
        },


        getTotal() {
            axios
            .get('/getTotal')
            .then ((response) => {
                console.log(response.data[0])
                this.itemsTotal = response.data
            })
            .catch(error => console.log(error))
        },
    },

    created () {
        this.getSales();
        this.getEarns();
        this.getTotal();
    }
  }
</script>
