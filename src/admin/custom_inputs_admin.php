<?php

class inputCustom{

    function __construct()
    {
        add_action( 'woocommerce_admin_order_data_after_shipping_address', array($this,'my_custom_checkout_field_display_admin_order_meta'), 10, 1 );
        add_action( "woocommerce_email_customer_details", array($this,"custom_woocommerce_email_after_order_table"), 10, 1);
        add_action( 'woocommerce_thankyou', array($this,'custom_thank_page_address'), 5, 30 );
        add_action('woocommerce_after_checkout_billing_form', array($this, 'button_change_field_address'), 20);
        add_action('wp_ajax_nopriv_wp_insert_pressing_shipping', [$this, 'wp_insert_pressing_shipping'], 10, 1);
        add_action('wp_ajax_wp_insert_pressing_shipping', [$this,'wp_insert_pressing_shipping'], 10, 1);
        add_filter('woocommerce_billing_fields', array($this, 'wpb_custom_billing_fields'), 5, 5);
        add_filter('woocommerce_default_address_fields', array($this, 'wp_add_field_input'), 25);
    }

    public function my_custom_checkout_field_display_admin_order_meta(){
        global $post_id;
        $order = new WC_Order( $post_id );

        echo '<p><strong>'.__('Dirección Envio:', 'geolocation-km').'</strong> ' . get_post_meta($order->get_id(), '_billing_address', true ) . '</p>';
		
		 echo '<p><strong>'.__('Ciudad:', 'geolocation-km').'</strong> ' . get_post_meta($order->get_id(), 'billing_shipping_city', true ) . '</p>';
		
		
		
    }

    public function custom_woocommerce_email_after_order_table( $order ) {

        echo '
            <h2>'.__('Detalles Envio','geolocation-km').'</h2>
            <p><strong>'.__('Dirección: ','geolocation-km').'</strong>'. get_post_meta( $order->id, '_billing_address', true ) .'</p>
            ';

    }


    function custom_thank_page_address($order) {
        echo "<p>Dirección de envio: ".get_post_meta( $order, '_billing_address', true ) ." </p>";
    }


    public function wp_insert_pressing_shipping() {

        if(isset( $_POST['resp'] ) ) {
            $request = $_POST['resp'];
        }
        $lngclient = $request[0];

        WC()->session->set( 'coordenate_map', [$lngclient[0] , $lngclient[1]]);
        WC()->session->set( 'pressing_send_wc', $request[2] );

    }

    public function wpb_custom_billing_fields($fields)
    {
        unset($fields['billing_address_2']);
        unset($fields['billing_address_1']);
        unset($fields['shipping_address_1']);
        unset($fields['shipping_address_2']);
        unset($fields['billing_state']);
        unset($fields['shipping_state']);
        unset($fields['billing_postcode']);
        return $fields;
    }


    public function wp_add_field_input($fields)
    {

        $fields['address']  = array(
            'label'        => __('Dirección: ', 'geolocation-km'),
            'required'     => true,
            'class'        => array('input-text', 'custom-text-class form-row-wide'),
            'priority'     => 230,
            'placeholder'  => __('', 'geolocation-km'),
        );

        return $fields;
    }

    public function button_change_field_address()
    {
        echo "<button type='button' style='margin: 10px 0px;' class='button alt' id='change_address' >".__('Cambiar Dirección', 'geolocation-km')."</button>";
    }


}
new inputCustom();
