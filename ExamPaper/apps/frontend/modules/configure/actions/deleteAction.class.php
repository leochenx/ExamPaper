<?php

class deleteAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");

      if (empty($exam_paper_id) === false) {
          $exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);

          if (empty($exam_paper_master_tbl) === false) {
              $exam_paper_config_tbls = Doctrine::getTable("ExamPaperConfigTbl")->findBy("ep_id", $exam_paper_id)->getData();

              foreach ($exam_paper_config_tbls as $exam_paper_config_tbl) {
                  $exam_paper_config_tbl->delete();
              }
              $exam_paper_final_tbls = Doctrine::getTable("ExamPaperFinalTbl")->findBy("exam_paper_id", $exam_paper_id)->getData();

              foreach ($exam_paper_final_tbls as $exam_paper_final_tbl) {
                  $exam_paper_final_tbl->delete();
              }
          }
          $exam_paper_master_tbl->delete();
      }
      $this->redirect("configure/list");
  }
}
