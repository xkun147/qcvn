<?php
/**
 * Class that generates custom markup for mega menu that shows posts by categories
 * @package themify
 * @subpackage megamenu
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Themify_Mega_Menu_Walker') ) {
	/**
	 * Class Themify_Mega_Menu_Walker generates menu with posts by category
	 * @since 1.0.0
	 */
	class Themify_Mega_Menu_Walker extends Walker_Nav_Menu {
		static $mega_open = false;

		function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
			$classes = empty ( $item->classes ) ? array () : (array) $item->classes;

			/* apply the icon-* classnames to the link element itself */
			foreach( $classes as $key => $value ) {
				if( preg_match( '/^icon-/', $value ) ) {
					$icon_classname = $classes[$key];
					unset( $classes[$key] );
				}
			}

			$class_names = join(' ', apply_filters(	'nav_menu_css_class', array_filter( $classes ), $item ));
			$class_names = !empty ( $class_names )? 'class="'.esc_attr( $class_names ).'"' : '';

			$output .= "<li id='menu-item-$item->ID' $class_names>";

			$attributes  = !empty( $item->attr_title )? ' title="'  . esc_attr( $item->attr_title ) . '"': '';
			$attributes .= !empty( $item->target )    ? ' target="' . esc_attr( $item->target     ) . '"': '';
			$attributes .= !empty( $item->xfn )       ? ' rel="'    . esc_attr( $item->xfn        ) . '"': '';
			$attributes .= !empty( $item->url )       ? ' href="'   . esc_attr( $item->url        ) . '"': '';
			$attributes .= isset( $icon_classname )   ? ' class="'  . esc_attr( $icon_classname   ) . '"': '';

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			if( in_array( 'mega', $item->classes ) ) {
				self::$mega_open = true;
				$item_output = $args->before. "<a $attributes>" . $args->link_before . $title . '</a> ' . $args->link_after . $args->after;
				$mega_list = $this->get_nav_menu_item_children(
					$item->db_id,
					wp_get_nav_menu_items( $this->get_theme_menu_name( $args->menu_id ) )
				);
				$mega_lis = '';
				$mega_posts = '';
				$first = true;
				$taxonomy = apply_filters( 'themify_mega_menu_taxonomy', 'category' );
				foreach($mega_list as $mega) {
					$term = get_term( $mega->object_id, $taxonomy );
					if ( ! is_object( $term ) ) continue;

					$term_link = get_term_link( $term, $taxonomy );
					if( is_wp_error( $term_link ) ) {
						$term_link = '#';
					}
					$mega_lis .= sprintf( '<li class="menu-item mega-link %s" data-termid="%s" data-termslug="%s" data-tax="%s"><a href="%s" %s %s %s>%s</a></li>',
						 join( ' ', $mega->classes ),
						 $term->term_id,
						 $term->slug,
						 $taxonomy,
						 $term_link,
						 '' != $mega->attr_title? 'title="'.$mega->attr_title.'"': '',
						 '_blank' == $mega->target? 'target="_blank"': '',
						 '' != $mega->xfn? 'rel="'.$mega->xfn.'"': '',
						 $mega->title
					 );

					if( $first ) {
						$mega_posts = themify_theme_mega_get_posts( $term->slug, $taxonomy );
						$first = false;
					}
				}
				$out = sprintf('
					<div class="mega-sub-menu">
						<ul>%s</ul>
						<div class="mega-menu-posts">%s</div>
						<!-- /.mega-menu-posts -->
					</div><!-- /.mega-sub-menu -->',
					$mega_lis,
					$mega_posts
				);

				$item_output .= apply_filters('themify_mega_menu_html', $out);

			} elseif( in_array( 'columns', $item->classes ) ) {
				self::$mega_open = true;
				$columns = '';

				$top_list = $this->get_nav_menu_item_children(
					$item->db_id,
					wp_get_nav_menu_items( $this->get_theme_menu_name( $args->menu_id ) ),
					false
				);

				foreach($top_list as $top_item) {
					$sub_list = $this->get_nav_menu_item_children(
						$top_item->db_id,
						wp_get_nav_menu_items( $this->get_theme_menu_name( $args->menu_id ) ),
						false
					);
					$columns .= '<div class="mega-column-list">';
					if( isset( $top_item->title ) && '' != $top_item->title )
						$columns .= '<h3><a href="'.$top_item->url.'">' . $top_item->title . '</a></h3>';
					else
						$columns .= '<h3>' . $top_item->title . '</h3>';
					$columns .=	'<ul>';
					foreach( $sub_list as $sub_item ) {
						//$columns .= '<li><a href="' . $sub_item->url . '">' . $sub_item->title . '</a></li>';
						$columns .= sprintf( '<li class="%s"><a href="%s" %s %s %s>%s</a></li>',
							 join( ' ', $sub_item->classes ),
							 $sub_item->url,
							 '' != $sub_item->attr_title? 'title="'.$sub_item->attr_title.'"': '',
							 '_blank' == $sub_item->target? 'target="_blank"': '',
							 '' != $sub_item->xfn? 'rel="'.$sub_item->xfn.'"': '',
							 $sub_item->title
						 );
					}
					$columns .= '</ul>
								</div>
								<!-- /.mega-column-list -->';
				}
				$out = sprintf('
					<a href="%s">%s</a>
					<div class="mega-column-wrapper clearfix">
						%s
					</div>
					<!-- /.mega-column -->',
					$item->url,
					$item->title,
					$columns
				);
				$item_output = apply_filters('themify_mega_columns_html', $out);
			} elseif( in_array( 'mega-sub-item', $item->classes ) || in_array( 'columns-sub-item', $item->classes ) ) {
				dumpit($item->classes);
				return;
			} else {
				if( true == self::$mega_open ) {
					self::$mega_open = false;
				}
				$item_output = $args->before. "<a $attributes>" . $args->link_before . $title . '</a> ' . $args->link_after . $args->after;
			}
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Start sub level markup
		 * @param string $output
		 * @param int $depth
		 * @param array $args
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			if( true == self::$mega_open ) return;
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}

		/**
		 * End sub level markup
		 * @param string $output
		 * @param int $depth
		 * @param array $args
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			if( true == self::$mega_open ) return;
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		/**
		 * Returns menu name in a certain location
		 * @param $theme_location
		 * @return bool
		 * @since 1.0.0
		 */
		function get_theme_menu_name( $theme_location ) {
			if( ! $theme_location )
				return false;

			$theme_locations = get_nav_menu_locations();

			if( ! isset( $theme_locations[$theme_location] ) )
				return false;

			$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

			if( ! $menu_obj )
				$menu_obj = false;

			if( ! isset( $menu_obj->name ) )
				return false;

			return $menu_obj->name;
		}

		/**
		 * Returns all child nav_menu_items under a specific parent
		 * @param   int   $parent_id   		the parent nav_menu_item ID
		 * @param   array $nav_menu_items  	nav_menu_items
		 * @param   bool  $depth   			gives all children or direct children only
		 * @return  array returns filtered 	array of nav_menu_items
		 * @since 1.0.0
		 */
		function get_nav_menu_item_children( $parent_id, $nav_menu_items, $depth = true ) {
			$nav_menu_item_list = array();
			foreach ( (array) $nav_menu_items as $nav_menu_item ) {
				if ( $nav_menu_item->menu_item_parent == $parent_id ) {
					$nav_menu_item_list[] = $nav_menu_item;
					if ( $depth ) {
						if ( $children = $this->get_nav_menu_item_children( $nav_menu_item->ID, $nav_menu_items ) )
							$nav_menu_item_list = array_merge( $nav_menu_item_list, $children );
					}
				}
			}
			return $nav_menu_item_list;
		}

		/**
		 * Modify item rendering
		 * @param object $element
		 * @param array $children_elements
		 * @param int $max_depth
		 * @param int $depth
		 * @param array $args
		 * @param string $output
		 * @return null|void
		 * @since 1.0.0
		 */
		function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
				$element->classes[] = 'has-sub-menu';
			}
			if( in_array( 'mega', $element->classes ) ) {
				$element->classes[] = 'has-mega-sub-menu';
				if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
					foreach( $children_elements[ $element->$id_field ] as $child ) {
						$child->classes[] = 'mega-sub-item';
					}
				}
			} elseif( in_array( 'columns', $element->classes ) ) {
				$element->classes[] = 'has-mega-column';
				if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
					foreach( $children_elements[ $element->$id_field ] as $child ) {
						$child->classes[] = 'columns-sub-item';
					}
				}
			} elseif( in_array( 'columns-sub-item', $element->classes ) ) {
				if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
					foreach( $children_elements[ $element->$id_field ] as $child ) {
						$child->classes[] = 'columns-sub-item';
					}
				}
			}
			if( in_array( 'mega-sub-item', $element->classes ) || in_array( 'columns-sub-item', $element->classes ) ) {
				return;
			}
			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}
	}
}

