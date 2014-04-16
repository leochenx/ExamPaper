<?php
class listAction extends sfAction {
	public function execute($request) {
		$epBaseData = new EPBaseData ();
		$epQuesType = new EPQuesType ();
		
		$this->ques_list_form = new BaseForm ();
		$this->ques_list_form->setWidget ( "question_id", new sfWidgetFormInputHidden () );
		$this->ques_list_form->setWidget ( "page_number", new sfWidgetFormInputHidden () );
		$this->ques_list_form->setWidget ( "search_chapter_id", new sfWidgetFormChoice ( array (
				"choices" => $epBaseData->getQuesChapterList () 
		) ) );
		$this->ques_list_form->setWidget ( "select_all", new sfwidgetforminputcheckbox () );
		$this->ques_list_form->setWidget ( "ques_type", new sfWidgetFormChoice ( array (
				"choices" => $epQuesType->getQuesTypeList () 
		) ) );
		$this->ques_list_form->setWidget ( "pager_num", new sfWidgetFormChoice ( array (
				"choices" => array (
						20 => "20",
						40 => "40",
						80 => "80",
						100 => "100",
						0 => "all" 
				) 
		), array (
				"onchange" => "submitForm()" 
		) ) );
		$this->ques_list_form->setWidget ( "ques_category", new sfwidgetformChoice ( array (
				'multiple' => true,
				'expanded' => true,
				'choices' => array (
						"[A1]" => "A1",
						"[B1]" => "B1",
						"[C1]" => "C1",
						"[A2]" => "A2",
						"[B2]" => "B2",
						"[C2]" => "C2" 
				) 
		) ) );
		
		$page_number = $request->getParameter ( "page_number", 1 );
		$search_chapter_id = $request->getParameter ( "search_chapter_id", "" );
		$ques_type = $request->getParameter ( "ques_type", "" );
		$pager_num = $request->getParameter ( "pager_num", 20 );
		
		$ques_category = $request->getParameter ( "ques_category" );
		
		$question_query = Doctrine_Query::create ()->from ( "ExamQuestionMasterTbl q" );
		$question_query->leftJoin ( "q.ExamQuestionTypeTbl t" );
		$question_query->where ( "q.delete_date is null" );
		$question_query->orderBy ( "q.ques_type_id" );
		$question_query->addOrderBy ( "q.update_date desc" );
		
		if (empty ( $search_chapter_id ) === false) {
			$this->ques_list_form->setDefault ( "search_chapter_id", $search_chapter_id );
			$question_query->andWhere ( "q.ques_chapter_ids like ?", array (
					"%[" . $search_chapter_id . "]%" 
			) );
		}
		if (empty ( $ques_type ) === false) {
			$this->ques_list_form->setDefault ( "ques_type", $ques_type );
			$question_query->andWhere ( "q.ques_type_id = ?", $ques_type );
		}
		if (empty ( $ques_category ) === false) {
			$this->ques_list_form->setDefault ( "ques_category", $ques_category );
			$question_query->andWhere ( "q.ques_difficulties like ?", array (
					"%" . implode("%",$ques_category) . "%"));
			
		}
		$this->ques_list_form->setDefault ( "pager_num", $pager_num );
		
		$pager = new sfDoctrinePager ( "ExamQuestionMasterTbl", $pager_num );
		$pager->setQuery ( $question_query );
		$pager->setPage ( $page_number );
		$pager->init ();
		
		$this->exam_question_master_tbls = $pager;
	}
}
