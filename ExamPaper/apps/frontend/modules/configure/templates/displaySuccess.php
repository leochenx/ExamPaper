<br />
<div><?php echo button_to("->试卷配置一览", "configure/list"); ?></div>
<br />
<table width="50%">
	<tr>
		<td>试卷标注：	<?php echo $exam_paper_master_tbl["title"]; ?></td>
		<td>试卷难度：<?php echo $exam_paper_master_tbl["ep_difficulty"]; ?></td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td>试卷内容：</td>
		<td>
			<table >
                <?php foreach($exam_ques_types_chapters as $exam_ques_type => $exam_ques_chapters): ?>
                <tr>
					<td valign="middle" width="100px"><?php echo $exam_ques_type; ?></td>
					<td>
						<table >
                            <?php foreach($exam_ques_chapters as $exam_ques_chapter): ?>
                            <tr>
								<td >知识点：<?php echo $exam_ques_chapter["chapter_name"]; ?></td>
								<td>&nbsp;&nbsp;题量：<?php echo $exam_ques_chapter["ques_number"]; ?>道题</td>
							</tr>
                            <?php endforeach; ?>
                        </table>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr /></td>
				</tr>
                <?php endforeach; ?>
            </table>
		</td>
	</tr>
</table>
