<?php
if (!defined('XBOX_HIDE_DEMO')) {
    define('XBOX_HIDE_DEMO', true);
}


class adminCity
{

    public function __construct()
    {
        add_action('xbox_init', [$this, 'admin_page_config_city']);
    }


    public function admin_page_config_city()
    {

        $options = array(
            'id' => 'city_options_config', //It will be used as "option_name" key to save the data in the wp_options table
            'title' => __('Configuración Ciudades', 'textdomain'),
            'menu_title' => __('Config Ciudades', 'textdomain'),
            'position' => 30,
        );

        $xbox = xbox_new_admin_page($options);

        $group = $xbox->add_group(array(
            'name' => __('Opciones', 'textdomain'),
            'id' => 'playlist',
            'options' => array(
                'add_item_text' => __('Nuevo Ciudad', 'textdomain'),
                'remove_item_text' => '',
                'sortable' => true
            ),
            'controls' => array(
                'name' => '#',
                'readonly_name' => false, //Determines whether the control input will be editable. Default: true
                'right_actions'  => array( //Buttons on the right of the control.
                    'xbox-duplicate-group-item' => '<i class="dashicons dashicons-admin-page"></i>',
                    'xbox-remove-group-item' => '<i class="xbox-icon xbox-icon-trash"></i>'
                ),
            )
        ));

        $group->add_field(array(
            'id' => 'city',
            'name' => __('Ciudad', 'textdomain'),
            'type' => 'text',
        ));


    }


}
new adminCity();
