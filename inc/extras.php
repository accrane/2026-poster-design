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

function shortenText2($text, $max = 50, $append = '…') {
  if (strlen($text) <= $max) return $text;
  $return = substr($text, 0, $max);
  if (strpos($text, ' ') === false) return $return . $append;
  return preg_replace('/\w+$/', '', $return) . $append;
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

function get_social_media() {
    $options = get_field("social_media_links","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['link']) && $opt['link'] ) {
                $url = $opt['link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fa fa-facebook',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fa fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'     => 'fab fa-vimeo',
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


/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
/* Options page under custom post type */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_sub_page(array(
//         'page_title'    => 'People Options',
//         'menu_title'    => 'People Options',
//         'parent_slug'   => 'edit.php?post_type=people'
//     ));
// }
// function be_acf_options_page() {
//     if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
//     $acf_option_tabs = array(
//         array( 
//             'title'      => 'Today Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Menu Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Global Options',
//             'capability' => 'manage_options',
//         )
//     );

//     foreach($acf_option_tabs as $options) {
//         acf_add_options_page($options);
//     }
// }
// add_action( 'acf/init', 'be_acf_options_page' );


function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}


add_action( 'admin_head', 'admin_head_scripts' );
function admin_head_scripts() { ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_url') ?>/css/admin.css">
  <style>
    [data-name="row10_text"],
    [data-name="row10_title"],
    [data-name="row10_image"] {
      display: none!important;
    }
  </style>
<?php
}

/* ACF CUSTOM VALUES */
$gravityFormsSelections = array('gravityForm','global_the_form');
function acf_load_gravity_form_choices( $field ) {
    // reset choices
    $field['choices'] = array();
    $choices = getGravityFormList();
    if( $choices && is_array($choices) ) {       
        foreach( $choices as $choice ) {
            $post_id = $choice->id;
            $post_title = $choice->title;
            $field['choices'][ $post_id ] = $post_title;
        }
    }
    return $field;
}
foreach($gravityFormsSelections as $fieldname) {
  add_filter('acf/load_field/name='.$fieldname, 'acf_load_gravity_form_choices');
}

function getGravityFormList() {
    global $wpdb;
    $query = "SELECT id, title FROM ".$wpdb->prefix."gf_form WHERE is_active=1 AND is_trash=0 ORDER BY title ASC";
    $result = $wpdb->get_results($query);
    return ($result) ? $result : '';
}


function custom_excerpt_more( $excerpt ) {
    return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

//change the number for the length you want
function custom_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function get_excerpt($text,$limit=100) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]>', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

    /* This gets rid of all empty p tags, even if they contain spaces or &nbps; inside. */
    $text = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $text); 

    /* Get rid of <img> tag */
    $text = preg_replace("/<img[^>]+\>/i", "", $text); 
    $text = strip_tags($text,"<p><a>");
    $excerpt_length = $limit;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '...');
            $text = implode(' ', $words);
            $text = force_balance_tags( $text );
    }
 
    return $text;
}   


/* Update Peope post type */
// if( (isset($_GET['post_type']) && $_GET['post_type']=='team') && (isset($_GET['do']) && $_GET['do']=='update') ) {
//   $args = array(
//     'posts_per_page'   => -1,
//     'post_type'        => 'people',
//     'post_status'      => 'publish'
//   );
//   $team = get_posts($args);
//   if($team) {
//     foreach($team as $p) {
//       $pid = $p->ID;
//       $p->post_type="team";
//       wp_update_post($p);
//     }
//   }
// }



