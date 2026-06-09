<!-- Features Block Style1-->
<?php $skill_item['settings'] = $settings; ?>
<div class="skill-block-style1">
  <div class="inner-box">
    <?php shadhin_plugins_get_shortcode_template_part( 'icon-type', $skill_item['icon_type'], 'skill-block/tpl', $skill_item, false );?>
    <?php shadhin_plugins_get_shortcode_template_part( 'part-count', null, 'skill-block/tpl', $skill_item, false );?>
    <div class="content">
      <?php shadhin_plugins_get_shortcode_template_part( 'part-title', null, 'skill-block/tpl', $skill_item, false );?>
    </div>
  </div>
</div>