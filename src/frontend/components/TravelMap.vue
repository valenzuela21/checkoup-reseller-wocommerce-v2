<template>
    <GoogleMapLoader
            :apiKey="keyGoogle"
    />

</template>

<script>
    import GoogleMapLoader from "./map/GoogleMapLoader.vue";
    import {paramsMap} from "@/../assets/js/script_params";
    export default {
        components: {
            GoogleMapLoader,
        },

        computed:{
            keyGoogle: function () {
                const {key} = paramsMap;
                return key
            }
        }
    };
</script>
