<?php use_stylesheet("lightbox.css"); ?>
<?php use_javascript("lightbox-2.6.min.js"); ?>
<br /><div><?php echo button_to("->试卷配置一览", "configure/list"); ?></div><br />
<table cellpadding="0" cellspacing="0" border="1" style="width: 92%; border-color: #cccccc; line-height: 35px;">
    <tr><td colspan="3" align="center" style="font-size: 20px;">试卷标注：<?php echo $exam_paper_title; ?></td></tr>
    <tr>
        <td align="center" width="9%">题型</td>
        <td align="center" width="9%">试题类型</td>
        <td align="center">试题内容</td>
        <td align="center" width="16%">预览图片</td>
    </tr>
    <?php $pIndex = 0; ?>
    <?php foreach($exam_paper_question_items as $exam_paper_question_item): ?>
    <tr <?php echo $pIndex%2 == 0 ? "bgcolor='#F1F7FF'" : "bgcolor='#FFF'"; ?>>
        <td align="center"><?php echo $exam_paper_question_item["ExamQuestionTypeTbl"]["qt_name"]; ?></td>
                <td align="center"><?php echo $exam_paper_question_item["ques_difficulties"]; ?></td>
        
        <td style="line-height:165%"><?php echo $exam_paper_question_item["ques_content"]; ?></td>
        <td align="center">
            <?php if ($exam_paper_question_item["pic_path"]): ?>
            <a data-lightbox="roadtrip" href="<?php echo public_path($exam_paper_question_item["pic_path"]); ?>"><?php echo image_tag(public_path($exam_paper_question_item["pic_path"]), array("border" => "0", "width" => "150px")); ?></a>
            <?php endif; ?>
        </td>
    </tr>
    <?php $pIndex++; ?>
    <?php endforeach; ?>
    <tr><td colspan="3" align="center" style="font-size: 20px;">试卷标注：<?php echo $exam_paper_title; ?></td></tr>
</table>
<br /><br /><br />