<?php
/*
** プラグイン用TBL「PingConfigs」の構築用
*/
class PingConfigsSchema extends CakeSchema {
        
        var $name = 'PingConfigs';
        var $file = 'ping_configs.php';
        var $connection = 'plugin';

        function before($event = array()) {
                return true;
        }

        function after($event = array()) {
        }
        
        //テーブル作成
        var $ping_configs = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
                'blog_content_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
                'server' => array('type' => 'text', 'null' => false, 'default' => NULL),
                'update' => array('type' => 'integer', 'null' => false, 'default' => NULL),
                'valid' => array('type' => 'integer', 'null' => false, 'default' => NULL),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
                'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
                'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
        );
}

?>