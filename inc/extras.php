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
    $social_types = array(
        'facebook'  => 'fab fa-facebook-square',
        'twitter'   => 'fab fa-twitter-square',
        'instagram' => 'fab fa-instagram',
        'snapchat'  => 'fab fa-snapchat-ghost',
        'youtube'   => 'fab fa-youtube'
    );
    $social = array();
    foreach($social_types as $k=>$icon) {
        $value = get_field($k,'option');
        if($value) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}


function custom_meta_post_visibility_box($object) {
    wp_nonce_field(basename(__FILE__), "custom_meta_post_visibility-nonce");
    $display_post = get_post_meta($object->ID, "custom_meta_post_visibility", true);
    $selected = ($display_post==1) ? 1 : 0;
    $screen = get_current_screen();
    $action = ( isset($screen->action) && $screen->action=='add' ) ? 'add':'edit';
    $is_selected = ($display_post==1) ? ' checked':'';
    ?>
    <div class="components-panel__row">
        <div class="components-base-control">
            <div class="components-base-control__field">
                <label for="meta_display_post<?php echo $val; ?>" class="components-checkbox-control__input-container">
                    <span class="inputlabel">Display post to front page.</span>
                    <input type="checkbox" id="meta_display_post1" name="custom_meta_post_visibility" class="components-checkbox-control__input cmeta_display_post meta_display_post1" value="1"<?php echo $is_selected?>>
                    <i class="chxboxstat"></i>
                </label>
            </div>
        </div>
    </div>
    <?php  
}

function add_custom_meta_box() {
    add_meta_box("display-post-meta-box", "Post Visibility", "custom_meta_post_visibility_box", "post", "side", "high", null);
}
add_action("add_meta_boxes", "add_custom_meta_box");

function save_custom_meta_post_visibility_box($post_id, $post, $update) {
    if (!isset($_POST["custom_meta_post_visibility-nonce"]) || !wp_verify_nonce($_POST["custom_meta_post_visibility-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->post_type)
        return $post_id;

    $post_visibility = "";
    if(isset($_POST["custom_meta_post_visibility"]))
    {
        $post_visibility = $_POST["custom_meta_post_visibility"];
    }   
    update_post_meta($post_id, "custom_meta_post_visibility", $post_visibility);
}
add_action("save_post", "save_custom_meta_post_visibility_box", 10, 3);

function jupload_scripts() { 
$screen = get_current_screen();
$is_post = ( isset($screen->base) && $screen->base=='post' ) ? true:false; 
if($is_post) { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    jQuery.noConflict();
    jQuery(document).ready(function($){
        var selectedVal = ( typeof $("#display-post-meta-box input.cmeta_display_post:checked").val() !== 'undefined' ) ? $("#display-post-meta-box input.cmeta_display_post:checked").val() : '';
        var postmetaForm = $("#display-post-meta-box .components-base-control").clone();
        $(postmetaForm).addClass('display-post-meta-box-control');
        $(postmetaForm).insertAfter(".edit-post-sidebar .edit-post-post-schedule");
        if(selectedVal) {
            $(".display-post-meta-box-control input.cmeta_display_post").attr("checked",true);
        } else {
            $(".display-post-meta-box-control input.cmeta_display_post").attr("checked",false);
        }
        
        $(document).on("click",".display-post-meta-box-control input.cmeta_display_post",function(){
            if(this.checked) {
                $("input.cmeta_display_post").attr("checked",true);
            } else {
                $("input.cmeta_display_post").attr("checked",false);
            }
        });
    });
    </script>
<?php
    }
}
add_action( 'admin_print_scripts', 'jupload_scripts' );

add_action( 'admin_head', 'post_visibility_head_scripts' );
function post_visibility_head_scripts(){ ?>
    <style>
        .display-post-meta-box-control {
            margin-top: 15px;
        }
        .display-post-meta-box-control label {
            display: block;
            width: 100%;
        }
        .display-post-meta-box-control .components-base-control__field label.components-checkbox-control__input-container {
            display: block;
            width: 100%;
            position: relative;
            margin: 0 0;
            padding: 0 0 0 22px;
        }
        .display-post-meta-box-control .components-base-control__field input {
            margin-right: 2px;
            position: absolute;
            top: 1px;
            left: 0;
            z-index: 5;
            background: transparent!important;
        }
        .display-post-meta-box-control .components-base-control__field .chxboxstat {
            display: block;
            width: 16px;
            height: 16px;
            position: absolute;
            top: 1px;
            left: 0;
            z-index: 3;
            border: 2px solid transparent;
            border-radius:2px;
            transition: none;
            font-style: normal;
        }
        .display-post-meta-box-control .components-base-control__field input:checked + .chxboxstat {
            background: #11a0d2;
            border-color: #11a0d2;
        }.display-post-meta-box-control .components-base-control__field input:checked + .chxboxstat:before {
            content: "\2714";
            display: inline-block;
            position: absolute;
            top: 0px;
            left: 1px;
            color: #FFF;
            font-size: 12px;
            line-height: 1;
        }
        #display-post-meta-box label.components-checkbox-control__input-container {
            width: 100%!important;
            max-width: 100%!important;
            position: relative;
            padding-left: 22px;
        }
        #display-post-meta-box .components-base-control__field input {
            visibility: visible;
            position: absolute;
            top: 1px;
            left: 0;
        }
        /* This do the trick */
        /*.metabox-location-side #display-post-meta-box{display:none!important;}*/
    </style>
<?php
}

