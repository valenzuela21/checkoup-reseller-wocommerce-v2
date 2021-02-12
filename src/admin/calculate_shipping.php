<?php

if ( ! defined( 'ABSPATH' ) ) exit;
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    function your_shipping_method_init()
    {
        if (!class_exists('WC_Your_Shipping_Method')) {
            class WC_Your_Shipping_Method extends WC_Shipping_Method
            {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct()
                {
                    $xbox = Xbox::get('config-address');
                    $title = $xbox->get_field_value('_address_title_send');
                    $active = $xbox->get_field_value(' _active_complement');
                    $this->id = 'config-address-payment-wp'; // Id for your shipping method. Should be uunique.
                    $this->method_title = __('Envio Personalizado', 'geolocation-km');  // Title shown in admin
                    $this->method_description = __('Hola!, Deseas que este componente ralicé el costo del envio. Si aceptas dale guardar o salvar cambios.', 'geolocation-km'); // Description shown in admin

                    $active == "on" ? $state = "yes" : $state = "";

                    $this->enabled = "yes"; // This can be added as an setting but for this example its forced enabled
                    $this->title = $title; // This can be added as an setting but for this example its forced.

                    $this->init();
                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init()
                {
                    // Load the settings API
                    $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                    $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
                    // Save settings in admin if you have any defined
                    add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
                }


                /**
                 * calculate_shipping function.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */

                public function calculate_shipping($package = array())
                {
                    $pressing = WC()->session->get( 'pressing_send_wc');
                    $rate = array(
                        'label' => $this->title,
                        'cost' =>$pressing,
                        'calc_tax' => 'per_item'
                    );

                    // Register the rate
                    $this->add_rate($rate);
                }

            }
        }
    }

    add_action('woocommerce_shipping_init', 'your_shipping_method_init');

    function add_your_shipping_method($methods)
    {
        $methods['payment-shopping-send'] = 'WC_Your_Shipping_Method';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'add_your_shipping_method');
}
