<?php use_helper("JavascriptBase"); ?>
<?php use_stylesheet("lightbox.css"); ?>
<?php use_javascript("lightbox-2.6.min.js"); ?>
<style type="text/css">
 ul {list-style:none;margin:0px;} 
 ul li {float:left;}

</style>
<script type="text/javascript">
    function delQuestion(qid) {
        if (confirm("确认删除该试题吗？")) {
            $("#question_id").val(qid);
            $("#exam_question_list_form").attr("action", "<?php echo url_for("question/delete"); ?>");
            $("#exam_question_list_form").submit();
        }
    }

    function doPagination(pgNum) {
        $("#page_number").val(pgNum);
        $("#exam_question_list_form").attr("action", "<?php echo url_for("question/list"); ?>");
        $("#exam_question_list_form").submit();
    }

    function submitForm() {
        $("#exam_question_list_form").attr("action", "<?php echo url_for("question/list"); ?>");
        $("#exam_question_list_form").submit();
    }

    function mdeleteQuestion(){
        var question_array = new Array(); 
        var flag=false; 
        $("input[name='subbox']").each(function() { 
                    if (this.checked) { 
                        flag = true;  
                    }  
                })  
        if (flag) {  
       	 $("input[name='subbox']").each(function() { 
             if (this.checked) { 
            	 question_array.push(this.value);  
             }  
         })  
         $("#question_id").val(question_array);
        	if (confirm("确认删除这些题目吗？")) {
            	alert($("#question_id").val());
            	$("#exam_question_list_form").attr("action", "<?php echo url_for("question/mdelete"); ?>");
            	$("#exam_question_list_form").submit();
        	}
        } else {  
            alert("请至少选择一个题目");  
        }  
    }
    $(function() {  
        $("#select_all").click(function() {  
        	$("input[name='subbox']").prop("checked",this.checked);   
        });  
        var $subbox = $("input[name='subbox']");  
        $subbox.click(function(){  
            $("#select_all").prop("checked",$subbox.length == $("input[name='subbox']:checked").length ? true : false);  
        });  
    }); 



</script>
<br />
<div>
    <?php echo button_to("->试卷配置一览", "configure/list"); ?>
    <?php echo button_to("->上传题库", "question/index"); ?>
    <?php echo button_to("->导出题库", "question/download"); ?>
</div>
<br />
<?php echo form_tag("question/list", array("id" => "exam_question_list_form", "name" => "exam_question_list_form")); ?>
<?php echo $ques_list_form["question_id"]; ?>
<?php echo $ques_list_form["page_number"]; ?>

<table>
	<tr>
		<td>知识点：<?php echo $ques_list_form["search_chapter_id"]; ?></td>
		<td>题型：<?php echo $ques_list_form["ques_type"]; ?></td>
		<td><?php echo $ques_list_form["ques_category"]; ?></td>
		<td><input type="submit" value="查询" /></td>
		
	</tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" border="1"
	style="width: 90%; border-color: #cccccc; line-height: 35px;">
	<tr>
		<td>&nbsp;</td>
		<td width="58%" align="center">试题内容</td>
		<td align="center">试题类型</td>
		<td align="center">题型</td>
		<!--         <td align="center">试题预览</td> -->
		<td align="center">导入时间</td>

	</tr>
	<tr>
		<td align="center"><?php echo $ques_list_form["select_all"]; ?></td>
		<!--  -->
		<td colspan=4><?php echo button_to_function("删除", "mdeleteQuestion()"); ?></td>
    <?php $qIndex = 0; ?>
    <?php foreach($exam_question_master_tbls as $exam_question_master_tbl): ?>	
	<tr
		<?php echo $qIndex%2 == 0 ? "bgcolor='#F1F7FF'" : "bgcolor='#FFF'"; ?>>
		<td align="center"><input name="subbox" type="checkbox"
			value="<?php echo $exam_question_master_tbl["id"]?>" /></td>


		<td width="50%"><?php echo $exam_question_master_tbl["ques_content"]; ?></td>
		<td align="center"><?php echo $exam_question_master_tbl["ques_difficulties"]; ?></td>
		<td align="center"><?php echo $exam_question_master_tbl["ExamQuestionTypeTbl"]["qt_name"]; ?></td>
		<td align="center"><?php echo $exam_question_master_tbl["update_date"]; ?></td>
	</tr>

    <?php $qIndex++; ?>
    <?php endforeach; ?>

	<tr>
		<td colspan="5" align="right">
		<?php echo $ques_list_form["pager_num"]; ?>
            <?php $current_page = $exam_question_master_tbls->getPage(); ?>
            <?php echo $exam_question_master_tbls->getFirstIndice() > $exam_question_master_tbls->getNbResults()? '0' : $exam_question_master_tbls->getFirstIndice()?>&nbsp;-&nbsp;<?php echo $exam_question_master_tbls->getLastIndice()?>件目&nbsp;&frasl;&nbsp;<?php echo $exam_question_master_tbls->getNbResults()?>件中&nbsp;&nbsp;
            <?php if ($current_page > 1): ?>
            <?php echo link_to_function('&lt;&lt;', 'doPagination(1)')?>
            <?php else: ?>
            <?php echo '&lt;&lt;'?>
            <?php endif;?>
            <?php if ($current_page > 1): ?>
            <?php echo link_to_function('&lt;', 'doPagination('.$exam_question_master_tbls->getPreviousPage().')')?>
            <?php else: ?>
            <?php echo '&lt;'?>
            <?php endif;?>
            <?php $beginPage = max(1, $current_page - 5); ?>
            <?php for ($i = $beginPage; $i <= min($exam_question_master_tbls->getLastPage(), $beginPage + 9); $i++): ?>
            <?php if ($i != $current_page): ?>
                <?php echo link_to_function('&nbsp;'.$i, 'doPagination('.$i.')')?>
                <?php else: ?>
                <?php echo $i?>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($exam_question_master_tbls->getLastPage() > $current_page): ?>
            <?php echo link_to_function('&gt;', 'doPagination('.$exam_question_master_tbls->getNextPage().')')?>
            <?php else: ?>
            <?php echo '&gt;'?>
            <?php endif; ?>
            <?php if ($exam_question_master_tbls->getLastPage() > $current_page): ?>
            <?php echo link_to_function('&gt;&gt;', 'doPagination('.$exam_question_master_tbls->getLastPage().')')?>
            <?php else: ?>
            <?php echo '&gt;&gt;'?>
            <?php endif; ?>
        </td>
	</tr>
</table>
<?php echo "</form>"; ?>
