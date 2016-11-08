### an attempt to modify an existing theme (Storefront), rather than starting from scratch

Interesting point made [here](https://wordpress.org/support/topic/unable-to-make-shop-page-full-width/). Apparently, the reason the shop page had no shortcode and was unresponsive to changing the page template to full-width, is because it's not a real page. We can solve this by duplicating the parent theme's full-width template (whatever they've called it) and renaming it archive-product.php. This did not result in what I was looking for, however; the layout is single column rather than three. This might be okay, though, because we are not planning to have many products.

### some confusion about enqueuing styles in a child theme

This is suggested in the WordPress codex:

```php
<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

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