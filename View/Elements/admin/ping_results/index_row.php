<?php
//更新日（インストール直後は空）
if(empty($data['PingResult']['modified'])){
    $modified = '送信履歴なし';
}else{
    $modified = date("Y年m月d日 H時i分s秒", strtotime($data['PingResult']['modified']));
}
?>
<tr>
    <td class="row-tools">
        <?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_check.png', array('width' => 24, 'height' => 24, 'alt' => '確認', 'class' => 'btn')), array('action' => 'detail', $data['BlogContent']['id']), array('title' => '確認')) ?>
        <?php 
        if(!empty($data['PingResult']['id'])){
        $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_delete.png', 
                array('width' => 24, 'height' => 24, 'alt' => '履歴の削除', 'class' => 'btn')), 
                array('action' => 'delete', $data['PingResult']['id']), 
                array('title' => '履歴の削除', 'class' => 'btn-delete'));
        }
        ?>
    </td>
    <td><?php echo $data['BlogContent']['name'] ?></td>
    <td><?php echo $data['BlogContent']['title'] ?></td>
    <td><?php echo $modified ?></td>
</tr>
