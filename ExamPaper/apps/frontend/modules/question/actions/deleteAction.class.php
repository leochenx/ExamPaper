<?php

class deleteAction extends sfAction
{
  public function execute($request)
  {
      $question_id = $request->getParameter("question_id", "");

      if (empty($question_id) === false) {
          $exam_question_master_tbl = Doctrine::getTable("ExamQuestionMasterTbl")->findOneBy("id", $question_id);

          if (empty($exam_question_master_tbl) === false) {
              $exam_question_master_tbl->setDeleteDate(date("Y-m-d H:i:s", time()));
              $exam_question_master_tbl->save();
          }
      }
      $this->redirect("question/list");
  }
}
