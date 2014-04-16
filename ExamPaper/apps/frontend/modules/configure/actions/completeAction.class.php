<?php

class completeAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");
      $exam_paper_title = $request->getParameter("exam_paper_title", "");
      $exam_paper_difficulty = $request->getParameter("exam_paper_difficulty", "");
      

      if (empty($exam_paper_title) === false) {
          if (empty($exam_paper_id) === false) {
              $exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);
          }
          if (empty($exam_paper_master_tbl)) {
              $exam_paper_master_tbl = new ExamPaperMasterTbl();
              $exam_paper_master_tbl->setInsertDate(date("Y-m-d H:i:s", time()));
          }
          $exam_paper_master_tbl->setTitle($exam_paper_title);
          $exam_paper_master_tbl->setEpDifficulty($exam_paper_difficulty);
          $exam_paper_master_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
          $exam_paper_master_tbl->save();

          // Old Configure
          $exam_paper_config_tbls = Doctrine::getTable("ExamPaperConfigTbl")->findBy("ep_id", $exam_paper_master_tbl["id"])->getData();

          foreach ($exam_paper_config_tbls as $exam_paper_config_tbl) {
              $exam_paper_config_tbl->delete();
          }
          // New Configure
          $exam_question_type_tbls = Doctrine::getTable("ExamQuestionTypeTbl")->findBy("delete_flag", "0")->getData();
          foreach ($exam_question_type_tbls as $exam_question_type_tbl) {
              $question_chb_val = $request->getParameter($exam_question_type_tbl["qt_abbr"]."_chb_flag", "");

              if (empty($question_chb_val) === false) {
                  $exam_paper_number = $request->getParameter("exam_paper_".$exam_question_type_tbl["qt_abbr"]."_number", 1);

                  for ($epIndex = 1; $epIndex <= $exam_paper_number; $epIndex++) {
                      $ques_chapter_id = $request->getParameter($exam_question_type_tbl["qt_abbr"].sprintf("%02d", $epIndex)."_ques_chapter_id", "");
                      $ques_number = $request->getParameter($exam_question_type_tbl["qt_abbr"].sprintf("%02d", $epIndex)."_ques_number", "");

                      if (empty($ques_chapter_id) === false && empty($ques_number) === false) {
                          $exam_paper_config_tbl = new ExamPaperConfigTbl();

                          $exam_paper_config_tbl->setEpId($exam_paper_master_tbl["id"]);
                          $exam_paper_config_tbl->setEpQuesTypeId($exam_question_type_tbl["id"]);
                          $exam_paper_config_tbl->setEpQuesChapterId($ques_chapter_id);
                          $exam_paper_config_tbl->setEpQuesNumber($ques_number);
                          $exam_paper_config_tbl->save();
                      }
                  }
              }
          }
      }
      $this->redirect("configure/list");
  }
}
