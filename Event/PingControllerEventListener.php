<?php
/* 
 * baserCMS Plugin
 * ping送信　イベントリスナー
 *
 * @name            Ping
 * @link            http://blog.mani-lab.com/
 * @version         3.0.0
 * @lastmodified    2013-12-01
 *
 */
/********************************************
**
**　イベントリスナー　コントローラー
**
********************************************/
class PingControllerEventListener extends BcControllerEventListener {
    /* イベント登録 */
    public $events = array(
            'Blog.BlogPosts.afterAdd', //新規登録
            'Blog.BlogPosts.afterEdit' //既存編集
            );
    /**
     * 新規記事登録時のPing送信
     *
     * @return  void
     * @access  public
     */
     public function blogBlogPostsAfterAdd(CakeEvent $event) {
        //記事が公開（status:1）の時のみ処理に入る。
        if($event->data['data']['BlogPost']['status'] == 1){
            //プラグインのモデルをインポート
            App::import('Model', 'Ping.PingConfig'); 
            $pingConfigModel = new PingConfig();
            //記事が投稿されたブログID取得
            $blogContetID = $event->data['data']['BlogPost']['blog_content_id'];
            //Ping送信設定情報を取得
            $pingConfigData = $pingConfigModel->find('first', array('conditions'=>array(
                'blog_content_id' => $blogContetID
            )));
            //設定データが取得できない場合（＝初期値のまま）
            if(empty($pingConfigData)){
                return; //何もしない
            }else{
                //利用設定を確認する
                if($pingConfigData['PingConfig']['valid'] == 0){
                    return; //何もしない
                }elseif($pingConfigData['PingConfig']['valid'] == 1){
                    //結果格納用モデル
                    App::import('Model', 'Ping.PingResult'); 
                    $pingResultModel = new PingResult();
                    //送信準備
                    $title = $event->data['data']['BlogContent']['title']; //ブログタイトル
                    $url = $this->__getBlogUrl($event->data['data']['BlogContent']['name']); //ブログURL
                    $targets = $this->__getTargetServers($pingConfigData['PingConfig']['server']);
                    $resultsData = array(); //結果格納用変数
                    $resultsData['PingResult']['blog_content_id'] = $blogContetID;
                    $resultsData['PingResult']['result'] = '';
                    //送信実行処理
                    foreach ($targets as $target) {
                        $host = $this->__getPinServerHostName($target); //ホスト名取得
                        $path = $this->__getPinServerPath($target); //パス取得
                        //送信実行と結果の取得
                        $result = $this->__pingSending($host, $path, $title, $url);
                        //結果は一行で帰ってくる為、一旦、改行コードで配列化して処理しやすくする。
                        $resultArray = explode("\n",$result);
                        //中身を確認するが、タイムアウトなどで一部が不完全な返信がある。
                        if($resultArray[0] == ''){
                            $resultArray[0] = 'ERROR（応答なし）';
                        }
                        //結果保存用に追記する。
                        $resultsData['PingResult']['result'] .= $target.'<br />実行結果：'.$resultArray[0].'<br /><br />';
                    }
                    //結果の格納
                    //まずは既に結果の入ったレコードがあるかどうか確認する（最新1件のみ保存のため）
                    $resultDataFirst = $pingResultModel->find('first', array('conditions' => array(
                        'blog_content_id' => $blogContetID
                    )));
                    //データのある場合は上書き
                    if(empty($resultDataFirst['PingResult']['id'])){
                        //新規登録
                        $pingResultModel->create();
                        $resultsData['PingResult']['id'] = '';
                        $pingResultModel->save($resultsData);
                        return;
                    }else{
                        //上書き保存（IDの指定）
                        $resultsData['PingResult']['id'] = $resultDataFirst['PingResult']['id'];
                        //保存実行
                        $pingResultModel->save($resultsData);     
                        return;                       
                    }
                }
            }
        }else{
            return;
        }
     }
    /**
     * 既存記事編集時のPing送信
     *
     * @return  void
     * @access  public
     */
     public function blogBlogPostsAfterEdit(CakeEvent $event) {
        //記事が公開（status:1）の時のみ処理に入る。
        if($event->data['data']['BlogPost']['status'] == 1){
            //プラグインのモデルをインポート
            App::import('Model', 'Ping.PingConfig'); 
            $pingConfigModel = new PingConfig();
            //記事が投稿されたブログID取得
            $blogContetID = $event->data['data']['BlogPost']['blog_content_id'];
            //Ping送信設定情報を取得
            $pingConfigData = $pingConfigModel->find('first', array('conditions'=>array(
                'blog_content_id' => $blogContetID
            )));
            //設定データが取得できない場合（＝初期値のまま）
            if(empty($pingConfigData)){
                return; //何もしない
            }else{
                //利用設定を確認する
                if($pingConfigData['PingConfig']['valid'] == 0){
                    return; //何もしない
                }elseif($pingConfigData['PingConfig']['valid'] == 1){
                    //更新時の送信設定を確認
                    if($pingConfigData['PingConfig']['update'] == 1){
                        //結果格納用モデル
                        App::import('Model', 'Ping.PingResult'); 
                        $pingResultModel = new PingResult();
                        //送信準備
                        $title = $event->data['data']['BlogContent']['title']; //ブログタイトル
                        $url = $this->__getBlogUrl($event->data['data']['BlogContent']['name']); //ブログURL
                        $targets = $this->__getTargetServers($pingConfigData['PingConfig']['server']);
                        $resultsData = array(); //結果格納用変数
                        $resultsData['PingResult']['blog_content_id'] = $blogContetID;
                        $resultsData['PingResult']['result'] = '';
                        //送信実行処理
                        foreach ($targets as $target) {
                            $host = $this->__getPinServerHostName($target); //ホスト名取得
                            $path = $this->__getPinServerPath($target); //パス取得
                            //送信実行と結果の取得
                            $result = $this->__pingSending($host, $path, $title, $url);
                            //結果は一行で帰ってくる為、一旦、改行コードで配列化して処理しやすくする。
                            $resultArray = explode("\n",$result);
                            //中身を確認するが、タイムアウトなどで一部が不完全な返信がある。
                            if($resultArray[0] == ''){
                                $resultArray[0] = 'ERROR（応答なし）';
                            }
                            //結果保存用に追記する。
                            $resultsData['PingResult']['result'] .= $target.'<br />実行結果：'.$resultArray[0].'<br /><br />';                      
                        }
                        //結果の格納
                        //まずは既に結果の入ったレコードがあるかどうか確認する（最新1件のみ保存のため）
                        $resultDataFirst = $pingResultModel->find('first', array('conditions' => array(
                            'blog_content_id' => $blogContetID
                        )));
                        //データのある場合は上書き
                        if(empty($resultDataFirst['PingResult']['id'])){
                            //新規登録
                            $pingResultModel->create();
                            $resultsData['PingResult']['id'] = '';
                            $pingResultModel->save($resultsData);
                            return;
                        }else{
                            //上書き保存（IDの指定）
                            $resultsData['PingResult']['id'] = $resultDataFirst['PingResult']['id'];
                            //保存実行
                            $pingResultModel->save($resultsData);     
                            return;                       
                        }
                    }else{
                        return;
                    }
                }
            }
        }else{
            return;
        }
     }
    /**
     * 送信対象のPingサーバーを配列で取得する。
     *
     * @return  Array
     * @access  private
     */
    function __getTargetServers($servers){
        //改行コードを基準にして配列化
        $targets = explode("\n",$servers);
        //空改行で出来た空要素を削除
        $targets = array_filter($targets);
        //添数字を振り直す
        $targets = array_values($targets);
        //返す
        return $targets;
    }
    /**
     * Pingサーバーへ送るべきブログのURLを取得する
     *
     * @return  string
     * @access  private
     */
    function __getBlogUrl($blogAccount){
        $url = array(
            'admin' => false,
            'plugin' => '',
            'controller' => $blogAccount,
            'action' => 'index' //Pingサーバーには常にブログTOPページを通知すればOK
            );
        //ヘルパー利用
        App::uses('BcBaserHelper', 'View/Helper');
        $this->BcBaser = new BcBaserHelper(new View());
        return $this->BcBaser->getUrl($url,true);
    }
    /**
     * Pingサーバーのホスト名を取得する。
     *
     * @return  string
     * @access  private
     */
    function __getPinServerHostName($target){
        $target = str_replace(array("\r\n","\r","\n"), '', $target);
        $parse = parse_url($target);
        return $parse['host'];
    }
    /**
     * Pingサーバーのパスを取得する。
     *
     * @return  string
     * @access  private
     */
    function __getPinServerPath($target){
        //改行コードがそのままパース配列に入っているので、削除する。
        $target = str_replace(array("\r\n","\r","\n"), '', $target);
        $parse = parse_url($target);
        return $parse['path'];
    }
    /**
     * Pingサーバーへ送信する。
     *
     * @return  string
     * @access  private
     */
    function __pingSending($host, $path, $title, $url){ 
        //$hostの80番ポートへむけて以下のXMLを送信
        $sock = @fsockopen($host, 80, $errno, $errstr, 2.0);
        //戻り値格納用変数
        $result = "";
        //接続できれば以下の処理
        if ($sock){ 
            //タイトル
            $title_str = htmlspecialchars($title);   
            //送信するXMLの内容
            $content =
                   "<?xml version=\"1.0\"?>\r\n" .
                   "<methodCall>\r\n" .
                   "<methodName>weblogUpdates.ping</methodName>\r\n" .
                   "<params>\r\n" .
                   "<param>\r\n" .
                   "<value>$title_str</value>\r\n" .
                   "</param>\r\n" .
                   "<param>\r\n" .
                   "<value>$url</value>\r\n" .
                   "</param>\r\n" .
                   "</params>\r\n" .
                   "</methodCall>\r\n";
            $length = strlen($content); 
            //設定情報（ヘッダ部分）
            $req = "POST $path HTTP/1.0\r\n" .
                   "Host: $host\r\n" .
                   "Content-Type: text/xml\r\n" .
                   "Content-Length: $length\r\n" .
                   "\r\n" . $content;     
            //送信
            fputs($sock, $req);         
            //ファイルポインタが終端まで行ったかどうかで、送信完了を確認する。
            while(!feof($sock)){
                $result .= fread($sock, 1024);
            }
        }  
        return $result;
    }
}