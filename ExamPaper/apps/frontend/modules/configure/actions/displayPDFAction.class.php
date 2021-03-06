<?php
class displayPDFAction extends sfAction {
	public function execute($request) {
		header("charset=gb2312");
		$exam_paper_id = $request->getParameter ( "exam_paper_id", "" );
		
		if (empty ( $exam_paper_id ) === false) {
			$exam_paper_master_tbl = Doctrine::getTable ( "ExamPaperMasterTbl" )->findOneBy ( "id", $exam_paper_id );
			
			if (empty ( $exam_paper_master_tbl ) === false) {
				$final_query = Doctrine_Query::create ()->from ( "ExamPaperFinalTbl f" );
				$final_query->leftJoin ( "f.ExamQuestionMasterTbl q" );
				$final_query->where ( "f.exam_paper_id = ?", array (
						$exam_paper_id 
				) );
				// echo $final_query->getSqlQuery ();
				$exam_paper_final_tbls = $final_query->fetchArray ();
				
				$qt_type_query = Doctrine_Query::create ()->from ( "ExamQuestionTypeTbl f" );
				$qt_type_query->orderBy ( 'f.sequence' );
				// echo $type_query->getSqlQuery();
				$qt_type_tbls = $qt_type_query->fetchArray ();
				
				$template_begin_query = Doctrine_Query::create ()->from ( "ExamPaperTemplateTbl f" );
				$template_begin_query->where ( 'f.position=?' ,array("begin"));
				// echo $type_query->getSqlQuery();
				$template_begin_tbls = $template_begin_query->fetchArray ();
				foreach ($template_begin_tbls as $template_begin_tbl){
					$begin_str=$template_begin_tbl["template"];
				}
				$template_end_query = Doctrine_Query::create ()->from ( "ExamPaperTemplateTbl f" );
				$template_end_query->where ( 'f.position=?' ,array("end"));
				// echo $type_query->getSqlQuery();
				$template_end_tbls = $template_end_query->fetchArray ();
				foreach ($template_end_tbls as $template_end_tbl){
					$end_str=$template_end_tbl["template"];
				}
				$paper_questions = array ();
				foreach ( $exam_paper_final_tbls as $exam_paper_final_tbl ) {
					$content = $exam_paper_final_tbl ["ExamQuestionMasterTbl"] ["ques_content"];
					if (isset ( $paper_questions [$exam_paper_final_tbl ["ExamQuestionMasterTbl"] ["ques_type_id"]] ) === false) {
						$paper_questions [$exam_paper_final_tbl ["ExamQuestionMasterTbl"] ["ques_type_id"]] = array (
								$content 
						);
					} else {
						$paper_questions [$exam_paper_final_tbl ["ExamQuestionMasterTbl"] ["ques_type_id"]] = array_merge ( $paper_questions [$exam_paper_final_tbl ["ExamQuestionMasterTbl"] ["ques_type_id"]], array (
								$content 
						) );
					}
				}
				// print_r ( $paper_questions );
				
				$dirname = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "output";
				
				$filename = $exam_paper_master_tbl ["id"];
				$tex_suffix = ".tex";
				$pdf_suffix = ".pdf";
				$tex_path = $dirname . DIRECTORY_SEPARATOR . $filename . $tex_suffix;
				$pdf_path = $dirname . DIRECTORY_SEPARATOR . $filename . $pdf_suffix;
				$pdf_filename = $filename . $pdf_suffix;
				$handle = fopen ( $tex_path, "w" );				
				fwrite ( $handle, $begin_str );
				$template_qt = '\noindent \textbf{#str_type_name#}\begin{enumerate}#str_questions#\end{enumerate}' . "\r\n";
				
				foreach ( $qt_type_tbls as $qt_type_tbl ) {
					$str_questions = "";
					if (isset ( $paper_questions [$qt_type_tbl ["id"]] ) != false) {
						$str_type_name = $qt_type_tbl ["qt_name"];
						foreach ( $paper_questions [$qt_type_tbl ["id"]] as $str_question ) {
							$str_questions = $str_questions . $str_question . "\r\n";
						}
						$main_str = str_replace ( "#str_questions#", $str_questions, str_replace ( "#str_type_name#", $str_type_name, $template_qt ) );
						fwrite ( $handle, $main_str );
					}
				}
				
				fwrite ( $handle, $end_str );
				fclose ( $handle );
				$command = "C:\\CTEX\\MiKTeX\\miktex\\bin\\pdflatex" . " " . $tex_path . " > haha.log";
				system ( $command );
				
				$user_agent = $_SERVER ["HTTP_USER_AGENT"];
				
				header ( "Content-Type: application/pdf" );
				
				if (preg_match ( "/MSIE/", $user_agent )) {
					header ( "filename=" . rawurlencode ( $pdf_filename ) );
				} else {
					header ( "filename=" . $pdf_filename );
				}
				header ( "Cache-Control: max-age=0" );
				readfile ( $pdf_filepath );
				exit ();
			} else {
				$this->redirect ( "configure/list" );
			}
		} else {
			$this->redirect ( "configure/list" );
		}
	}
}
