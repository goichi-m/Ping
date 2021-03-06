<?php
/* 
 * baserCMS Plugin
 * ping送信　結果格納用モデル
 *
 * @name            Ping
 * @link            http://blog.mani-lab.com/
 * @version         3.0.0
 * @lastmodified    2013-11-24
 *
 */
/********************************************
**
**　モデル
**
********************************************/
class PingResult extends PingAppModel {
/**
 * クラス名
 *
 * @var		string
 * @access	public
 */
	public $name = 'PingResult';
/**
 * DB接続設定
 *
 * @var		string
 * @access	public
 */
	public $useDbConfig = 'plugin';
/**
 * プラグイン名
 *
 * @var		string
 * @access	public
 */
	public $plugin = 'Ping';

}
