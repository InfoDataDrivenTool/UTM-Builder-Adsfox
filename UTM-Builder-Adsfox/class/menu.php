<?php
class MT_EB_utmadfox {



    public static function init() {

       add_action( 'admin_menu', array( __CLASS__, 'adminMenu' ) );


    }

    public static function adminMenu() {
        add_menu_page(
            __( 'UTM - adsfox', 'mt-utmadfox-dashboard' ),
            __( 'UTM Adsfox ', 'mt-utmadfox-dashboard' ),
            'manage_options',
            'mt-utmadfox-dashboard',
            array( __CLASS__, 'menuPage' ),
            'dashicons-chart-bar',
            6
        );

    }

    public static function menuPage() {

        if ( is_file( mt_utmadfox_root_include . 'options.php' ) ) {
            include_once mt_utmadfox_root_include . 'options.php';
        }
    }




}

MT_EB_utmadfox::init();
