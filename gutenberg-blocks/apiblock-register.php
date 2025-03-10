<?php
function your_namespace_render_block($attributes) {
    $html = '<div id="table-ajax-call-container">'.do_shortcode('[certificates_short_code]').'</div>';
    return  $html;
}
