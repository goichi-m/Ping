<?php
/* 
 * baserCMS Plugin
 * ping送信　サブメニューエレメント
 *
 * @name            Ping
 * @link            http://blog.mani-lab.com/
 * @version         3.0.0
 * @lastmodified    2013-11-24
 *
 */
?>
<tr>
	<th>Ping送信メニュー</th>
	<td>
		<ul>
			<li><?php $this->BcBaser->link('設定一覧', array('plugin' => 'ping', 'controller' => 'ping_configs', 'action' => 'index')) ?></li>
			<li><?php $this->BcBaser->link('送信結果', array('plugin' => 'ping', 'controller' => 'ping_results', 'action' => 'index')) ?></li>
		</ul>
	</td>
</tr>
