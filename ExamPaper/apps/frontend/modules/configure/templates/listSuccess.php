<?php use_helper("JavascriptBase"); ?>
<script type="text/javascript">
    function displayConfig(epID) {
        $("#exam_paper_id").val(epID);
        $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/display"); ?>");
        $("#exam_configure_list_form").submit();
    }

    function editConfig(epID) {
        $("#exam_paper_id").val(epID);
        $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/edit"); ?>");
        $("#exam_configure_list_form").submit();
    }

    function delConfig(epID) {
        if (confirm("确认删除该试卷所有的配置及内容吗？")) {
            $("#exam_paper_id").val(epID);
            $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/delete"); ?>");
            $("#exam_configure_list_form").submit();
        }
    }

    function buildExamPaper(epID) {
        if (confirm("确定用此项配置生成一套试卷吗？")) {
            $("#exam_paper_id").val(epID);
            $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/buildExamPap"); ?>");
            $("#exam_configure_list_form").submit();
        }
    }

    function showExamPaper(epID) {
        $("#exam_paper_id").val(epID);
        $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/displayExamPap"); ?>");
        $("#exam_configure_list_form").submit();
    }

    function delExamPaper(epID) {
        if (confirm("确定要删除该试卷吗？")) {
            $("#exam_paper_id").val(epID);
            $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/delExamPap"); ?>");
            $("#exam_configure_list_form").submit();
        }
    }

    function downloadExamPaper(epID) {
        $("#exam_paper_id").val(epID);
        $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/downloadExamPap"); ?>");
        $("#exam_configure_list_form").submit();
    }
    
    function doPagination(pgNum) {
        $("#page_number").val(pgNum);
        $("#exam_configure_list_form").attr("action", "<?php echo url_for("configure/list"); ?>");
        $("#exam_configure_list_form").submit();
    }
</script>
<br />
<div>
    <?php echo button_to("->设置新试卷", "configure/index"); ?>
    <?php echo button_to("->题库一览", "question/list"); ?>
</div><br />
<?php echo form_tag("configure/list", array("id" => "exam_configure_list_form", "name" => "exam_configure_list_form")); ?>
    <?php echo $config_list_form["exam_paper_id"]; ?>
    <?php echo $config_list_form["page_number"]; ?>
    <table cellpadding="0" cellspacing="0" border="1" style="width: 80%; border-color: #cccccc;">
        <tr style="line-height: 35px;">
            <td width="20%" align="center">试卷标注</td>
            <td width="20%" align="center">更新时间</td>
            <td width="60%">&nbsp;</td>
        </tr>
        <?php $pIndex = 0; ?>
        <?php foreach($exam_paper_master_tbls as $exam_paper_master_tbl): ?>
        <tr <?php echo $pIndex%2 == 0 ? "bgcolor='#F1F7FF'" : "bgcolor='#FFF'"; ?>>
            <td width="50%"><?php echo $exam_paper_master_tbl["title"]; ?></td>
            <td align="center"><?php echo $exam_paper_master_tbl["update_date"]; ?></td>
            <td align="left" width="24%">&nbsp;&nbsp;<?php echo button_to_function("查看设定", "displayConfig(".$exam_paper_master_tbl["id"].")"); ?>
                <?php echo button_to_function("修改设定", "editConfig(".$exam_paper_master_tbl["id"].")"); ?>
                <?php echo button_to_function("删除设定", "delConfig(".$exam_paper_master_tbl["id"].")"); ?><br />
                <?php if (empty($exam_paper_master_tbl["is_build_flag"])): ?>&nbsp;&nbsp;<?php echo button_to_function("生成试卷", "buildExamPaper(".$exam_paper_master_tbl["id"].")"); ?><?php endif; ?>
                <?php if ($exam_paper_master_tbl["is_build_flag"]): ?>&nbsp;&nbsp;<?php echo button_to_function("查看试卷", "showExamPaper(".$exam_paper_master_tbl["id"].")"); ?>
                <?php echo button_to_function("下载试卷", "downloadExamPaper(".$exam_paper_master_tbl["id"].")"); ?>                <?php echo button_to_function("删除试卷", "delExamPaper(".$exam_paper_master_tbl["id"].")"); ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php $pIndex++; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" align="right">
                <?php $current_page = $exam_paper_master_tbls->getPage(); ?>
                <?php echo $exam_paper_master_tbls->getFirstIndice() > $exam_paper_master_tbls->getNbResults()? '0' : $exam_paper_master_tbls->getFirstIndice()?>&nbsp;-&nbsp;<?php echo $exam_paper_master_tbls->getLastIndice()?>件目&nbsp;&frasl;&nbsp;<?php echo $exam_paper_master_tbls->getNbResults()?>件中&nbsp;&nbsp;
                <?php if ($current_page > 1): ?>
                <?php echo link_to_function('&lt;&lt;', 'doPagination(1)') ?>
                <?php else: ?>
                <?php echo '&lt;&lt;' ?>
                <?php endif;?>
                <?php if ($current_page > 1): ?>
                <?php echo link_to_function('&lt;', 'doPagination('.$exam_paper_master_tbls->getPreviousPage().')') ?>
                <?php else: ?>
                <?php echo '&lt;' ?>
                <?php endif;?>
                <?php $beginPage = max(1, $current_page - 5); ?>
                <?php for ($i = $beginPage; $i <= min($exam_paper_master_tbls->getLastPage(), $beginPage + 9); $i++): ?>
                <?php if ($i != $current_page): ?>
                    <?php echo link_to_function('&nbsp;'.$i, 'doPagination('.$i.')') ?>
                    <?php else: ?>
                    <?php echo $i ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($exam_paper_master_tbls->getLastPage() > $current_page): ?>
                <?php echo link_to_function('&gt;', 'doPagination('.$exam_paper_master_tbls->getNextPage().')') ?>
                <?php else: ?>
                <?php echo '&gt;' ?>
                <?php endif; ?>
                <?php if ($exam_paper_master_tbls->getLastPage() > $current_page): ?>
                <?php echo link_to_function('&gt;&gt;', 'doPagination('.$exam_paper_master_tbls->getLastPage().')') ?>
                <?php else: ?>
                <?php echo '&gt;&gt;' ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
<?php echo "</form>"; ?>
