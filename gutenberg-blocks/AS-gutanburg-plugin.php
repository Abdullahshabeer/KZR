<?php
/*
  Plugin Name: Bloki autorskie nFinity.pl
  Version: 0.1
  Author: nFinity.pl
  Author URI: 
  Text Domain: nFinity.pl
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class gautanbarg_block {
  function __construct() {
    $this->gautan_Blocks_define_constants();
    add_action('init', array($this, 'gautanb'));
    add_filter('block_categories', array($this, 'custom_block_category'), 10, 2);
    add_action('admin_menu', array($this, 'add_settings_page'));
    add_action('admin_init', array($this, 'register_settings'));
  }

  private function define($name, $value) {
    if ( ! defined($name) ) {
      define($name, $value);
    }
  }

  private function gautan_Blocks_define_constants() {
    $this->define('gautan_Blocks_PLUGIN_FILE', plugin_dir_path(__FILE__));
    $this->define('gautan_Blocks_BASE_URL', plugin_dir_url(__FILE__));
  }
  
  function gautanb() {
    $strings = array(
      'list'                                => get_option('list', __('Home Banner', 'KZR')),
      'banner_title'                        => get_option('banner_title', __('Banner Title', 'KZR')),
      'banner_discription'                  => get_option('banner_discription', __('Banner Discription', 'KZR')),
      'backgrounimage'                      => get_option('backgrounimage', __('Background image', 'KZR')),
      'shortcut'                            => get_option('shortcut', __('Banner shortcut', 'KZR')),
      'shortcuttitle'                       => get_option('shortcuttitle', __('shortcut Title', 'KZR')),
      'shortcutlink'                        => get_option('shortcutlink', __('shortcut link', 'KZR')),
      'shorticon'                           => get_option('shorticon', __('Add icon', 'KZR')),
      'list_remove'                         => get_option('list_remove', __('remove Item', 'KZR')),
      'list_add_iteme'                      => get_option('list_add_iteme', __('add Item', 'KZR')),
      'Select_an_image'                     =>  get_option('Select_an_image', __('Select image', 'KZR')),
      'Na_skrty'                            =>  get_option('Na_skrty', __('Na skróty', 'KZR')),
      'Selectapost_type'                    =>get_option('Selectapost_type', __('select post type' , 'KZR' )),
      'post_section_Title'                  =>get_option('post_section_Title', __('post title' , 'KZR' )),
      'post_per_page'                       =>get_option('post_per_page', __('post per page' , 'KZR' )),
      'section_button'                      =>get_option('section_button', __('posts button' , 'KZR' )),
      'Select_a_category'                   =>get_option('Select_a_category', __('select categories' , 'KZR' )),
      'Button_link'                         =>get_option('Button_link', __('post button url' , 'KZR' )),
      'homepage_new_block'                  =>get_option('homepage_new_block', __('Home page new block' , 'KZR' )),
      'BUtton_Title'                        =>get_option('BUtton_Title', __('Button title' , 'KZR' )),
      'Select_Post_Type'                    =>get_option('Select_Post_Type', __('Select Post Type' , 'KZR' )),
      'homepage_szkolenia_block'             =>get_option('homepage_szkolenia_block', __('szkolenia Posts' , 'KZR' )),
      'Select_Category'                     =>get_option('Select_Category', __('Select Category' , 'KZR' )),
      'Informacja_heading_style'            =>get_option('Informacja_heading_style', __('Heading style' , 'KZR' )),
       'Informacja_Heading'                 =>get_option('Informacja_Heading', __('Heading' , 'KZR' )),
       'Informacja_inner_button'           =>get_option('Informacja_inner_button', __('inner button' , 'KZR' )),
       'Informacja_button_color'           =>get_option('Informacja_button_color', __('Button color' , 'KZR' )),
       'Informacja_sectiont_title'         =>get_option('Informacja_sectiont_title', __('sectiont title' , 'KZR' )),
       'Informacja_headerdivider'          =>get_option('Informacja_headerdivider', __('header divider' , 'KZR' )),
       'Informacja_Enter_a_description'    =>get_option('Informacja_Enter_a_description', __('Enter a description' , 'KZR' )),
       'Informacja_Delete_Image'          =>get_option('Informacja_Delete_Image', __('Delete Image' , 'KZR' )),
       'Informacja_Select_an_image'       =>get_option('Informacja_Select_an_image', __('Select an image' , 'KZR' )),
       'image_section_block'              =>get_option('image_section_block', __('image section block' , 'KZR' )),
       'image_title_block'                =>get_option('image_title_block', __('image title block' , 'KZR' )),
       'Zobacz'                           =>get_option('Zobacz', __('Zobacz strukturę w nowym oknie' , 'KZR' )),
       'image_title'                      => get_option('image_title',  __('image Title', 'KZR')),
       'image_title_block'                => get_option('image_title_block', __('image Title block', 'KZR')),
      'faq_section_title'                 =>get_option('faq_section_title', __('FAQ section title' , 'KZR' )),
       'accordion'                        =>get_option('accordion', __('FAQ accordione' , 'KZR' )),
       'faq_title'                        =>get_option('faq_title', __('FAQ Title' , 'KZR' )),
       'Delete_a_section'                 =>get_option('Delete_a_section', __('Delete section' , 'KZR' )),
       'add_sectiont'                     =>get_option('add_sectiont', __('ADD section' , 'KZR' )),
       'Enter_a_description'              =>get_option('Enter_a_description', __('Enter Description' , 'KZR' )),
       'scop_certifaction'                 =>get_option('scop_certifaction', __('icon image ' , 'KZR' )),
       'selected_design_size'             =>get_option('selected_design_size', __('select size ' , 'KZR' )),
       'design_size'                      =>get_option('design_size', __(' size ' , 'KZR' )),
       'imageicon'                        =>get_option('imageicon', __(' image/icon' , 'KZR' )),
       'addmedia'                        =>get_option('addmedia', __(' add media' , 'KZR' )),
       'blocktitle'                       =>get_option('blocktitle', __(' Block Title' , 'KZR' )),
       'blockdiscription'                =>get_option('blockdiscription', __('Block discription' , 'KZR' )),
       'blocklink'                       =>get_option('blocklink', __('Block link' , 'KZR' )),
       'block_remove'                   =>get_option('block_remove', __('Block remove' , 'KZR' )),
       'block_add'                      =>get_option('block_add', __('Block add' , 'KZR' )),
       'image_position'                  =>get_option('image_position', __('Położenie obrazka' , 'KZR' )),
       'background'                     =>get_option('background', __('Tło' , 'KZR' )),
       'selected_image_position'        =>get_option('selected_image_position', __('selected image position' , 'KZR' )),
       'selected_background'            =>get_option('selected_background', __('selected background' , 'KZR' )),
       'kodzakres'                     =>get_option('kodzakres', __('kod zakres' , 'KZR' )),
       'Kod'                           =>get_option('Kod', __('kod' , 'KZR' )),
       'Zakres'                        =>get_option('Zakres', __('Zakres' , 'KZR' )),
       'add_Zakres'                    =>get_option('add_Zakres', __('add Zakres' , 'KZR' )),
       'remove_Zakres'                 =>get_option('remove_Zakres', __('remove Zakres' , 'KZR' )),
       'defaultkod'                    =>get_option('defaultkod', __('Kod' , 'KZR' )),
       'defaultZakres'                =>get_option('defaultZakres', __('Zakres' , 'KZR' )),
       'Infographi'                   =>get_option('Infographi', __('Infographic' , 'KZR' )),
       'Infographic'                 =>get_option('Infographic', __('Infographic' , 'KZR' )),
       'progressbar'                =>get_option('progressbar', __('progressbar size' , 'KZR' )),
       'backgroundcolor'       =>get_option('backgroundcolor', __('Background color' , 'KZR' )),
       'Infographic_title'       =>get_option('Infographic_title', __('Infographic Title' , 'KZR' )),
       'Infographic_Select_an_image'       =>get_option('Infographic_Select_an_image', __('Select an image' , 'KZR' )),
       'Infographic_discription'       =>get_option('Infographic_discription', __('Infographic discription' , 'KZR' )),
       'Infographic_remove'       =>get_option('Infographic_remove', __('Infographic remove' , 'KZR' )),
       'Infographic_add'       =>get_option('nfographic_add', __('Infographic add' , 'KZR' )),
       'certification'       =>get_option('certification', __('Certification bodies' , 'KZR' )),
       'AccordionTitle'       =>get_option('AccordionTitle', __('Accordion Title' , 'KZR' )),
       'Accordion_add_logo'       =>get_option('Accordion_add_logo', __('Add logo' , 'KZR' )),
       'Accordion_remove_remove'       =>get_option('Accordion_remove_remove', __('Remove logo' , 'KZR' )),
       'accordion_discription'       =>get_option('accordion_discription', __('Accordion discription' , 'KZR' )),
       'accordion_Thumbnail'       =>get_option('accordion_Thumbnail', __('Accordion Thumbnail' , 'KZR' )),
       'add_Thumbnail'       =>get_option('add_Thumbnail', __('Add Thumbnail' , 'KZR' )),
       'remove_Thumbnail'       =>get_option('remove_Thumbnail', __('Remove Thumbnail' , 'KZR' )),
       'Thumbnail_Title'       =>get_option('Thumbnail_Title', __('Thumbnail Title' , 'KZR' )),
       'Thumbnail_second_Title'       =>get_option('Thumbnail_second_Title', __('Thumbnail  second Title' , 'KZR' )),
       'Thumbnail_Link'       =>get_option('Thumbnail_Link', __('Thumbnail  link' , 'KZR' )),
       'add_accordion_sectiont'       =>get_option('add_accordion_sectiont', __('Add accordion sectiont' , 'KZR' )),
       'remove_accordion_sectiont'       =>get_option('remove_accordion_sectiont', __('remove accordion sectiont' , 'KZR' )),
       'accordion_logo'       =>get_option('accordion_logo', __('Accordion logo' , 'KZR' )),
       'link'       =>get_option('link', __('Szybkie Linki' , 'KZR' )),
       'link_icon'       =>get_option('link_icon', __('select link icon' , 'KZR' )),
       'link_content'       =>get_option('link_content', __('link title' , 'KZR' )),
       'link_url'       =>get_option('link_url', __('link url' , 'KZR' )),
       'remove_link' => get_option('remove_link', __('Remove link', 'KZR')),
        'add_link' => get_option('add_link', __('add link', 'KZR')),
        'document' => get_option('document', __('Document', 'KZR')),
        'liczba' => get_option('liczba', __('liczba dokumentów na stronie:', 'KZR')),
        'zatrzymaj'                           => get_option('zatrzymaj', __('zatrzymaj animację', 'KZR')),
        'zagraj'                           => get_option('zagraj', __('zagraj animację', 'KZR')),
        'tab_title' => get_option('tab_title', __('Tab title', 'KZR')),
        'tab_inner_link_title' => get_option('tab_inner_link_title', __('Tab inner link title', 'KZR')),
        'tab_inner_link_icon' => get_option('tab_inner_link_icon', __('Tab inner link icon', 'KZR')),
        'tab_inner_link_url' => get_option('tab_inner_link_url', __('Tab inner link url', 'KZR')),
        'tab_inner_icon_button' => get_option('tab_inner_icon_button', __('Tab inner icon button', 'KZR')),
        'add_icon' => get_option('add_icon', __('add icon', 'KZR')),
        'change_icon' => get_option('change_icon', __('change icon', 'KZR')),
        'add_new_teb' => get_option('add_new_teb', __('add new tab', 'KZR')),
        'remove_teb' => get_option('remove_teb', __('remove tab', 'KZR')),
        'add_link' => get_option('add_link', __('add link', 'KZR')),
        'remove_link' => get_option('remove_link', __('remove link', 'KZR')),
        'tab' => get_option('tab', __('tab', 'KZR')),
        'linknumber' => get_option('linknumber', __('link', 'KZR')),
        'kontakt_block' => get_option('kontakt_block', __('Kontakt', 'KZR')),
        'mapshortcode' => get_option('mapshortcode', __('Obraz', 'KZR')),
        'Section_headin' => get_option('Section_headin', __('select heading', 'KZR')),
        'Heading' => get_option('Heading', __('Heading', 'KZR')),
        'heading_style' => get_option('heading_style', __('heading style', 'KZR')),
        'sectiontt' => get_option('sectiontt', __('heading title', 'KZR')),
        'headerdivider' => get_option('headerdivider', __('heading divider', 'KZR')),
        'sectiontcontent' => get_option('sectiontcontent', __('section content', 'KZR')),
        'select_video' => get_option('Nselect_video', __('select video', 'KZR')),
        'bannervideo' => get_option('bannervideo', __('banner video', 'KZR')),
        'differentdesign_block' => get_option('differentdesign_block', __('Unijna post', 'KZR')),
        'api_table' => get_option('rect_table', __('Rect Table ', 'KZR')),
        'apitoken' => get_option('apitoken', __('Api Token ', 'KZR')),
        'Bold_discription' => get_option('Bold_discription', __('Bold ', 'KZR')),
        'Break_discription' => get_option('Break_discription', __('Break ', 'KZR')),
        'Link_discription' => get_option('Link_discription', __('Link ', 'KZR')),
        'choose_file' => get_option('choose_file', __('Choose file ', 'KZR')),
        'button_content' => get_option('button_content', __('przechodzenie miedzy kategoriami strzałkami bocznymi ', 'KZR')),
    );

    $site_url = site_url();
    $svg_url = gautan_Blocks_BASE_URL . 'images/images.jpeg';
    $icon = gautan_Blocks_BASE_URL . 'images/icon.svg';
    $right = gautan_Blocks_BASE_URL . 'images/right.svg';
    $file_icon = gautan_Blocks_BASE_URL . 'images/file-icon.svg';
    $icontsvg = gautan_Blocks_BASE_URL . 'images/icontsvg.svg';
    wp_register_script('gautanbscript', gautan_Blocks_BASE_URL . 'build/index.js', array('wp-blocks', 'wp-components', 'wp-element', 'wp-api', 'wp-editor', 'wp-i18n'), false, true);
   
    register_block_type('kzr-namespace/api-table', array(
      'editor_script' => 'gautanbscript',
      'render_callback' => 'your_namespace_render_block',
  ));

    
    wp_localize_script('gautanbscript', 'myBlockData', array(
      'strings' => $strings,
      'defaultimge' => $svg_url,
      'icon' => $icon,
      'siteUrl' => $site_url,
      'right'  => $right,
      'file_icon'  => $file_icon,
      'icontsvg'  => $icontsvg
    ));

    register_block_type('myguten-block/block-name', array(
      'editor_script' => 'gautanbscript',
      'editor_style' => 'gautanbStyle',
      'style' => 'gautanbFrontendStyles'
    ));
  }
  
  function custom_block_category($categories, $post) {
    return array_merge(
      $categories,
      array(
        array(
          'slug' => 'my-custom-category',
          'title' => __('KZR block', 'KZR'),
          'icon' => 'wordpress',
        )
      )
    );
  }

  function add_settings_page() {
    add_options_page(
      __('Custom Strings', 'KZR'),
      __('Custom Strings', 'KZR'),
      'manage_options',
      'gautanb-strings',
      array($this, 'settings_page_content')
    );
  }

  function register_settings() {
    // Add a settings section
    add_settings_section(
        'gautanb_settings_section',
        __('Custom Strings', 'KZR'),
        null,
        'gautanb-strings'
    );

    $strings = array(
        'button_content' =>  __('przechodzenie miedzy kategoriami strzałkami bocznymi ', 'KZR'),
        'list' => __('Home Banner', 'KZR'),
        'banner_title' => __('Banner Title', 'KZR'),
        'banner_discription' => __('Banner Discription', 'KZR'),
        'backgrounimage' => __('Background image', 'KZR'),
        'shortcut' => __('Banner shortcut', 'KZR'),
        'shortcuttitle' => __('shortcut Title', 'KZR'),
        'shortcutlink' => __('shortcut link', 'KZR'),
        'shorticon' => __('Add icon', 'KZR'),
        'list_remove' => __('remove Item', 'KZR'),
        'list_add_iteme' => __('add Item', 'KZR'),
        'Select_an_image' => __('select image', 'KZR'),
        'Na_skrty'                       => __('Na skróty', 'KZR'),
        'Selectapost_type'               =>__('select post type' , 'KZR' ),
        'post_section_Title'             =>__('post title' , 'KZR' ),
        'liczba'                           => __('liczba dokumentów na stronie:', 'KZR'),
        'zatrzymaj'                           => __('zatrzymaj animację', 'KZR'),
        'zagraj'                           => __('zagraj animację', 'KZR'),
        'post_per_page'                  =>__('post per page' , 'KZR' ),
        'section_button'                 =>__('posts button' , 'KZR' ),
        'Select_a_category'              =>__('select categories' , 'KZR' ),
        'Button_title'                   =>__('post button url' , 'KZR' ),
        'homepage_new_block'             =>__('Home page new block' , 'KZR' ),
        'BUtton_Title'                  =>__('Button title' , 'KZR' ),
        'Select_Post_Type'              =>__('Select Post Type' , 'KZR' ),
        'homepage_szkolenia_block'              =>__('szkolenia Posts' , 'KZR' ),
        'Select_Category'              =>__('Select Category' , 'KZR' ),
        'Informacja_heading_style'       =>__('Heading style' , 'KZR' ),
         'Informacja_Heading'             =>__('Heading' , 'KZR' ),
         'Informacja_inner_button'        =>__('inner button' , 'KZR' ),
         'Informacja_button_color'        =>__('Button color' , 'KZR' ),
         'Informacja_sectiont_title'      =>__('sectiont title' , 'KZR' ),
         'Informacja_headerdivider'       =>__('header divider' , 'KZR' ),
         'Informacja_Enter_a_description' =>__('Enter a description' , 'KZR' ),
         'Informacja_Delete_Image'        =>__('Delete Image' , 'KZR' ),
         'Informacja_Select_an_image'     =>__('Select an image' , 'KZR' ),
         'image_section_block'       =>__('image section block' , 'KZR' ),
         'image_title_block'       =>__('image title block' , 'KZR' ),
         'Zobacz'       =>__('Zobacz strukturę w nowym oknie' , 'KZR' ),
         'image_title' =>  __('image Title', 'KZR'),
         'image_title_block' =>  __('image Title block', 'KZR'),
        'faq_section_title'       =>__('FAQ section title' , 'KZR' ),
         'accordion'       =>__('FAQ accordione' , 'KZR' ),
         'faq_title'       =>__('FAQ Title' , 'KZR' ),
         'Delete_a_section'       =>__('Delete section' , 'KZR' ),
         'add_sectiont'       =>__('ADD section' , 'KZR' ),
         'Enter_a_description'       =>__('Enter Description' , 'KZR' ),
         'scop_certifaction'       =>__('icon image ' , 'KZR' ),
         'selected_design_size'       =>__('select size ' , 'KZR' ),
         'design_size'       =>__(' size ' , 'KZR' ),
         'imageicon'       =>__(' image/icon' , 'KZR' ),
         'addmedia'       =>__(' add media' , 'KZR' ),
         'blocktitle'       =>__(' Block Title' , 'KZR' ),
         'blockdiscription'       =>__('Block discription' , 'KZR' ),
         'blocklink'       =>__('Block link' , 'KZR' ),
         'block_remove'       =>__('Block remove' , 'KZR' ),
         'block_add'       =>__('Block add' , 'KZR' ),
         'image_position'       =>__('Położenie obrazka' , 'KZR' ),
         'background'       =>__('Tło' , 'KZR' ),
         'selected_image_position'       =>__('selected image position' , 'KZR' ),
         'selected_background'       =>__('selected background' , 'KZR' ),
         'kodzakres'       =>__('kod zakres' , 'KZR' ),
         'Kod'       =>__('kod' , 'KZR' ),
         'Zakres'       =>__('Zakres' , 'KZR' ),
         'add_Zakres'       =>__('add Zakres' , 'KZR' ),
         'remove_Zakres'       =>__('remove Zakres' , 'KZR' ),
         'defaultkod'       =>__('Kod' , 'KZR' ),
         'defaultZakres'       =>__('Zakres' , 'KZR' ),
         'Infographi'       =>__('Infographic' , 'KZR' ),
         'Infographic'       =>__('Infographic' , 'KZR' ),
         'progressbar'       =>__('progressbar size' , 'KZR' ),
         'backgroundcolor'       =>__('Background color' , 'KZR' ),
         'Infographic_title'       =>__('Infographic Title' , 'KZR' ),
         'Infographic_Select_an_image'       =>__('Select an image' , 'KZR' ),
         'Infographic_discription'       =>__('Infographic discription' , 'KZR' ),
         'Infographic_remove'       =>__('Infographic remove' , 'KZR' ),
         'Infographic_add'       =>__('Infographic add' , 'KZR' ),
         'certification'       =>__('Certification bodies' , 'KZR' ),
         'AccordionTitle'       =>__('Accordion Title' , 'KZR' ),
         'Accordion_add_logo'       =>__('Add logo' , 'KZR' ),
         'Accordion_remove_remove'       =>__('Remove logo' , 'KZR' ),
         'accordion_discription'       =>__('Accordion discription' , 'KZR' ),
         'accordion_Thumbnail'       =>__('Accordion Thumbnail' , 'KZR' ),
         'add_Thumbnail'       =>__('Add Thumbnail' , 'KZR' ),
         'remove_Thumbnail'       =>__('Remove Thumbnail' , 'KZR' ),
         'Thumbnail_Title'       =>__('Thumbnail Title' , 'KZR' ),
         'Thumbnail_second_Title'       =>__('Thumbnail  second Title' , 'KZR' ),
         'Thumbnail_Link'       =>__('Thumbnail  link' , 'KZR' ),
         'add_accordion_sectiont'       =>__('Add accordion sectiont' , 'KZR' ),
         'remove_accordion_sectiont'       =>__('remove accordion sectiont' , 'KZR' ),
         'accordion_logo'       =>__('Accordion logo' , 'KZR' ),
         'link'       =>__('Szybkie Linki' , 'KZR' ),
         'link_icon'       =>__('select link icon' , 'KZR' ),
         'link_content'       =>__('link title' , 'KZR' ),
         'link_url'       =>__('link url' , 'KZR' ),
         'remove_link' => __('Remove link', 'KZR'),
          'add_link' => __('add link', 'KZR'),
          'document' => __('Document', 'KZR'),
          'tab_title' => __('Tab title', 'KZR'),
          'tab_inner_link_title' => __('Tab inner link title', 'KZR'),
          'tab_inner_link_icon' => __('Tab inner link icon', 'KZR'),
          'tab_inner_link_url' => __('Tab inner link url', 'KZR'),
          'tab_inner_icon_button' => __('Tab inner icon button', 'KZR'),
          'add_icon' => __('add icon', 'KZR'),
          'change_icon' => __('change icon', 'KZR'),
          'add_new_teb' => __('add new tab', 'KZR'),
          'remove_teb' => __('remove tab', 'KZR'),
          'add_link' => __('add link', 'KZR'),
          'remove_link' => __('remove link', 'KZR'),
          'tab' => __('tab', 'KZR'),
          'linknumber' => __('link', 'KZR'),
          'kontakt_block' => __('Kontakt', 'KZR'),
          'mapshortcode' => __('Obraz', 'KZR'),
          'Section_headin' => __('select heading', 'KZR'),
          'Heading' => __('Heading', 'KZR'),
          'heading_style' => __('heading style', 'KZR'),
          'sectiontt' => __('heading title', 'KZR'),
          'headerdivider' => __('heading divider', 'KZR'),
          'sectiontcontent' => __('section content', 'KZR'),
          'select_video' => __('select video', 'KZR'),
          'bannervideo' => __('banner video', 'KZR'),
          'differentdesign_block' => __('Unijna post', 'KZR'),
          'rect_table' => __('Rect Table', 'KZR'),
          'apitoken' =>  __('Api Token ', 'KZR'),
          'Bold_discription'=>  __('Bold ', 'KZR'),
          'Break_discription'=> __('Break ', 'KZR'),
          'Link_discription'=> __('Link ', 'KZR'),
          'choose_file'=> __('Choose file ', 'KZR'),
        
    );

    foreach ($strings as $key => $default) {
      register_setting('gautanb_settings_group', $key, array(
          'type' => 'string',
          'sanitize_callback' => 'sanitize_text_field',
          'default' => $default,
      ));

      add_settings_field(
          $key,
          $default,
          function() use ($key, $default) {
              $value = get_option($key, '');
              $value = !empty($value) ? $value : $default;
              echo "<input type='text' name='$key' value='" . esc_attr($value) . "' class='regular-text' />";
          },
          'gautanb-strings',
          'gautanb_settings_section'
      );
    }
  }

  function settings_page_content() {
    ?>
    <div class="wrap">
      <h1><?php _e('Custom Strings', 'KZR'); ?></h1>
      <form method="post" action="options.php">
        <?php
        settings_fields('gautanb_settings_group');
        do_settings_sections('gautanb-strings');
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }
}

new gautanbarg_block();
include_once plugin_dir_path(__FILE__) . 'apiblock-register.php';

?>
