<?php
class EPQuesType {
	public function getQuesTypeList() {
		global $ques_type_list;
		
		if (isset ( $ques_chapter_list ) === false) {
			$ques_type_list = array ();
			$ques_type_list[0]="----------";
			$exam_question_type_tbls = Doctrine::getTable ( "ExamQuestionTypeTbl" )->findAll ()->getData ();
			foreach ( $exam_question_type_tbls as $exam_question_type_tbl ) {
				$ques_type_list [$exam_question_type_tbl ["id"]] = $exam_question_type_tbl ["qt_name"];
			}
		}
		return $ques_type_list;
	}
}
