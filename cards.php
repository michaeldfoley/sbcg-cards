<?php 
/*
Plugin Name: SBCG Cards
Plugin URI: https://github.com/michaeldfoley/sbcg-cards
Description: Adds the shortcode `cards` to the SBCG website
Version: 0.1
Author: Michael Foley
Author URI: http://michaeldfoley.com
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: _sbcg_cards
Domain Path: /languages/
*/


function _sbcg_cards_card( $atts, $content = '' ) {
  $args = shortcode_atts( array(
    'icon' => '',
    'title' => '',
    'link' => '',
    'background' => '',
  ), $atts );
  
  $background = trim($args['background']);
  
  if ( preg_match("/([^\s]+(\.(jpe?g|png|gif|bmp|svg))$)/i", $background) ) {
    $background = "url('{$background}')";
    
  } else if ( !preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $background) ) {
    $background = "";
  }
  
  $is_bgimg = strpos($background, "url(");
  
  $out = sprintf( "%s<div class=\"card-content\">%s%s</div>", 
          ( $args['icon'] !== "" && $is_bgimg === false ) ? "<svg class=\"card-icon\" role=\"presentation\"><use xlink:href=\"" . get_stylesheet_directory_uri() . "/assets/images/sprite.symbol.svg#{$args['icon']}\" /></svg>" : "",
          ( $args['title'] !== "" ) ? "<h4 class=\"card-title\">{$args['title']}</h4>" : "",
          ( $is_bgimg === false ) ? $content : ''
        );  
        
  $out = sprintf( "\n<div class=\"card%s\"%s>%s</div>\n",
          ( $is_bgimg !== false ) ? " card-bg" : "",
          ( !empty($background) ) ? " style=\"background:{$background}\"" : "",
          ($args['link'] !== "") ? "<a href=\"{$args['link']}\">{$out}</a>" : $out
        );
            
  return $out;
}
add_shortcode( 'card', '_sbcg_cards_card' );


// Row wrapper
 
function _sbcg_cards_row( $atts, $content = '' ) {
  $args = shortcode_atts( array(
    'class' => 'row',
  ), $atts );
  $out = sprintf( "\n<section class=\"%s\">%s</section>\n",
          $args['class'], 
          do_shortcode( shortcode_unautop( $content ))
        );
    
  return $out;
}
add_shortcode( 'row', '_sbcg_cards_row' );

?>