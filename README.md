# wp-flowbite-navwalker
A custom WordPress nav walker class to implement the Flowbite Tailwind UI navigation style in a custom theme using the WordPress built in menu manager. This version adds the support for multi level dropdowns and HTML menu item descriptions, CSS classes, and Titles.


## NOTE
This is a utility class that is intended to format your WordPress theme menu with the correct syntax and classes to utilize the Bootstrap dropdown navigation, and does not include the required Bootstrap JS files. You will have to include them manually.

# Installation
Place **class-wp-flowbite-navwalker.php** in your WordPress theme folder `/wp-content/your-theme/`

Open your WordPress themes **functions.php** file `/wp-content/your-theme/functions.php` and add the following code:

```php

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
    require_once get_template_directory() . '/class-wp-flowbite-navwalker.php';
}

add_action( 'after_setup_theme', 'register_navwalker' );

```

# Usage

Update your `wp_nav_menu()` function in `header.php` to use the new walker by adding a "walker" item to the wp_nav_menu array.

```
wp_nav_menu(
    array(
        'theme_location' => 'menu-1',
        'menu_id' => 'primary-menu',
        'menu_class' => 'flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700',
        'items_wrap' => '<ul id="%1$s" class="%2$s" aria-labelledby="menu">%3$s</ul>',
        'fallback_cb' => 'WP_Flowbite_Navwalker::fallback',
        'walker' => new WP_Flowbite_Navwalker(),
    )
);

```
