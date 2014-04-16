<?php

class displayAction extends sfAction
{
  public function execute($request)
  {
      $exam_paper_id = $request->getParameter("exam_paper_id", "");

      if (empty($exam_paper_id) === false) {
          $this->exam_ques_types_chapters = array();
          $this->exam_paper_master_tbl = Doctrine::getTable("ExamPaperMasterTbl")->findOneBy("id", $exam_paper_id);

          $config_query = Doctrine_Query::create()->from("ExamPaperConfigTbl e");
          $config_query->leftJoin("e.ExamQuestionTypeTbl t, e.ExamQuestionChapterTbl c");
          $config_query->select("e.id, e.ep_id, e.ep_ques_type_id, e.ep_ques_chapter_id, e.ep_ques_number");
          $config_query->addSelect("t.qt_name, c.name");
          $config_query->where("e.ep_id = ?", array($exam_paper_id));
          $config_query->orderBy("t.sequence");

          $exam_paper_config_tbls = $config_query->fetchArray();
          foreach ($exam_paper_config_tbls as $exam_paper_config_tbl) {
              $tmpList = array();
              $tmpList["chapter_name"] = $exam_paper_config_tbl["ExamQuestionChapterTbl"]["name"];
              $tmpList["ques_number"] = $exam_paper_config_tbl["ep_ques_number"];

              $this->exam_ques_types_chapters[$exam_paper_config_tbl["ExamQuestionTypeTbl"]["qt_name"]][] = $tmpList;
          }
      } else {
          $this->redirect("configure/list");
      }
  }
}
