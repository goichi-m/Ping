<?php
class PingBaserHelper extends AppHelper {

/**
 * 設定情報取得ヘルパー
 *
 * @param int $blogContentId
 * @return array $data
 * @access public
 */
    public function getPingSetting($blogContentId = null){
        //除外処理
        if (empty($blogContentId)) {
            return false;
        }
        //データ取得　モデル利用
        App::import("Model", "Ping.PingConfig");
        $pingConfigModel = new PingConfig;
        $data = $pingConfigModel->find('first', array('conditions' => array(
            'PingConfig.blog_content_id' => $blogContentId
        )));
        //データを返す。
        if (empty($data)) {
            return false;
        } else {
            return $data;
        }
    }
}