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
                    'rows' => "10"
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
                    'options' => array("送信しない　", "送信する")
                )) ?>
                <?php echo $this->BcForm->error('PingConfig.update') ?>
            </td>
        </tr>
        <tr>
            <th class="col-head"><?php echo $this->BcForm->label('PingConfig.valid', '利用設定') ?></th>
            <td class="col-input">
                
                <?php echo $this->BcForm->input('PingConfig.valid', array('type' => 'radio', 
                    'options' => array("利用しない　", "利用する")
                )) ?>
                <?php echo $this->BcForm->error('PingConfig.valid') ?>
            </td>
        </tr>
    </table>
</div>
<?php
if(!empty($pingConfigData['PingConfig']['id'])){
    echo $this->BcForm->input('PingConfig.id', array('type' => 'hidden', 
        'value' => $pingConfigData['PingConfig']['id']
    ));
} ?>
<!-- button -->
<div class="submit">
<?php echo $this->BcForm->submit('保存', array('div' => false, 'class' => 'button')) ?>
<?php if(!empty($pingConfigData['PingConfig']['id'])): ?>
    <?php $this->BcBaser->link('初期化', 
            array('action' => 'delete', $pingConfigData['PingConfig']['id']),
            array('class' => 'button'),
            sprintf('%s のPing送信設定を本当に初期化してもいいですか？', $pingConfigData['BlogContent']['name']),
            false); ?>
<?php endif ?>
</div>

<?php echo $this->BcForm->end() ?>
 <!--/nocache-->