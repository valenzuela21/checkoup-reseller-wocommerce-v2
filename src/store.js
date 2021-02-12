import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        address: '',
        city: '',
        disable: false,
        loader: false,
    },
    mutations: {
        GET_ADDRESS (state, data){
            state.address = data
        },
        GET_CITY(state, data){
            state.city = data
        },
        GET_DISABLE(state, data){
            state.disable = data
        },
        GET_LOADER(sate, data){
            sate.loader = data
        }

    },
    actions:{

    }
})
export default  store