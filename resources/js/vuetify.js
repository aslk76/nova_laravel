
import Vue from 'vue'
import Vuetify from 'vuetify'

// import 'material-design-icons-iconfont/dist/material-design-icons.css'
// import 'vuetify/dist/vuetify.min.css'
// import '../../sass/vuetifyAddOn.scss'
// import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        dark: true,
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                background: '#e4e6ee', // Not automatically applied
                primary: {
                    base: '#005da9',
                    lighten1: '#308AC6',
                    lighten2: '#EFF6FB',
                    darken1: '#045DA5',
                    darken2: '#00448B',
                    darken3: '#002E73',
                },
            },
            dark: {
                primary: {
                    base: '#005da9',
                    lighten1: '#308AC6',
                    lighten2: '#EFF6FB',
                    darken1: '#045DA5',
                    darken2: '#00448B',
                    darken3: '#00448B',
                },
            }
        }
    }
})
