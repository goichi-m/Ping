 <!--nocache-->
<?php
//サーバーの一覧表示
if(empty($blogContentData['PingConfig']['server'])){
    $server = '';
}else{
    $server = $blogContentData['PingConfig']['server'];
}
//更新時の送信
if(empty($blogContentData['PingConfig']['update'])){
    $updateDefault = 0;
}else{
    $updateDefault = $blogContentData['PingConfig']['update'];
}
//利用の設定
if(empty($blogContentData['PingConfig']['valid'])){
    $validDefault = 0;
}else{
    $validDefault = $blogContentData['PingConfig']['valid'];
}
?>

<!-- form -->
<h2>設定項目</h2>


<?php echo $this->BcForm->create('PingConfig') ?>
<div class="section">
    <table cellpadding="0" cellspacing="0" class="form-table">
        <tr>
            <th class="col-head">ブログアカウント名</th>
            <td class="col-input">
                <?php echo $blogContentData['BlogContent']['name'] ?>
            </td>
        </tr>
        <tr>
            <th class="col-head"><?php echo $this->BcForm->label('PingConfig.server', '送信先サーバー') ?></th>
            <td class="col-input">
                <?php echo $this->BcForm->textarea('PingConfig.server', array(
                    'rows' => "10",
                    'value' => $server
                )) ?>
                <?php echo $this->BcForm->error('PingConfig.server') ?>
                <?php echo $this->Html->image('admin/icn_help.png', array('id' => 'helpListServer', 'class' => 'btn help', 'alt' => 'ヘルプ')) ?>
                <?php echo $this->BcForm->error('BlogContent.list_direction') ?>
                <div id="helpListServer" class="helptext">
                    <ul>
                        <li>Ping送信先のサーバーを指定します。</li>
                        <li>複数指定する場合は１送信先ごとに改行してください。</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <th class="col-head"><?php echo $this->BcForm->label('PingConfig.update', '更新時の送信') ?></th>
            <td class="col-input">
                
                <?php echo $this->BcForm->input('PingConfig.update', array('type' => 'radio', 
                    'options' => array("送信しない　", "送信する"),
                    'value' => $updateDefault
                )) ?>
                <?php echo $this->BcForm->error('PingConfig.update') ?>
            </td>
        </tr>
        <tr>
            <th class="col-head"><?php echo $this->BcForm->label('PingConfig.valid', '利用設定') ?></th>
            <td class="col-input">
                
                <?php echo $this->BcForm->input('PingConfig.valid', array('type' => 'radio', 
                    'options' => array("利用しない　", "利用する"),
                    'value' => $validDefault
                )) ?>
                <?php echo $this->BcForm->error('PingConfig.valid') ?>
            </td>
        </tr>
    </table>
</div>
<?php
if(!empty($blogContentData['PingConfig']['id'])){
    echo $this->BcForm->input('PingConfig.id', array('type' => 'hidden', 
        'value' => $blogContentData['PingConfig']['id']
    ));
} ?>
<!-- button -->
<div class="submit">
<?php echo $this->BcForm->submit('保存', array('div' => false, 'class' => 'button')) ?>
<?php if(!empty($blogContentData['PingConfig']['id'])): ?>
    <?php $this->BcBaser->link('初期化', 
            array('action' => 'delete', $blogContentData['PingConfig']['id']),
            array('class' => 'button'),
            sprintf('%s のPing送信設定を本当に初期化してもいいですか？', $blogContentData['BlogContent']['name']),
            false); ?>
<?php endif ?>
</div>

<?php echo $this->BcForm->end() ?>
 <!--/nocache-->