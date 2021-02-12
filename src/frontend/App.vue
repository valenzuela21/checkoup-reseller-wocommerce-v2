<template>
    <section v-if="disableModal != 'true'" class="container-map-address">
        <div class="container-map">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <img :src="image_logo" alt="img-logo-map" class="img-logo-map"/>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <h2 class="title-map-center">Donde quieres que te entreguemos el pedido.</h2>
                </div>
            </div>
            <GoogleGeocode/>
            <TravelMap class="travel-map"/>
            <div  v-if="loader != false">
                <div class="lds-tiplle-container">
                <div class="lds-ripple"><div></div><div></div></div>
                    <p class="loader-text">Procesando...</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import GoogleGeocode from "./components/map/GoogleGeocode.vue";
    import TravelMap from "./components/TravelMap.vue";
    import {mapState} from 'vuex';
    import {paramsMap} from "@/../assets/js/script_params";

    export default {
        name: "App",
        components: {
            GoogleGeocode,
            TravelMap,
        },
        computed: {
            ...mapState(['address', 'city', 'loader']),
            disableModal() {
                return localStorage.getItem("modal_address");
            },

            image_logo(){
                return paramsMap.img;
            }

        }
    };
</script>

<style scoped>

</style>

