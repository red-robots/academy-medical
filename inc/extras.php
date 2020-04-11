<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');
function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

function email_obfuscator($string) {
    $output = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                $replace = 'mailto:'.$em;
                $new_mailto = 'mailto:'.$encrypted;
                $string = str_replace($replace, $new_mailto, $string);
                $rep2 = $em.'</a>';
                $new2 = antispambot($em).'</a>';
                $string = str_replace($rep2, $new2, $string);
            }
        }
        $output = apply_filters('the_content',$string);
    }
    return $output;
}

function get_social_links() {
    $social_types = social_icons();
    $social = array();
    foreach($social_types as $k=>$icon) {
        $value = get_field($k,'option');
        if($value) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-f',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin-in',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'snapchat'  => 'fab fa-snapchat-ghost',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}

function get_images_from_website($imageURL) {
    $url_to_image = $imageURL;
    $dir = wp_get_upload_dir();
    $path = $dir['path'];
    $parts = explode("uploads/",$path);
    $uploadsDIR = $parts[0] . 'uploads/imports/';

    $ch = curl_init($url_to_image);
    $my_save_dir = $uploadsDIR;
    $filename = basename($url_to_image);
    $complete_save_loc = $my_save_dir . $filename;
    $fp = fopen($complete_save_loc, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return ( file_exists($complete_save_loc) ) ?  $complete_save_loc : '';
}

add_action( 'init', 'extractdata' );
function extractdata() {
   wp_register_script( "extractdata", get_stylesheet_directory_uri() . '/assets/js/extract.js', array('jquery') );
   wp_localize_script( 'extractdata', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'extractdata' );
}


add_action( 'wp_ajax_nopriv_extract_data_from_website', 'extract_data_from_website' );
add_action( 'wp_ajax_extract_data_from_website', 'extract_data_from_website' );
function extract_data_from_website() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $objects = ($_POST['objects']) ? $_POST['objects'] : '';
        $post_type = ($_POST['posttype']) ? $_POST['posttype'] : '';
        $imagesUploaded = array();
        $file_uploads = '';
        $file_info = array();
        if($objects) {
            foreach($objects as $obj) {
                $title = $obj['title'];
                $imageURL = $obj['image'];
                $path = get_images_from_website($imageURL);
                if($path) {
                    $imagesUploaded[] = $imageURL;
                    $file_uploads .= $imageURL.'<br>';
                    $name = basename($imageURL);
                    $filename = 'imports/' . $name;
                    $file_info[] = array(
                                'title'=>'',
                                'category'=>$title,
                                'image_url'=>$filename,
                                'filename'=>$name,
                                'website'=>''
                            );
                }
            }
        }

        if($file_info) {
            $json = json_encode($file_info,JSON_PRETTY_PRINT);
            $dir = wp_get_upload_dir();
            $path = $dir['path'];
            $parts = explode("uploads/",$path);
            $file = $parts[0] . 'uploads/imports/data.json';
            $myfile = fopen($file, "w") or die("Unable to open file!");
            $txt = $json;
            fwrite($myfile, $txt);
            fclose($myfile);
        }
        $response['uploaded'] = ($imagesUploaded) ? $imagesUploaded : '';
        $message = '';
        if($file_uploads) {
            $message = '<div class="alert alert-success">'.$file_uploads.'</div>';
        }
        $response['message'] = $message;
        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function search_attachment($filename) {
    global $wpdb;
    if(empty($filename)) return '';
    $parts = pathinfo($filename);
    $title =  trim($parts['filename']);
    $query = "SELECT * FROM {$wpdb->prefix}posts WHERE post_title='".$title."' AND post_type='attachment'";
    $result = $wpdb->get_row($query);
    return ($result) ? $result->ID : '';
}

function get_data_json_file() {
    $jsonfile = get_import_dir() . 'data.json';
    return $jsonfile;
}

function get_import_dir() {
    $dir = wp_get_upload_dir();
    $path = $dir['path'];
    $parts = explode("uploads/",$path);
    return $parts[0] . 'uploads/imports/';
}

function get_term_info($slug) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}terms WHERE slug='".$slug."'";
    $result = $wpdb->get_row($query);
    return ($result) ?  $result : '';
}

function assigned_term_to_post($post_id,$term_id) {
    global $wpdb;
    $relationships = $wpdb->prefix.'term_relationships';
    $ok = $wpdb->insert($relationships, array(
        'object_id' => $post_id,
        'term_taxonomy_id' => $term_id,
    ));
    return ($ok) ? $ok : '';
}

