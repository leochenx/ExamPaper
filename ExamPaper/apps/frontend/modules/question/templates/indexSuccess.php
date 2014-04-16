<br />
<div><?php echo button_to("->题库一览", "question/list"); ?></div>
<?php echo form_tag("question/import", array("multipart" => true)); ?>
<div style="color: red;font-size: 14px;">
    <br />************************************************************************************************************************************************************
    <br />*&nbsp;上传的题库，应为压缩包文件（文件格式为xxx.zip）！题库中必须包含Excel格式的题库文件，以及试题所对应的图片文件！
    <br />*&nbsp;格式：题库.zip文件中包含【questions.xlsx】、【images/】（images目录中放的是每道试题对应的预览图片）。
    <br />************************************************************************************************************************************************************
    <br />**&nbsp;请务必按规则上传题库资料！
    <br />************************************************************************************************************************************************************
    <br />**如未看懂该说明文，可在“题库一览”页面使用“导出题库”，查看压缩文件格式及所包含内容。
    <br />************************************************************************************************************************************************************
    <table>
        <tr><td>题库.zip</td><td>->&nbsp;questions.xlsx</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>->&nbsp;images/</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;1.1.jpg</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;2.1.jpg</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;3.1.jpg</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;x.x.jpg</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;....................</td><td>&nbsp;</td></tr>
    </table>
    <br />************************************************************************************************************************************************************
</div>
<br />题库：<?php echo $ques_file_form["exam_ques_file"]; ?><input type="submit" value="上传文件" />
<?php echo "</form>"; ?>
