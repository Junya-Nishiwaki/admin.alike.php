<?php
$this->Html->css(array('bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
                            'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        'admin'),
        null, array('inline' => false));
$this->Html->script(array('jquery-1.8.3.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
                        'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
                        'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
                        'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
                        'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
        ),
        array('inline' => false));

// 全エリアSコード取得
$url_area = 'https://api.gnavi.co.jp/master/GAreaSmallSearchAPI/v3/?keyid=01003da548ac6dd26de062ceac2a69aa';
$obj_area = json_decode(file_get_contents($url_area));
$area_s = [];
foreach ($obj_area->garea_small as $item) {
  $area_s[] = $item->areacode_s;
}

// DB修正処理
foreach ($area_s as $item) {
  for ($i = 1; $i <= 10; $i++) {
    $url = 'https://api.gnavi.co.jp/RestSearchAPI/v3/?keyid=01003da548ac6dd26de062ceac2a69aa&hit_per_page=100&areacode_s='.$item.'&offset_page='.$i;
    $obj = json_decode(file_get_contents($url));

    if (isset($obj)) {
      foreach ($tenants as $tenant) {
        foreach ($obj->rest as $data) {
          if (
            $tenant['name'] == $data->name && $tenant['address_1'].$tenant['address_2'] == $data->address
          ) {
            $tenant['name_kana'] = $data->name_kana;
            $tenant['name_kana'] = $data->name_kana;
            $tenant['name_kana'] = $data->name_kana;
            $tenant['name_kana'] = $data->name_kana;
          }
        }
      }
    }
  }
}
