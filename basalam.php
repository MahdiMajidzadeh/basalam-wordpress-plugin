<?php

/**
 *
 * @link              https://mahdi.majidzadeh.ir/
 * @since             1.0.2
 * @package           Basalam
 *
 * @wordpress-plugin
 * Plugin Name:       Basalam Products
 * Plugin URI:        https://basalam.com/
 * Description:       Show Basalam prodcuts and vendores in your posts
 * Version:           1.0.2
 * Author:            Mahdi Majidzadeh
 * Author URI:        https://mahdi.majidzadeh.ir/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       basalam
 * Domain Path:       /languages
 */

function basalam_enqueue_style() {
	wp_enqueue_style( 'basalam-style', plugin_dir_url( __FILE__ ).'/public/style.css', [], '1.0.2');
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

	$link = 'https://basalam.com/' . $item->vendor->identifier . '/product/' . $item->id;
	$export = "
    <div class='bs-product-container'>
            <div class='image-box'>
                <a href='{$link}'
                   title='{$item->name}'>
                    <img width='{$item->photo->width}'
                         height='{$item->photo->height}'
                         src='{$item->photo->url}'
                         class='alignleft wp-post-image' alt=''>
                    <div class='ripple-container'></div>
                </a>
            </div>
            <div class='product-content'>
                <div class='product-title'>
                    {$item->name}
                </div>
                <div class='product-brief'>
                {$item->brief}
                </div>
                <div>
                    <div class='product-price'>
                         ".number_format($item->price)." ریال
                        </div>
                    <div class='stats'>
                        <a class='price-button' href='{$link}'>مشاهده و خرید</a>
                    </div>
                </div>
            </div>
    </div>";

	return $export;
}