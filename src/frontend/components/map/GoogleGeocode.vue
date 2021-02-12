<template>
    <section class="row">
        <div class="col-6 p-2">
            <b-field>
                <b-input placeholder="Dirección"
                         type="text"
                         icon="map-marker"
                         class="input-text-address"
                         v-model="address"
                         :disabled="disabled"
                >
                </b-input>
            </b-field>
        </div>
        <div class="col-6 p-2">
            <b-field>
                <b-select v-model="city"
                          icon="map"
                          :disabled="disabled"
                          expanded>
                    <option value="" >Seleccione la ciudad</option>
                    <option v-for="item in selectinfo" :value="item.city" >{{item.city}}</option>

                </b-select>
            </b-field>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    import {paramsMap} from "@/../assets/js/script_params";

    export default {
        name: "GoogleGeocode",
        data(){
            return{
                selectinfo: [],
            }
        },

        async mounted(){
            const {urlcity} = paramsMap
            const resp = await axios.get(urlcity);
            this.selectinfo = resp.data;
        },

        computed: {
            address:{
                get()
                {
                    return this.$store.state.address
                },
                set(value)
                {
                    this.$store.commit('GET_ADDRESS', value)
                }
            },
            city:{
                get(){
                    return this.$store.state.city
                },
                set(value){
                    this.$store.commit('GET_CITY', value)
                }
            },
            disabled:{
                get(){
                    return this.$store.state.disable
                }
            }
        },
    }

</script>

<style lang="scss">
    @import "./../../app.scss";
</style>