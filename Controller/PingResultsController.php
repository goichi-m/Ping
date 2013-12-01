<?php
/* 
 * baserCMS Plugin
 * ping送信　結果確認コントローラー
 *
 * @name            Ping
 * @link            http://blog.mani-lab.com/
 * @version         3.0.0
 * @lastmodified    2013-12-01
 *
 */
App::import('Controller', 'Plugins');
/********************************************
**
**　コントローラー
**
********************************************/
class PingResultsController extends BcPluginAppController {
/**
 * クラス名
 *
 * @var     string
 * @access  public
 */
    public $name = 'PingResults';
/**
 * モデル
 *
 * @var     array
 * @access  public
 */
    public $uses = array('Plugin', 'Ping.PingResult', 'Blog.BlogContent');
/**
 * コンポーネント
 *
 * @var     array
 * @access  public
 */
    public $components = array('BcAuth','Cookie','BcAuthConfigure','Paginator',);
/**
 * サブメニュー
 *
 * @var     array
 * @access  public
 */
    public $subMenuElements = array('ping');
/**
 * 一覧
 *
 * @return  void
 * @access  public
 */
    public function admin_index() {
        //モデルをバインドしてアソシエーション
        $this->BlogContent->bindModel(array(
            'hasOne' => array(
            'PingResult' => array(  
                'className'  => 'Ping.PingResult',  
                'foreignKey' => 'blog_content_id'
            )  
        )), false);
        //データの取得
        $this->Paginator->settings = array(
             'limit' => 20,
             'order' => array(
                  'BlogContent.id' => 'desc'
            ));
        $datas = $this->Paginator->paginate('BlogContent');
        $this->set("datas", $datas);
        //ページタイトル
        $this->pageTitle = 'Ping送信結果一覧';
    }
/**
 * 詳細
 *
 * @return  void
 * @access  public
 */
    public function admin_detail($blogContentID = null) {
        //IDが入っていない。
        if(empty($blogContentID)){
            $this->setMessage('IDの取得に失敗しました。', true);
            $this->redirect(array('controller' => 'PingResults' ,'action' => 'admin_index'));
        }
        //情報の取得
        $this->BlogContent->bindModel(array(
            'hasOne' => array(
            'PingResult' => array(  
                'className'  => 'Ping.PingResult',  
                'foreignKey' => 'blog_content_id'
            )  
        )), true);
        $blogContentData = $this->BlogContent->find('first', array('conditions'=>array(
            'BlogContent.id' => $blogContentID
        )));
        if(empty($blogContentData)){
            $this->setMessage('データの取得に失敗しました。', true);
            $this->redirect(array('controller' => 'PingResults' ,'action' => 'admin_index'));
        }
        $this->set('blogContentData', $blogContentData);
        $this->pageTitle = 'Ping送信結果';
    }
/**
 * 履歴の削除
 *
 * @return  void
 * @access  public
 */
    public function admin_delete($resultID = null) {
        //IDが入っていない。
        if(empty($resultID)){
            $this->setMessage('IDの取得に失敗しました。', true);
            $this->redirect(array('controller' => 'PingResults' ,'action' => 'admin_index'));
        }
        //初期化実行（レコード削除）
        if($this->PingResult->delete($resultID)){
                $this->PingResult->saveDbLog('Ping送信の履歴を削除しました。');
                $this->setMessage('Ping送信の履歴を削除しました。', false);
                $this->redirect(array('controller' => 'PingResults' ,'action' => 'admin_index'));
        }else{
                $this->setMessage('データの初期化に失敗しました', true);
                $this->redirect(array('controller' => 'PingResults' ,'action' => 'admin_index'));
        }
    }

}