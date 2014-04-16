<?php

class delExamPapAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");

      if (empty($exam_paper_id) === false) {
          $exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);

          if (empty($exam_paper_master_tbl) === false) {
              $exam_paper_final_tbls = Doctrine::getTable("ExamPaperFinalTbl")->findBy("exam_paper_id", $exam_paper_id)->getData();

              foreach ($exam_paper_final_tbls as $exam_paper_final_tbl) {
                  $exam_paper_final_tbl->delete();
              }
          }
          $exam_paper_master_tbl->setIsBuildFlag(0);
          $exam_paper_master_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
          $exam_paper_master_tbl->save();
      }
      $this->redirect("configure/list");
  }
}
