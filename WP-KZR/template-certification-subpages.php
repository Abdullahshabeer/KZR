<?php
/* Template Name: Custom Subpages Template */

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
                <div class="cards-wrap">
                    <div class="row custom-space">
                    <?php
// Get only immediate child pages (1st level)
$subpages = get_pages(array(
    'child_of' => get_the_ID(),  // Get children of the current page
    'sort_column' => 'menu_order',
    'hierarchical' => 1, // Get hierarchical structure
));

foreach ($subpages as $subpage) {
    // Ensure it's a direct child (not a grandchild or deeper)
    if ($subpage->post_parent == get_the_ID()) {
        $subpage_id = $subpage->ID;
        $subpage_title = $subpage->post_title;
        $subpage_excerpt = $subpage->post_excerpt;

        // Get the post thumbnail ID
        $thumbnail_id = get_post_thumbnail_id(get_the_ID());

        // Get the alt text for the thumbnail image
        $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

        // Fallback to post title if alt text is not set
        $alt_text = $thumbnail_alt ? $thumbnail_alt : '';
        $subpage_image = get_the_post_thumbnail($subpage_id, 'medium_large', array('alt' => esc_attr($alt_text)));
        $subpage_link = get_permalink($subpage_id);
        $icon_url = get_post_meta($subpage_id, '_custom_icon_url', true);
        $show_icon = get_post_meta($subpage_id, '_custom_show_icon', true);

        // Define fetch_svg_content function if not already defined
        if (!function_exists('fetch_svg_content')) {
            function fetch_svg_content($url) {
                $response = wp_remote_get($url);
                if (is_wp_error($response)) {
                    return ''; // Return empty if there's an error
                }
                return wp_remote_retrieve_body($response);
            }
        }

        // Fetch SVG content if needed
        $svg_content = '';
        if ($show_icon && !empty($icon_url)) {
            $file_extension = pathinfo($icon_url, PATHINFO_EXTENSION);
            if ($file_extension === 'svg') {
                $svg_content = '<img class="svg" src="' . esc_url($icon_url) . '" alt="SVG Image">';
            }
        }

        // Determine column class based on the number of subpages
        if ($show_icon) {
            if (count($subpages) == 2) { // Check the number of subpages
                $column_class = 'col-xl-6';
            } else {
                $column_class = 'col-xl-3';
            }
        } else {
            $column_class = 'col-xl-4';
        }
        ?>
        <div class="<?php echo esc_attr($column_class); ?> col-md-6">
            <div class="web-card light-bg border-radius">
                <a href="<?php echo esc_url($subpage_link); ?>">
                    <?php if (!$show_icon) { ?>
                        <div class="article-featured-img">
                            <?php echo $subpage_image; ?>
                        </div>
                    <?php } ?>
                    <div class="content text-center">
                    <?php if ($show_icon && !empty($icon_url)) { ?>
                        <div class="icon">
                            <?php echo $svg_content; // Output the SVG content directly ?>
                        </div>
                    <?php } ?>
                        <div class="web-heading">
                            <h2><?php echo esc_html($subpage_title); ?></h2>
                        </div>
                        <p><?php echo esc_html($subpage_excerpt); ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php }
} ?>


                    </div>
                </div>
            </div>
        </main>
    <?php endwhile;
endif;

get_footer();
?>
