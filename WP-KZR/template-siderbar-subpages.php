<?php
/* Template Name: sidebar subpages Template */

get_header(); 

if (have_posts()) :
    while (have_posts()) : the_post(); ?>

        <!-- Main Page Content -->
        <section class="sub-page-header" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
            <div class="container">
                <div class="header-content">
                  <?php custom_breadcrumbs(); ?>
                    <div class="page-title">
                        <h1><?php the_title(); ?></h1>
                        <div class="excerpt-sec">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Subpages Content -->
        <main class="main-wrap">
            <div class="container">
               <div class="row sub-page-row custom-space">
                    <div class="col-xl-3 d-none d-xl-block">
                        <div class="sidebar">
                            <div class="web-heading heading-divider">
                                <?php
                                // Get the parent page ID
                                $parent_id = wp_get_post_parent_id(get_the_ID());
                                // If there's no parent, use the current page as the parent
                                if (!$parent_id) {
                                    $parent_id = get_the_ID();
                                }
                                // Get the parent page title
                                $parent_title = get_the_title($parent_id);
                                ?>
                                <h2><?php echo esc_html($parent_title); ?></h2>
                            </div>

                            <div class="sidebar-menu">
                                <ul>
                                    <?php
                                    // Define the fetch_svg_content function if it doesn't already exist
                                    if (!function_exists('fetch_svg_content')) {
                                        function fetch_svg_content($url) {
                                            $response = wp_remote_get($url);
                                            if (is_wp_error($response)) {
                                                return ''; // Return empty if there's an error
                                            }
                                            return wp_remote_retrieve_body($response);
                                        }
                                    }

                                    // Get sibling pages (pages with the same parent)
                                    $siblings = get_pages(array(
                                        'child_of' => $parent_id,
                                        'sort_column' => 'menu_order'
                                    ));

                                    // Loop through sibling pages
                                    foreach ($siblings as $sibling) {
                                        $sibling_id = $sibling->ID;
                                        $sibling_title = $sibling->post_title;
                                        $sibling_link = get_permalink($sibling_id);
                                        $icon_url = get_post_meta($sibling_id, '_custom_icon_url', true);
                                        $show_icon = get_post_meta($sibling_id, '_custom_show_icon', true);

                                        // Fetch SVG content if needed
                                        $svg_content = '';
                                        if (!empty($icon_url)) {
                                            $file_extension = pathinfo($icon_url, PATHINFO_EXTENSION);
                                            if ($file_extension === 'svg') {
                                                $svg_content = '<img class="svg" src="' . esc_url($icon_url) . '" alt="SVG Image">';
                                            }
                                        }
                                        ?>
                                        <li class="<?php echo ($sibling_id == get_the_ID()) ? 'current-menu-item' : ''; ?>">
                                            <a href="<?php echo esc_url($sibling_link); ?>">
												
                                                <?php echo $svg_content; // Output the SVG content directly ?>
                                                <?php echo esc_html($sibling_title); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-9">
                    <?php
                    the_content();
                    ?> 
                    </div>
                </div>
            </div>
        </main>
    <?php endwhile;
endif;

get_footer();
?>
 