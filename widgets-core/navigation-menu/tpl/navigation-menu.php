<?php
if ($mh_menu_selected) {

  $icon = "";
  if(isset($list_icon['value']) && !empty($list_icon['value'])) {
    $icon = '<i class="mh-nav-arrow-icon '.$list_icon['value'].'"></i>';
  }
  $args = [
    'menu'        => $mh_menu_selected,
    'menu_class'  => implode(' ', array_filter($classes)),
    'fallback_cb' => '__return_empty_string',
    'container'   => false,
    'link_before'   => $icon,
    'echo'        => false,
  ];
  echo '<div class="mh-sc-simple-nav-menu">' . wp_nav_menu($args) . '</div>';
}
?>
