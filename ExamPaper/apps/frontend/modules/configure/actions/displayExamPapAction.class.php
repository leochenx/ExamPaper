<?php

class displayExamPapAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");

      if (empty($exam_paper_id) === false) {
          $exam_paper_ques_ids = array();

          $exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);
          $exam_paper_final_tbls = Doctrine::getTable("ExamPaperFinalTbl")->findBy("exam_paper_id", $exam_paper_id)->getData();

          foreach ($exam_paper_final_tbls as $exam_paper_final_tbl) {
              $exam_paper_ques_ids[] = $exam_paper_final_tbl["exam_ques_id"];
          }
          $ques_query = Doctrine_Query::create()->from("ExamQuestionMasterTbl q");
          $ques_query->leftJoin("q.ExamQuestionTypeTbl t");
          $ques_query->whereIn("q.id", $exam_paper_ques_ids);
          $ques_query->orderBy("t.sequence");

          $this->exam_paper_question_items = $ques_query->fetchArray();
          $this->exam_paper_title = $exam_paper_master_tbl["title"];
      }
  }
}
