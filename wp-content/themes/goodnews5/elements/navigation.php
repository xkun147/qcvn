            <?php
            $dd_effect = 'dd-effect-'.mom_option('nav_dd_animation');
            if ($dd_effect == '') {
                $dd_effect = 'dd-effect-slide';
            }
            $nav_sh = '';
            if (mom_option('nav_shadow') == 2) {
                $nav_sh = ' nav_shadow_on';
            } elseif (mom_option('nav_shadow') == 3) {
                $nav_sh = ' nov_white_off';
            }
            ?>
            <nav id="navigation" itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation" class="<?php echo $dd_effect.$nav_sh; ?> ">
                <div class="navigation-inner">
                <div class="inner">
                    <?php if ( has_nav_menu( 'main' ) ) { ?>
                        <?php wp_nav_menu ( array( 'menu_class' => 'main-menu main-default-menu mom_visibility_desktop','container'=> 'ul', 'theme_location' => 'main', 'walker' => new mom_custom_Walker()  )); ?>
                        <?php
                        if (file_exists(get_template_directory() . '/demo/demo.php')) {
                            global $mom_iconic_menu;
                                wp_nav_menu ( array( 'menu_class' => 'main-menu mom_visibility_desktop display_none iconic_menu','container'=> 'ul', 'menu' => $mom_iconic_menu, 'walker' => new mom_custom_Walker()  ));
                        }
                        ?>
                        <?php $isNavSearch = ''; if (mom_option('nav_search')) { $isNavSearch = 'has_nav_search';} ?>
                        <div class="mom_visibility_device device-menu-wrap <?php echo $isNavSearch; ?>">
                        <div class="device-menu-holder">
                            <i class="fa-icon-align-justify mh-icon"></i> <span class="the_menu_holder_area"><i class="dmh-icon"></i><?php _e('Menu', 'theme'); ?></span><i class="mh-caret"></i>
                        </div>
                        <?php wp_nav_menu ( array( 'menu_class' => 'device-menu' ,'container'=> 'ul', 'theme_location' => 'main', 'walker' => new mom_custom_Walker()  )); ?>
                        </div>
                    <?php } else { ?>
                        <span><?php _e('', 'theme'); ?></span>
                    <?php } ?>
                    <?php if (mom_option('nav_search') == 1) { ?> 
                    <div class="nav-search">
                        <i class="fa-icon-search"></i>
                    </div>
                    <div class="search-wrap border-box">
                        <div class="sw-inner">
                        <div class="search-form mom-search-form">
                            <form method="get" action="<?php echo home_url(); ?>">
                                <input class="sf" type="text" placeholder="<?php _e('Search ...', 'theme'); ?>" autocomplete="off" name="s">
                                <button class="button" type="submit"><i class="fa-icon-search"></i></button>
                            </form>
                            <span class="sf-loading"><img src="<?php echo MOM_IMG; ?>/ajax-search-nav.png" alt=""></span>
                        </div>
                    <div class="ajax_search_results">
                    </div> <!--ajax search results-->
                    </div> <!--sw inner-->
                    </div> <!--search wrap-->
                    <?php } ?>
                    
                </div>
                </div> <!--nav inner-->
            </nav> <!--Navigation-->
            <?php if (mom_option('nav_shadow') == 1) { ?> 
            <div class="nav-shaddow"></div>
            <?php } else { ?>
            <div style="height:20px;"></div>
            <?php } ?>