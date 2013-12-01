<?php
/*
** プラグイン用TBL「PingResults」の構築用
*/

class PingResultsSchema extends CakeSchema {
        
        var $name = 'PingResults';
        var $file = 'ping_results.php';
        var $connection = 'plugin';

        function before($event = array()) {
                return true;
        }

        function after($event = array()) {
        }
        
        //テーブル作成
        var $ping_results = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
                'blog_content_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
                'result' => array('type' => 'text', 'null' => false, 'default' => NULL),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
                'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
                'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
        );
}

?>