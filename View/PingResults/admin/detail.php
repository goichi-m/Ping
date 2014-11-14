<!--nocache-->
<!-- form -->
<h2>Ping送信結果</h2>


<div class="section">
    <table cellpadding="0" cellspacing="0" class="form-table">
        <tr>
            <th class="col-head">ブログアカウント名</th>
            <td class="col-input">
                <?php echo $blogContentData['BlogContent']['name'] ?>
            </td>
        </tr>
        <tr>
            <th class="col-head">送信結果</th>
            <td class="col-input">
                <?php echo $resultData['PingResult']['result'] ?>
            </td>
        </tr>
        <tr>
            <th class="col-head">最終送信日</th>
            <td class="col-input">
                <?php echo $resultData['PingResult']['modified'] ?>
            </td>
        </tr>
    </table>
</div>
<!--/nocache-->