<?php
class configureActions extends sfActions {
	public function executeIndex(sfWebRequest $request) {

		$epBaseData = new EPBaseData ();
		
		$qt_query = Doctrine_Query::create ()->from ( "ExamQuestionTypeTbl t" )->where ( "t.delete_flag = ?", array (
				"0" 
		) );
		$qt_query->orderBy ( "t.sequence" );
		
		$this->exam_question_types = $qt_query->fetchArray ();
		$this->exam_question_chapters = $epBaseData->getQuesChapterList ();
		
		$this->configure_form = new BaseForm ();
		$this->configure_form->setWidget ( "exam_paper_difficulty", new sfwidgetformChoice ( array (
				'choices' => array (
						"" => "--",
						"A1" => "A1",
						"B1" => "B1",
						"C1" => "C1",
						"A2" => "A2",
						"B2" => "B2",
						"C2" => "C2" 
				) 
		) ) );
	}
}
