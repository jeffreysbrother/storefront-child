### an attempt to modify an existing theme (Storefront), rather than starting from scratch

Interesting point made [here](https://wordpress.org/support/topic/unable-to-make-shop-page-full-width/). Apparently, the reason the shop page had no shortcode and was unresponsive to changing the page template to full-width, is because it's not a real page. We can solve this by duplicating the parent theme's full-width template (whatever they've called it) and renaming it archive-product.php. This did not result in what I was looking for, however; the layout is single column rather than three. This might be okay, though, because we are not planning to have many products.

### some confusion about enqueuing styles in a child theme

This is suggested in the WordPress codex:

```php
<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
?>
```

But this results in my child theme CSS being duplicated down the page ... and the initial enqueue showing up **before** the parent theme CSS. WTF?

To fix this, the only styles I've decided to enqueue are Bootstrap styles. It appears that the parent theme and child theme CSS load correctly without doing anything.

### Stripe

To work in live mode, Stripe requires an SSL certificate. This might be the best option, if we don't mind paying the monthly fee required for a dedicated IP address and an SSL cert. 

### PayPal Advanced

I purchased a plugin for PayPal advanced, and was approved ... but I can't seem to log in to get started. Eh. On a positive note, an SSL certificate is NOT required to use PayPal Advanced. See [this](https://docs.woocommerce.com/document/paypal-payments-advanced-2/) link for more info.

### PayPal (powered by Braintree)

Looks like this is ready to go, but I need to send some documents if I was to receive monies. Also requires SSL certificate (which, in turn, requires a dedicated IP address).

### layout, styles

After switching to .scss, the compiled styles from css/ are getting enqueued BEFORE the parent theme styles. This needs to be fixed.

### other

See Trello for a more complete list of pending tasks and issues.

### more issues

Compare nav on blog page ... to the nav on a product page. They're different. Same goes for the footer. I'm also seeing the text "showing the single result" on the product page, despite having hid it earlier (this was previously a sorting dropdown, I believe).