<?php
/**
 * WP Flowbite Navwalker
 */

// Check if Class Exists.
if ( ! class_exists( 'WP_Flowbite_Navwalker' ) ) :
    
    class WP_Flowbite_Navwalker extends Walker_Nav_Menu {

        public function start_lvl( &$output, $depth = 0, $args = null ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat( $t, $depth );
    
            $classes = array( 'sub-menu py-2 text-sm text-gray-700 dark:text-gray-400' );
    
            $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
    
            $output .= "{$n}{$indent}<ul$class_names>{$n}";
        }

        public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
            $menu_item = $data_object;
    
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
    
            $classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
            $classes[] = 'menu-item-' . $menu_item->ID;
    
            $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );
    
            $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
    
            $output .= $indent . '<li' . $id . $class_names . '>';
    
            $atts           = array();
            $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
            $atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
            if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
                $atts['rel'] = 'noopener';
            } else {
                $atts['rel'] = $menu_item->xfn;
            }
    
            if ( ! empty( $menu_item->url ) ) {
                if ( get_privacy_policy_url() === $menu_item->url ) {
                    $atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
                }
    
                $atts['href'] = $menu_item->url;
            } else {
                $atts['href'] = '';
            }
    
            $atts['aria-current'] = $menu_item->current ? 'page' : '';

            $atts['data-dropdown-toggle'] = 'sub-menu-' . $menu_item->ID;

            if ($depth > 0) {
                $atts['data-dropdown-placement'] = "right-start";
            }
    
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
    
            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
    
            $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
    
            $title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );
    
            $item_output  = $args->before;
            if (in_array('menu-item-has-children', $classes)) {    
                if ($depth > 0) {
                    $item_output .= '<a class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" ' . $attributes . '>';
                } else {
                    $item_output .= '<a class="flex items-center justify-between w-full py-2 pl-3 pr-4  text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent" ' . $attributes . '>';
                }
            } else {
                $item_output .= '<a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" ' . $attributes . '>';
            }
            $item_output .= $args->link_before . $title . $args->link_after;
            if (in_array('menu-item-has-children', $classes)) {
                if ($depth > 0) {
                    $item_output .= '<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
                } else {
                    $item_output .= '<svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                }
            }
            $item_output .= '</a>';
            $item_output .= '<div id="sub-menu-' . $menu_item->ID . '" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
        }
    }

endif;
