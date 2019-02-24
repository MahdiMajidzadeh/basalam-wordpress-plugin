<?php

/**
 *
 * @link              https://mahdi.majidzadeh.ir/
 * @since             1.0.0
 * @package           Basalam
 *
 * @wordpress-plugin
 * Plugin Name:       Basalam
 * Plugin URI:        http://basalam.ir/
 * Description:       Show Basalam prodcuts and vendores in your posts
 * Version:           1.0.0
 * Author:            Mahdi Majidzadeh
 * Author URI:        https://mahdi.majidzadeh.ir/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       basalam
 * Domain Path:       /languages
 */

function basalam_enqueue_style() {
	wp_enqueue_style( 'basalam-style', plugin_dir_url( __FILE__ ).'/public/style.css');
}
add_action( 'wp_enqueue_scripts', 'basalam_enqueue_style' );


@include 'query.php';

add_shortcode('bs-show-product', 'bs_show_product');

function bs_show_product($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => 56221,
        ),
        $atts
    );
	$item = bs_query_get_product(['id' => $atts['id']]);

	$link = 'http://basalam.ir/new/' . $item->vendor->identifier . '/product/' . $item->id;
	$export = "
    <div class='col-md-4 col-ms-6 product'>
        <div class='card card-product'>
            <div class='card-image'>
                <a href='{$link}'
                   title='{$item->name}'>
                    <img width='{$item->photo->width}'
                         height='{$item->photo->height}'
                         src='{$item->photo->url}'
                         class='alignleft wp-post-image' alt=''>
                    <div class='ripple-container'></div>
            </div>
            <div class='content'>

                <div class='card-title'>
                    {$item->name}
                </div>
                <div>
                    <div class='price'>
                         ".number_format($item->price)." ریال
                        </div>
                    <div class='stats'>
                        <a class='button' href='{$link}'>مشاهده و خرید</a>
                    </div>
                </div>
            </div>
        </div>

    </div>";

	return $export;
}