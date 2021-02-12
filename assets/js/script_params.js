export const paramsMap = {
    key: object_map.key,
    zoom: object_map.zoom,
    lat: object_map.lat,
    lng: object_map.lng,
    lat2: object_map.lat2,
    lng2: object_map.lng2,
    pressingmin: object_map.pressingmin,
    pressingmax: object_map.pressingmax,
    free: object_map.free,
    img: object_map.img,
    distancemax: object_map.distancemax,
    urlcart: object_map.urlcart,
    urlcity: developer(),
}

function developer() {

    const URL = window.location.hostname;
    const SLL = window.location.protocol;

    if(URL === 'localhost'){
        return `${SLL}//${URL}:3000/wordpress/wp-content/plugins/woocommerce-address-geolocalization-km/src/frontend/Api/city.php`;
    }else{
        return `${SLL}//${URL}/wp-content/plugins/woocommerce-address-geolocalization-km/src/frontend/Api/city.php`;
    }

}
