<?php
/* 
 * baserCMS Plugin
 * ping送信　設定コントローラー
 *
 * @name            Ping
 * @link            http://blog.mani-lab.com/
 * @version         3.0.0
 * @lastmodified    2013-11-24
 *
 */
App::import('Controller', 'Plugins');
/********************************************
**
**　コントローラー
**
********************************************/
class PingConfigsController extends BcPluginAppController {
/**
 * クラス名
 *
 * @var		string
 * @access	public
 */
	public $name = 'PingConfigs';
/**
 * モデル
 *
 * @var		array
 * @access	public
 */
	public $uses = array('Plugin', 'Ping.PingConfig', 'Blog.BlogContent');
/**
 * コンポーネント
 *
 * @var		array
 * @access	public
 */
	public $components = array('BcAuth','Cookie','BcAuthConfigure','Paginator');

/**
 * サブメニュー
 *
 * @var		array
 * @access	public
 */
	public $subMenuElements = array('ping');
/**
 * 設定一覧
 *
 * @return	void
 * @access	public
 */
	public function admin_index() {
		$datas = $this->BlogContent->find('all');
		$this->set("datas", $datas);
		//ページタイトル
		$this->pageTitle = 'Ping送信設定一覧';
	}
/**
 * 設定の変更
 *
 * @return	void
 * @access	public
 */
	public function admin_edit($blogContentID = null) {
		//ブログのIDが入っていない。
		if(empty($blogContentID)){
			$this->setMessage('IDの取得に失敗しました。', true);
			$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}
		//ブログデータの取得
		$blogContentData = $this->BlogContent->find('first', array('conditions'=>array(
			'BlogContent.id' => $blogContentID
		)));
		if(empty($blogContentData)){
			$this->setMessage('データの取得に失敗しました。', true);
			$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}else{
			$this->set('blogContentData', $blogContentData);
		}
		//更新ボタンの押下
		if(!empty($this->request->data)){
			//データ整形の為に変数へ代入
			$insertData = $this->request->data;
			$insertData['PingConfig']['blog_content_id'] = $blogContentID;
			if($this->PingConfig->save($insertData)){
				$this->PingConfig->saveDbLog($blogContentData['BlogContent']['title'].'のPing送信設定を更新しました。');
				$this->setMessage('設定を更新しました。', false);
				$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
			}else{
				$this->setMessage('データの保存に失敗しました', true);
				$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
			}

		//更新実行前
		} else {
			//現在の設定を取得
			$pingConfigData = $this->PingConfig->find('first', array(
				'conditions' => array(
					'PingConfig.blog_content_id' => $blogContentID
				)));
			//データ設定
			$this->request->data = $pingConfigData;
			$this->set('pingConfigData', $pingConfigData);
		}
		
		//ページタイトル
		$this->pageTitle = 'Ping送信設定';
		//レンダー
		$this->render('form');
	}
/**
 * 設定の初期化
 *
 * @return	void
 * @access	public
 */
	public function admin_delete($pingConfigID = null) {
		//IDが入っていない。
		if(empty($pingConfigID)){
			$this->setMessage('IDの取得に失敗しました。', true);
			$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}
		//データ取得
		$pingConfigData = $this->PingConfig->find('first', array('conditions' => array(
			'PingConfig.id' => $pingConfigID
		)));
		$blogContentData = $this->BlogContent->find('first', array('conditions' => array(
			'BlogContent.id' => $pingConfigData['PingConfig']['blog_content_id']
		)));
		//取得失敗
		if(empty($pingConfigData) || empty($blogContentData)){
			$this->setMessage('データの取得に失敗しました。', true);
			$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}
		//初期化実行（レコード削除）
		if($this->PingConfig->delete($pingConfigID)){
				$this->PingConfig->saveDbLog($blogContentData['BlogContent']['title'].'のPing送信設定を初期化しました。');
				$this->setMessage('設定を初期化しました。', false);
				$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}else{
				$this->setMessage('データの初期化に失敗しました', true);
				$this->redirect(array('controller' => 'PingConfigs' ,'action' => 'admin_index'));
		}

	}


}