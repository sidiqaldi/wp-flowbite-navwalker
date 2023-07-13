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

```php
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

# Sample implementation using flowbite Multi-level dropdown

```php
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

            <a href="<?php echo get_home_url(); ?>" class="flex items-center">

                <?php if ( is_front_page() ) : ?>

                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"><?php bloginfo( 'name' ); ?></span>
                    <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                    ?>
                        <p class="ml-3 text-sm"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    <?php endif; ?>
                <?php else : ?>

                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"><?php bloginfo( 'name' ); ?></span>
                    <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                    ?>
                        <p class="ml-3 text-sm"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <?php
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
            ?>
            </div>
        </div>
    </nav>
```