if ( ! function_exists( 'themify_mega_menu_enqueue' ) ) {
	/**
	 * Enqueue Stylesheets and Scripts
	 * @since 1.0.0
	 */
	function themify_mega_menu_enqueue(){
		$theme_version = wp_get_theme()->display('Version');

		if( themify_theme_maybe_do_mega_menu() ) {
			wp_enqueue_script( 'themify-mega-menu', THEME_URI . '/js/themify.mega-menu.js', array('jquery'), $theme_version, true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'themify_mega_menu_enqueue');
}

if( ! function_exists('themify_theme_mega_get_posts') ) {
	/**
	 * Returns posts from a taxonomy by a given term
	 * @param $term_slug
	 * @param $taxonomy
	 * @return string
	 */
	function themify_theme_mega_get_posts( $term_slug, $taxonomy ){
		$mega_posts = '<article itemscope itemtype="http://schema.org/Article" class="post"><h1 class="post-title">'.__('Error loading posts.', 'themify').'</a></div>';
		$term_query_args = apply_filters('themify_mega_menu_query',
			array(
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field' => 'slug',
						'terms' => $term_slug
					)
				),
				'suppress_filters' => false,
				'posts_per_page' => 4
			)
		);
		$posts = get_posts( $term_query_args );

		if( $posts ) {
			global $post;
			$mega_posts = '';
			$dimensions = apply_filters( 'themify_mega_menu_image_dimensions', array(
				'width'  => 180,
				'height' => 120
			) );
			foreach( $posts as $post ) {
				setup_postdata( $post );
				$mega_posts .= sprintf('
					<article itemscope itemtype="http://schema.org/Article" class="post">
						<figure class="post-image">
							<a href="%1$s">
								%2$s
							</a>
						</figure>
						<h1 class="post-title">
							<a href="%1$s">
								%3$s
							</a>
						</h1>
					</article>
					<!-- /.post -->',
					themify_get_featured_image_link(),
					themify_get_image('ignore=true&w='. $dimensions['width'] .'&h=' . $dimensions['height']),
					the_title_attribute( 'echo=0&post='.$post->ID )
				);
			}
			wp_reset_postdata();
		}
		return $mega_posts;
	}
}

