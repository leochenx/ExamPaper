<?php
class editAction extends sfAction {
	public function execute($request) {
		$exam_paper_id = $request->getParameter ( "exam_paper_id", "" );
		
		if (empty ( $exam_paper_id ) === false) {
			$exam_paper_master_tbl = Doctrine::getTable ( "ExamPaperMasterTbl" )->findOneBy ( "id", $exam_paper_id );
			
			$this->configure_form = new BaseForm ();
			$this->configure_form->setWidget ( "exam_paper_id", new sfWidgetFormInputHidden () );
			$this->configure_form->setWidget ( "exam_paper_title", new sfWidgetFormInput ( array (), array (
					"size" => "86" 
			) ) );
			$this->configure_form->setWidget ( "exam_paper_difficulty", new sfwidgetformChoice ( array (
					'choices' => array (
							"A1" => "A1",
							"B1" => "B1",
							"C1" => "C1",
							"A2" => "A2",
							"B2" => "B2",
							"C2" => "C2" 
					) 
			) ) );
			
			$this->configure_form->setDefault ( "exam_paper_id", $exam_paper_master_tbl ["id"] );
			$this->configure_form->setDefault ( "exam_paper_title", $exam_paper_master_tbl ["title"] );
			$this->configure_form->setDefault ( "exam_paper_difficulty", $exam_paper_master_tbl ["ep_difficulty"] );
			
			$config_ques_type_items = array ();
			$config_ques_chapters_items = array ();
			$exam_paper_config_tbls = Doctrine::getTable ( "ExamPaperConfigTbl" )->findBy ( "ep_id", $exam_paper_id )->getData ();
			foreach ( $exam_paper_config_tbls as $exam_paper_config_tbl ) {
				$config_ques_type_items [$exam_paper_config_tbl ["ep_ques_type_id"]] ["id"] = $exam_paper_config_tbl ["ep_ques_type_id"];
				
				if (isset ( $config_ques_type_items [$exam_paper_config_tbl ["ep_ques_type_id"]] ["total"] )) {
					$config_ques_type_items [$exam_paper_config_tbl ["ep_ques_type_id"]] ["total"] += 1;
				} else {
					$config_ques_type_items [$exam_paper_config_tbl ["ep_ques_type_id"]] ["total"] = 1;
				}
				$tmpList = array ();
				$tmpList ["chapter_id"] = $exam_paper_config_tbl ["ep_ques_chapter_id"];
				$tmpList ["ques_number"] = $exam_paper_config_tbl ["ep_ques_number"];
				
				$config_ques_chapters_items [$exam_paper_config_tbl ["ep_ques_type_id"]] [] = $tmpList;
			}
			//
			$this->exam_question_types = array ();
			
			$qt_query = Doctrine_Query::create ()->from ( "ExamQuestionTypeTbl t" )->where ( "t.delete_flag = ?", array (
					"0" 
			) );
			$qt_query->orderBy ( "t.sequence" );
			$exam_question_type_tbls = $qt_query->fetchArray ();
			
			$tIndex = 0;
			foreach ( $exam_question_type_tbls as $exam_question_type_tbl ) {
				$this->exam_question_types [$tIndex] ["id"] = $exam_question_type_tbl ["id"];
				$this->exam_question_types [$tIndex] ["name"] = $exam_question_type_tbl ["qt_name"];
				$this->exam_question_types [$tIndex] ["abbr"] = $exam_question_type_tbl ["qt_abbr"];
				
				if (array_key_exists ( $exam_question_type_tbl ["id"], $config_ques_type_items )) {
					$this->exam_question_types [$tIndex] ["isCheckedFlag"] = 1;
					$this->exam_question_types [$tIndex] ["total"] = $config_ques_type_items [$exam_question_type_tbl ["id"]] ["total"];
				} else {
					$this->exam_question_types [$tIndex] ["isCheckedFlag"] = 0;
					$this->exam_question_types [$tIndex] ["total"] = 0;
				}
				$tIndex ++;
			}
			$epBaseData = new EPBaseData ();
			$this->config_ques_chapters_items = $config_ques_chapters_items;
			$this->exam_question_chapters = $epBaseData->getQuesChapterList ();
		} else {
			$this->redirect ( "configure/list" );
		}
	}
}
