<?php
//独自ヘルパーで設定情報を取得する。
$configData = $this->BcBaser->getPingSetting($data['BlogContent']['id']);

//表示データの整理
//利用状態（インストール直後は空）
if(empty($configData['PingConfig']['valid'])){
    $valid = '利用しない';
}else{
    switch ($configData['PingConfig']['valid']) {
        case 0:
            $valid = '利用しない';
            break;
        case 1:
            $valid = '利用する';
            break;
        default:
            $valid = '利用しない';
            break;
    }
}
//更新時のPing送信（インストール直後は空）
if(empty($configData['PingConfig']['update'])){
    $ping = '送信しない';
}else{
    switch ($configData['PingConfig']['update']) {
        case 0:
            $ping = '送信しない';
            break;
        case 1:
            $ping = '送信する';
            break;
        default:
            $ping = '送信しない';
            break;
    }
}
//更新日（インストール直後は空）
if(empty($configData['PingConfig']['modified'])){
    $modified = '未設定';
}else{
    $modified = date("Y年m月d日", strtotime($configData['PingConfig']['modified']));
}
?>
<tr>
    <td class="row-tools">
        <?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'edit', $data['BlogContent']['id']), array('title' => '編集')) ?>
        <?php
        //初期状態なら表示しない（初期化ボタン）
        if(!empty($data['PingConfig']['id'])){
            $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_delete.png', 
                array('width' => 24, 'height' => 24, 'alt' => '初期化', 'class' => 'btn')), 
                array('action' => 'delete', $configData['PingConfig']['id']), 
                array('title' => '初期化', 'class' => 'btn-delete'));
            }
        ?>
    </td>
    <td><?php echo $data['BlogContent']['name'] ?></td>
    <td><?php echo $valid ?></td>
    <td><?php echo $ping ?></td>
    <td><?php echo $modified ?></td>
</tr>
