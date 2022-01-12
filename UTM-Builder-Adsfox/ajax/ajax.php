<?php
if (!function_exists('mt_utmadfox_add')) {
   function mt_utmadfox_add(){



if(isset( $_POST['shorturl'])){

  if (!function_exists('ddt_recursive_esc_js')) {
      function ddt_recursive_esc_js($array) {
          echo json_encode($array);
          foreach ( $array as $key => &$value ) {
              if ( is_array( $value ) ) {

                  $value = ddt_recursive_esc_js($value);

              }
              else {
                foreach ($value as $key => $val) {
                    $val = esc_js($val);
                    }
              }
          }

          return $array;
      }
  }

       $shorturl = sanitize_url( $_POST['shorturl'] );
       $longurl = sanitize_url( $_POST['longurl'] );

       global $wpdb;
       $table_name = $wpdb->prefix . 'mt_utmadfox';
       if($wpdb->insert($table_name, array('shorturl' => $shorturl, 'longurl' => $longurl))){


             //get all urls for updating table
            $wpdb_prefix = $wpdb->prefix;
            $wpdb_tablename = $wpdb_prefix.'mt_utmadfox';
            $result = $wpdb->get_results(sprintf('SELECT * FROM '. $wpdb_tablename));
            echo json_encode($result);
            exit;



       }



}

   }
   add_action( 'wp_ajax_' . 'mt_utmadfox_add_activate', 'mt_utmadfox_add' );
   add_action( 'wp_ajax_nopriv_' . 'mt_utmadfox_add_activate', 'mt_utmadfox_add' );
}


if (!function_exists('mt_utmadfox_remove')) {
   function mt_utmadfox_remove(){

     if(isset( $_POST['shorturl'])){

       if (!function_exists('ddt_recursive_esc_js')) {
           function ddt_recursive_esc_js($array) {
               echo json_encode($array);
               foreach ( $array as $key => &$value ) {
                   if ( is_array( $value ) ) {

                       $value = ddt_recursive_esc_js($value);

                   }
                   else {
                     foreach ($value as $key => $val) {
                         $val = esc_js($val);
                         }
                   }
               }

               return $array;
           }
       }



         $shorturl = sanitize_url( $_POST['shorturl'] );
          global $wpdb;
          $wpdb_prefix = $wpdb->prefix;
          $wpdb_tablename = $wpdb_prefix.'mt_utmadfox';
          //delete table by short url
          $result = $wpdb->delete( $wpdb_tablename, array( 'shorturl' => $shorturl ));
          if($result == 1){
              //get all urls for updating table
             $wpdb_prefix = $wpdb->prefix;
             $wpdb_tablename = $wpdb_prefix.'mt_utmadfox';
             $result = $wpdb->get_results(sprintf('SELECT * FROM '. $wpdb_tablename));
             echo json_encode($result);
             exit;
           }
   }


   }
   add_action( 'wp_ajax_' . 'mt_utmadfox_remove_activate', 'mt_utmadfox_remove' );
   add_action( 'wp_ajax_nopriv_' . 'mt_utmadfox_remove_activate', 'mt_utmadfox_remove' );
}
