<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
?>

<?php
do_action('woocommerce_before_main_content');
?>

<?php echo do_shortcode('[sigmie_product_listing]'); ?>

<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
