<?php use_helper("JavascriptBase"); ?>
<script type="text/javascript">
    function addExamQuesRow(qtAbbr) {
        var tNum = $("#exam_paper_" + qtAbbr + "_number").val();
        tNum = parseInt(tNum) + 1;
        $("#exam_paper_" + qtAbbr + "_number").val(tNum);

        var eqHtml = "";
        eqHtml += "<tr>";
        eqHtml += "<td>知识点：";
        eqHtml += "<select id='" + qtAbbr + formatNumber(tNum) + "_ques_chapter_id' name='" + qtAbbr + formatNumber(tNum) + "_ques_chapter_id'>";
        <?php foreach($exam_question_chapters as $fl_chapter_name => $sl_chapter_items): ?>
        eqHtml += "<optgroup label='<?php echo $fl_chapter_name; ?>'>";
        <?php foreach($sl_chapter_items as $cKey => $cVal): ?>
        eqHtml += "<option value='<?php echo $cKey; ?>'><?php echo $cVal; ?></option>";
        <?php endforeach; ?>
        eqHtml += "</optgroup>";
        <?php endforeach; ?>
        eqHtml += "</select></td>";
        eqHtml += "<td>&nbsp;&nbsp;题量：<input type='text' size='4' id='" + qtAbbr + formatNumber(tNum) + "_ques_number' name='" + qtAbbr + formatNumber(tNum) + "_ques_number' />道题</td>";
        eqHtml += "</tr>";

        $("#" + qtAbbr + "_exam_ques_tbl").append(eqHtml);
    }

    function formatNumber(pNumber) {
        if (String(pNumber).length == 1) {
            pNumber = '0' + pNumber;
        }
        return pNumber;
    }

    function submitForm() {
        var is_submit_flag = true;
        var ep_title = $("#exam_paper_title").val();

        if (ep_title == "" || ep_title == "null" || ep_title == null) {
            is_submit_flag = false;
            alert("[试卷标注]必须填写！");
        }
        var ep_difficulty = $("#exam_paper_difficulty").val();
        if (ep_difficulty == "" || ep_difficulty == "null" || ep_difficulty == null) {
            is_submit_flag = false;
            alert("[试卷难度]必须选择！");
        }
        if (is_submit_flag) {
            $("#exam_paper_config_form").submit();
        }
    }
</script>
<br />
<div><?php echo button_to("->试卷配置一览", "configure/list"); ?></div>
<br />
<?php echo form_tag("configure/complete", array("id" => "exam_paper_config_form", "name" => "exam_paper_config_form")); ?>
<table>
	<tr>
		<td>试卷标注：</td>
		<td><input id="exam_paper_title" name="exam_paper_title" type="text"
			size="108" /></td>
		<td>试卷难度：</td>
		<td><?php echo $configure_form["exam_paper_difficulty"]; ?></td>

	</tr>
</table>
<table>
	<tr>
		<td>试卷内容：</td>
		<td>
			<table>
                <?php foreach($exam_question_types as $exam_question_type): ?>
                <tr>
					<td valign="middle" width="100px"><input type="hidden"
						id="exam_paper_<?php echo $exam_question_type["qt_abbr"]; ?>_number"
						name="exam_paper_<?php echo $exam_question_type["qt_abbr"]; ?>_number"
						value="1" /> <input checked="checked"
						value="<?php echo $exam_question_type["qt_abbr"]; ?>"
						id="<?php echo $exam_question_type["qt_abbr"]; ?>_chb_flag"
						name="<?php echo $exam_question_type["qt_abbr"]; ?>_chb_flag"
						type="checkbox" /><?php echo $exam_question_type["qt_name"]; ?>
                    </td>
					<td>
						<table
							id="<?php echo $exam_question_type["qt_abbr"]; ?>_exam_ques_tbl">
							<tr>
								<td>知识点：<select
									id="<?php echo $exam_question_type["qt_abbr"]; ?>01_ques_chapter_id"
									name="<?php echo $exam_question_type["qt_abbr"]; ?>01_ques_chapter_id">
                                        <?php foreach($exam_question_chapters as $fl_chapter_name => $sl_chapter_items): ?>
                                        <optgroup
											label="<?php echo $fl_chapter_name; ?>">
                                            <?php foreach($sl_chapter_items as $cKey => $cVal): ?>
                                            <option
												value="<?php echo $cKey; ?>"><?php echo $cVal; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                        <?php endforeach; ?>
                                    </select>
								</td>
								<td>&nbsp;&nbsp;题量：<input
									id="<?php echo $exam_question_type["qt_abbr"]; ?>01_ques_number"
									name="<?php echo $exam_question_type["qt_abbr"]; ?>01_ques_number"
									type="text" size="4" />道题
								</td>
							</tr>
						</table>
					</td>
					<td valign="middle" align="right" width="150px"><?php echo button_to_function("增加（".$exam_question_type["qt_name"]."）", "addExamQuesRow('".$exam_question_type["qt_abbr"]."')"); ?></td>
				</tr>
				<tr>
					<td colspan="3"><hr /></td>
				</tr>
                <?php endforeach; ?>
            </table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php echo button_to_function("&nbsp;&nbsp;提交设定&nbsp;&nbsp;", "submitForm()"); ?></td>
	</tr>
</table>
<?php echo "</form>"; ?>
