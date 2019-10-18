<?php
/**
 * AppShell file
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Shell', 'Console');
App::uses('Sanitize', 'Utility');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
*/

class AppShell extends Shell {
  public $uses = array('Tenants');
  public function main() {

    $time_start = microtime(true);

    // 80エリア毎に分けたグループから最新更新日のレコードを抽出
    $request_count = 0;
    $dsn = 'pgsql:host=192.168.33.11;port=5432;dbname=dammy2;';
    $user = 'postgres';
    $password = '4318';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ];

    $dbh = new PDO($dsn, $user, $password, $options);

    $stmt = $dbh->prepare('SELECT id FROM updatingDB order by updated_at limit 1');
    $stmt->execute();
    $dammy = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $group_id = $dammy[0]['id'];

    $stmt2 = $dbh->prepare("UPDATE updatingDB SET updated_at = 'now()' WHERE id = :id");
    $stmt2->execute([':id' => $dammy[0]['id']]);


    // 全エリアSコード取得
    $url_area = 'https://api.gnavi.co.jp/master/GAreaSmallSearchAPI/v3/?keyid=f6baf12cf63b9fbaf19b92537291974b';
    $obj_area = json_decode(file_get_contents($url_area));
    $finish_areas = [];
    $area_s_slice = [];
    foreach ($obj_area->garea_small as $item) {
      $area_s[] = $item->areacode_s;
    }

    $keyid1 = 'f6baf12cf63b9fbaf19b92537291974b';
    $keyid2 = '681e7b34d6ac032d0609936ecde5f0f9';
    //エリアSコード80ずつ取得
    switch ($group_id) {
      case 1:
        $area_s_slice = array_slice($area_s, 0, 80);
        $keyid = $keyid1;
        break;
      case 2:
        $area_s_slice = array_slice($area_s, 80, 80);
        $keyid = $keyid2;
        break;
      case 3:
        $area_s_slice = array_slice($area_s, 160, 80);
        $keyid = $keyid1;
        break;
      case 4:
        $area_s_slice = array_slice($area_s, 240, 80);
        $keyid = $keyid2;
        break;
      case 5:
        $area_s_slice = array_slice($area_s, 320, 80);
        $keyid = $keyid1;
        break;
      case 6:
        $area_s_slice = array_slice($area_s, 400, 80);
        $keyid = $keyid2;
        break;
      case 7:
        $area_s_slice = array_slice($area_s, 480, 80);
        $keyid = $keyid1;
        break;
      case 8:
        $area_s_slice = array_slice($area_s, 560, 80);
        $keyid = $keyid2;
        break;
      case 9:
        $area_s_slice = array_slice($area_s, 640, 80);
        $keyid = $keyid1;
        break;
      case 10:
        $area_s_slice = array_slice($area_s, 720, 80);
        $keyid = $keyid2;
        break;
      case 11:
        $area_s_slice = array_slice($area_s, 800, 80);
        $keyid = $keyid1;
        break;
      case 12:
        $area_s_slice = array_slice($area_s, 880, 80);
        $keyid = $keyid2;
        break;
      case 13:
        $area_s_slice = array_slice($area_s, 960, 80);
        $keyid = $keyid1;
        break;
      case 14:
        $area_s_slice = array_slice($area_s, 1040, 80);
        $keyid = $keyid2;
        break;
      case 15:
        $area_s_slice = array_slice($area_s, 1120, 70);
        $keyid = $keyid1;
        break;
    }

      // DB修正処理
    foreach ($area_s_slice as $item) {
      // ぐるなびAPIの検索上限(〜1000件)まで100件ずつリクエスト投げてデータ取得
      for ($i = 1; $i <= 10; $i++) {
        $url = 'https://api.gnavi.co.jp/RestSearchAPI/v3/?keyid='.$keyid.'&hit_per_page=100&areacode_s='.$item.'&offset_page='.$i;
        $obj = json_decode(file_get_contents($url));
        $request_count++;
        var_dump($request_count);
        var_dump($item);

        foreach ($obj->rest as $data) {
          // ぐるなびAPI取得データとalikeデータの照合、店名合致するレコードの抽出
          $tenants = $this->Tenants->find('all', ['conditions' => ['name' => $data->name]]);
          if (count($tenants) == 0) {
            continue;
          }
          foreach ($tenants as $tenant) {
            // ぐるなびとalikeをデータ比較、『電話番号』が一致したらデータ修正処理実行
            if ($tenant["Tenants"]["telno"] != $data->tel) {
              continue;
            }
            $this->Tenants->updateAll(
              [
                'address_1' => "'".Sanitize::escape(substr_replace($data->address, '', 0, 12))."'",
                'note_hour' => "'".Sanitize::escape($data->opentime)."'",
                'note_holiday' => "'".Sanitize::escape($data->holiday)."'",
                'area_0_id' => "'".Sanitize::escape(substr($data->code->prefcode, -2, 2))."'",
                'updated_at' => "'".Sanitize::escape(date("Y-m-d H:i:s"))."'",
                'address_2' => null
              ],
              ['id' => $tenant["Tenants"]["id"]]
            );
            if ($data->longitude != null) {
              $this->Tenants->updateAll(['lng' => "'".Sanitize::escape($data->longitude)."'"],['id' => $tenant["Tenants"]["id"]]);
            }
            if ($data->latitude != null) {
              $this->Tenants->updateAll(['lat' => "'".Sanitize::escape($data->latitude)."'"], ['id' => $tenant["Tenants"]["id"]]);
            }
          }
        }
      }
    }
    $time = microtime(true) - $time_start;
    echo "処理時間：".sprintf("%.20f", $time)."秒\n処理完了エリア";
    // var_dump($finish_areas)."\n";
    echo "成功！\n";
  }
}/* End of AppShell */