if( ! function_exists( 'themify_theme_mega_posts' ) ) {
	/**
	 * Called with AJAX to return posts
	 * @since 1.0.0
	 */
	function themify_theme_mega_posts() {
		check_ajax_referer( 'ajax_nonce', 'nonce' );
		$term_slug = isset( $_POST['termslug'] )? $_POST['termslug']: '';
		$taxonomy  = isset( $_POST['tax'] )? $_POST['tax']: 'category';
		echo themify_theme_mega_get_posts( $term_slug, $taxonomy );
		die();
	}
	add_action('wp_ajax_themify_theme_mega_posts', 'themify_theme_mega_posts');
	add_action('wp_ajax_nopriv_themify_theme_mega_posts', 'themify_theme_mega_posts');
}

if ( ! function_exists( 'themify_theme_is_mobile' ) ) {
	/**
	 * Detect mobile browser
	 * @return int
	 * @since 1.0.0
	 */
	function themify_theme_is_mobile() {
		global $themify;
		return $themify->detect->isMobile() && !$themify->detect->isTablet();
	}
}

if ( ! function_exists( 'themify_theme_maybe_do_mega_menu' ) ) {
	/**
	 * Check if mega menu must be created
	 * @return bool
	 * @since 1.0.0
	 */
	function themify_theme_maybe_do_mega_menu() {
		if( 'no' != themify_get('setting-mega_menu') && !themify_theme_is_mobile() )
			return true;
		else
			return false;
	}
}

/***************************************************
 * Themify Theme Access Point
 ***************************************************/

if( ! function_exists('themify_theme_main_menu') ) {
	/**
	 * Displays menu and/or mega menu
	 * @since 1.0.0
	 */
	function themify_theme_main_menu(){
		$args = array(
			'theme_location' => 'main-nav',
			'fallback_cb' => 'themify_default_main_nav',
			'container' => '',
			'menu_id' => 'main-nav',
			'menu_class' => 'main-nav',
			'echo' => false
		);
		$menu_type = 'main';

		if( themify_theme_maybe_do_mega_menu() ) {
			$args['walker'] = new Themify_Mega_Menu_Walker;
			$menu_type = 'mega';
		}

		echo apply_filters( 'themify_' . $menu_type . '_menu_html', wp_nav_menu( $args ), $args );
	}
}

/***************************************************
 * Themify Theme Settings Module
 ***************************************************/

if ( ! function_exists( 'themify_mega_menu_module' ) ) {
	/**
	 * Markup for mega menu module
	 * @param array $data
	 * @return string
	 */
	function themify_mega_menu_module( $data = array() ) {
		$data = themify_get_data();
		/**
		 * Variable key in theme settings
		 * @var string
		 */
		$key = 'setting-mega_menu';

		/**
		 * Binary options yes|no
		 * @var array
		 */
		$binary = array(
			array('name' => __('Yes', 'themify'), 'value' => 'yes'),
			array('name' => __('No', 'themify'), 'value' => 'no')
		);

		/**
		 * Module markup
		 * @var string
		 */
		$html = '';

		$html .= sprintf('
			<p>
				<span class="label">%s</span>
				<select name="%s">%s</select>
				<br /><span class="pushlabel"><small>%s</small></span>
			</p>',
			__('Enable Mega Menu', 'themify'),
			$key,
			themify_options_module($binary, $key),
			__('Appears only in main navigation. You must set a menu for that area.', 'themify')
		);

		return $html;
	}
}