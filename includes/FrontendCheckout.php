<?php
namespace App;

use Xbox;

/**
 * Frontend Pages Handler
 */
class FrontendCheckout {

    public function __construct() {
        add_action('woocommerce_before_checkout_form',  [ $this,'render_frontend_checkout'], 10,1);
        add_action('wp_enqueue_scripts', [ $this,'param_script_frond'], 10, 1);

    }

    /**
     * Render frontend app
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_frontend_checkout( $atts, $content = '' ) {
        wp_enqueue_style( 'baseplugin-frontend-checkout' );
        wp_enqueue_style( 'baseplugin-frontend-checkout-vendors' );
        wp_enqueue_script( 'baseplugin-frontend-checkout' );


        $content = '<div id="frontend-checkout-map"></div>';

        echo $content;
    }


    public function param_script_frond(){

        if (is_checkout()) {
            global $woocommerce;
            wp_enqueue_script('checkout_js_frontend_first', plugins_url('../assets/js/checkout.js', __FILE__), array(), 1.0, true );
            wp_enqueue_script('script_map_checkout', plugins_url('../assets/js/script_params.js', __FILE__), array(), 1.0, true);
            $xbox = Xbox::get('config-address');
            $key_google = $xbox->get_field_value('_address_key_map');
            $latitude = $xbox->get_field_value('_address_coordenate_lat');
            $longitude = $xbox->get_field_value('_address_coordenate_lng');
            $zoom = $xbox->get_field_value('_address_zoom_map');
            $distance_max = $xbox->get_field_value('_address_max_distance');
            $img = $xbox->get_field_value('file-logo-map');

            //ID RESELLER
            $id_reseller = WC()->session->get('id_session');
            $send_free = get_post_meta($id_reseller, 'input_options_product_free', true);

            //COORDINATE RESELLER
            $lat2 = get_post_meta($id_reseller, 'input_options_product_latitud_reseller', true);
            $lng2 = get_post_meta($id_reseller, 'input_options_product_longitud_reseller', true);
            $pressing_min =  get_post_meta($id_reseller, 'input_options_product_pressing_fixed_tendero', true);
            $pressing_max =  get_post_meta($id_reseller, 'input_options_product_presing_send', true);

            wp_localize_script(
                'script_map_checkout',
                'object_map',
                array(
                    'key' => $key_google,
                    'zoom' => $zoom,
                    'lat' => $latitude,
                    'lng' => $longitude,
                    'lat2'=> $lat2,
                    'lng2'=> $lng2,
                    'free'=> $send_free,
                    'img' => $img,
                    'pressingmin'=> $pressing_min,
                    'pressingmax'=> $pressing_max,
                    'distancemax'=> $distance_max,
                    'urlcart'=>$woocommerce->cart->get_cart_url()
        )
            );

        }
    }


}
