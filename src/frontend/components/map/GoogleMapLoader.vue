<template>
    <div class="row">
        <div
                class="google-map col-12"
                ref="googleMap"
        ></div>
        <div v-if="total_km != null && total_km != 'NaN'" class="container-sidebar-map">
            <div class="row">
                <div class="col-xs-12 col-sm-4 p-2">
                    <p><span class="icon-pointers-map">A:</span> Yo |
                        <span class="icon-pointers-map">B:</span> Tienda</p>
                    <p>Distancia: {{total_km}} Km</p>
                    <p v-if="freestate != true">Costo de envio: ${{total_result}}</p>
                    <p v-else> Servicio Gratis </p>
                </div>
                <div class="col-xs-12 col-sm-8 p-2">
                    <div class="row">
                        <div class="col-6">
                            <b-button @click="closeCancel" class="btn-submit-map-cancel">Cancelar</b-button>
                        </div>
                        <div class="col-6">
                            <b-button @click="confirmAddress" class="btn-submit-map">Confirmar</b-button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div v-if="!submit" class="col-12">
            <b-button @click="startCalculate" class="btn-submit-map-send">Calcular Envio</b-button>
        </div>
        <a class="btn-back-cart" :href="urlCart">Volver</a>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import GoogleMapsApiLoader from "google-maps-api-loader";
    import {paramsMap} from "@/../assets/js/script_params";
    import $ from 'jquery';


    export default {
        props: {
            mapConfig: Object,
            apiKey: String,
            submit: false
        },

        data() {
            return {
                google: null,
                map: null,
                total_km: null,
                total_result: null,
                freestate: false,
                coorclient: '',
                coorreseller: '',
            };
        },

        async mounted() {
            const googleMapApi = await GoogleMapsApiLoader({
                apiKey: this.apiKey
            });
            this.google = googleMapApi;
            this.initializeMap();
        },

        methods: {
            initializeMap() {
                const {lat, lng, zoom} = paramsMap;
                const mapContainer = this.$refs.googleMap;
                this.map = new this.google.maps.Map(mapContainer, {
                    zoom: Number(zoom),
                    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
                    zoomControl: true,
                    zoomControlOptions: {
                        position: this.google.maps.ControlPosition.RIGHT_CENTER,
                    },
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false

                });
            },

            startCalculate() {
                this.submit = true;
                this.initializeMap();
                this.$store.commit('GET_DISABLE', true);
                const geocoder = new this.google.maps.Geocoder();
                this.geocodeAddress(geocoder, this.map);
            },

            geocodeAddress(geocoder, resultsMap) {
                const {lat2, lng2, free, pressingmin, pressingmax, distancemax} = paramsMap;
                const txtAddress = `${this.address} ${this.city}`;
                geocoder.geocode({address: txtAddress}, (results, status) => {
                    if (status === "OK") {
                        const directionsRenderer = new this.google.maps.DirectionsRenderer();
                        const directionsService = new this.google.maps.DirectionsService();
                        const coord_client_lat = results[0].geometry.location.lat();
                        const coord_client_lng = results[0].geometry.location.lng();
                        const latLng = [coord_client_lat, coord_client_lng];
                        const latLng2 = [parseFloat(lat2), parseFloat(lng2)];
                        this.calculateDistance(coord_client_lat, coord_client_lng, parseFloat(lat2), parseFloat(lng2), free, pressingmin, pressingmax, distancemax)
                        directionsRenderer.setMap(this.map);
                        this.calculateAndDisplayRoute(directionsService, directionsRenderer, latLng, latLng2);
                        this.coorclient = latLng;
                        this.coorreseller = latLng2;
                    } else {
                        alert("La dirección es erronea, por favor ingresa de nuevo.");
                        this.$store.commit('GET_DISABLE', false);
                        this.submit = false;
                    }
                })
            },

            calculateAndDisplayRoute(directionsService, directionsRenderer, latLng, latLng2) {
                const selectedMode = "DRIVING";

                directionsService.route(
                    {
                        origin: {lat: latLng[0], lng: latLng[1]},
                        destination: {lat: latLng2[0], lng: latLng2[1]},

                        travelMode: this.google.maps.TravelMode[selectedMode],
                    },
                    (response, status) => {
                        if (status == "OK") {
                            directionsRenderer.setDirections(response);
                        } else {
                            alert("La dirección es erronea, por favor ingresa de nuevo.");
                            this.$store.commit('GET_DISABLE', false);
                            this.submit = false;
                        }
                    }
                );
            },

            calculateDistance(lat1, lon1, lat2, lon2, free, pressingmin, pressingmax, distancemax) {
                const rad = function (x) {
                    return x * Math.PI / 180;
                }

                let a, c, d;

                const R = 6378.137;//Radio de la tierra en km
                let dLat = rad(lat2 - lat1);
                let dLong = rad(lon2 - lon1);
                a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                d = R * c;

                this.total_km = Math.round(d);
                if (free != 'on') {
                    this.freestate = false;
                    if (distancemax >= Math.round(d)) {
                        this.total_result = pressingmin;
                    } else {
                        this.total_result = this.total_km * pressingmax;
                    }
                } else {
                    this.freestate = true;
                    this.total_result = 0;
                }
            },

            closeCancel() {
                this.initializeMap();
                this.submit = false;
                this.total_km = null;
                this.$store.commit('GET_ADDRESS', '');
                this.$store.commit('GET_CITY', '');
                this.$store.commit('GET_DISABLE', false);
            },

            confirmAddress() {

                this.$store.commit('GET_LOADER', true);

                let array_data = [this.coorclient, this.coorreseller, this.total_result]

                $.ajax({
                    type: "POST",
                    url: "./../wp-admin/admin-ajax.php",
                    data: {
                        action: 'wp_insert_pressing_shipping',
                        resp: array_data
                    },
                    success: (response) => {
                        $('body').trigger('update_checkout');
                        localStorage.setItem("city_info", this.$store.state.city);
                        localStorage.setItem("city_address", this.$store.state.address);
                        localStorage.setItem("modal_address", "true");
                        location.reload();
                    },
                    error: function (error) {
                        console.log(`Error ${error}`);
                    }

                })
            }

        },

        computed: {
            ...mapState(['address', 'city', 'loader']),

            urlCart: function () {
                const {urlcart} = paramsMap;
                return urlcart;
            }
        }
    };
</script>

<style scoped>
    .google-map {
        width: 100%;
        min-height: 100%;
    }
</style>
