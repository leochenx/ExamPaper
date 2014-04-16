<?php

class buildExamPapAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");

      if (empty($exam_paper_id) === false) {
          $exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);

          if (empty($exam_paper_master_tbl) === false) {
              $exam_paper_config_tbls = Doctrine::getTable("ExamPaperConfigTbl")->findBy("ep_id", $exam_paper_id)->getData();

              foreach ($exam_paper_config_tbls as $exam_paper_config_tbl) {
                  $exam_question_ids = array();

                  $ques_query = Doctrine_Query::create()->from("ExamQuestionMasterTbl q")->where("q.delete_date is null");
                  $ques_query->andWhere("q.ques_type_id = ?", array($exam_paper_config_tbl["ep_ques_type_id"]));
                  $ques_query->andWhere("q.ques_chapter_ids like ?", array("%[".$exam_paper_config_tbl["ep_ques_chapter_id"]."]%"));
                  $ques_query->andWhere("q.ques_difficulties like ?", array("%[".$exam_paper_master_tbl["ep_difficulty"]."]%"));
                  
                  $ques_query->select("q.id");

                  $exam_question_master_tbls = $ques_query->fetchArray();
                  foreach ($exam_question_master_tbls as $exam_question_master_tbl) {
                      $exam_question_ids[$exam_question_master_tbl["id"]] = $exam_question_master_tbl["id"];
                  }
                  if (empty($exam_question_ids) === false) {
                      if (count($exam_question_ids) > $exam_paper_config_tbl["ep_ques_number"]) {
                          $exam_paper_ques_ids = array_rand($exam_question_ids, $exam_paper_config_tbl["ep_ques_number"]);
                      } else {
                          $exam_paper_ques_ids = array_rand($exam_question_ids, count($exam_question_ids));
                      }
                      if (is_array($exam_paper_ques_ids)) {
                          foreach ($exam_paper_ques_ids as $exam_paper_ques_id) {
                              $exam_paper_final_tbl = new ExamPaperFinalTbl();

                              $exam_paper_final_tbl->setExamPaperId($exam_paper_id);
                              $exam_paper_final_tbl->setExamQuesTypeId($exam_paper_config_tbl["ep_ques_type_id"]);
                              $exam_paper_final_tbl->setExamQuesId($exam_paper_ques_id);
                              $exam_paper_final_tbl->setInsertDate(date("Y-m-d H:i:s", time()));
                              $exam_paper_final_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
                              $exam_paper_final_tbl->save();
                          }
                      } else {
                          $exam_paper_final_tbl = new ExamPaperFinalTbl();

                          $exam_paper_final_tbl->setExamPaperId($exam_paper_id);
                          $exam_paper_final_tbl->setExamQuesTypeId($exam_paper_config_tbl["ep_ques_type_id"]);
                          $exam_paper_final_tbl->setExamQuesId($exam_paper_ques_ids);
                          $exam_paper_final_tbl->setInsertDate(date("Y-m-d H:i:s", time()));
                          $exam_paper_final_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
                          $exam_paper_final_tbl->save();
                      }
                  }
              }
              $exam_paper_master_tbl->setIsBuildFlag(1);
              $exam_paper_master_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
              $exam_paper_master_tbl->save();
          }
      }
      $this->redirect("configure/list");
  }
}
