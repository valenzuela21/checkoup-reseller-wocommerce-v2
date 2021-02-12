<?php

if( ! defined( 'XBOX_HIDE_DEMO' ) ){
    define( 'XBOX_HIDE_DEMO', true );
}
class adminCityAdress{

    public function __construct()
    {
        add_action( 'xbox_init', [$this, 'my_admin_page'], 10 ,20);
    }

    function my_admin_page(){
        $URL = get_site_url();
    
        $prefix = '_address';
    
        $options = array(
            'id' => 'config-address',
            'title' => 'Configuración Envio',
            'menu_title' => __( 'Config Envio', 'geolocation-km'  ),
            'position' => 30,
            'parent' => false,
            'capability' => 'manage_options',
        );
    
        $xbox = xbox_new_admin_page( $options );

        $xbox->add_field(array(
            'id' => 'file-logo-map',
            'name' => __( 'Imagen', 'geolocation-km' ),
            'type' => 'file',
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_title_send',
            'name' => __( 'Titulo', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'default' => 'Sistema De Envio Creatives',
            'desc' => __('Ingresa el titulo del metodo de envio.', 'geolocation-km'),
        ));
    
        
        $xbox->add_field(array(
            'id' => $prefix.'_max_distance',
            'name' => __( 'Distancia Máxima para envíos', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'default' => '10',
            'desc' => __('Ingrese la distancia máxima para envíos, el tipo de distancia (Km, Millas etc) se tomará del campo configurado anteriormente.', 'geolocation-km'),
        ));
    
    
        $xbox->add_field(array(
            'id' => $prefix.'_active_complement',
            'name' => __( 'Activar Complemento', 'geolocation-km' ),
            'type' => 'switcher',
            'default' => 'on',
            'desc' => __('Por defecto esta activo, pero si tienes algún inconveniente lo puedes desactivar.', 'geolocation-km'),
        ));
    
    
        $xbox->add_field(array(
            'id' => $prefix.'_coordenate_lat',
            'name' => __( 'Latitud', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'default' => '4.6989323',
            'desc' => __('Ingresa la dirección latitud para el mapa.', 'geolocation-km'),
        ));
    
        $xbox->add_field(array(
            'id' => $prefix.'_coordenate_lng',
            'name' => __( 'Longitud', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'default' => '-74.0797927',
            'desc' => __('Ingresa la dirección longitud para el mapa.', 'geolocation-km'),
        ));
    
        $xbox->add_field(array(
            'id' => $prefix.'_zoom_map',
            'name' => __( 'Zoom Map', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'default' => '14',
    
        ));
    
        $xbox->add_field(array(
            'id' => $prefix.'_key_map',
            'name' => __( 'Google maps API Key', 'geolocation-km' ),
            'type' => 'text',
            'grid' => '1-of-12',
            'default' => '',
            'desc' => __('Ingresa la llave o API KEY de Google maps.', 'geolocation-km'),
        ));
    
        $xbox->add_field(array(
            'id' => 'custom-html',
            'name' => __( 'Woocommerce', 'geolocation-km' ),
            'type' => 'html',
            'content' => '<ul>
                            <li>Ingresa ha esta Opción o Tab de <a target="_blank" href="'.$URL.'/wp-admin/admin.php?page=wc-settings&tab=shipping&section=config-address-payment-wp">Envio Personalizado</a>  y le das guardar cambios. </li>
                            <li>La configuración de este componente recomendable que lo tengas encuenta, con estás opciones  como lo muestra la siguiente imagen.
                            <a target="_blank" href="'.$URL.'/wp-admin/admin.php?page=wc-settings&tab=shipping&section=options">Ajustes Generales Envio</a> 
                            </li>
                        </ul>
                        <img src="'.plugins_url('image_config.png', __FILE__).'" style="width: 100%"/>
                        <p><strong>Nota: </strong>Tener encuenta la activación del Ajax para que refresque el campo del costo de envio.</p>
                        <img src="'.plugins_url('image_config_2.png', __FILE__).'" style="width: 100%"/>
                        <p>¡Gracias!</p>
            
            ',
        ));
    
    
    }
}
new adminCityAdress();
