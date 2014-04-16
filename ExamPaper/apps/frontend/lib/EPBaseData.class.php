<?php

class EPBaseData
{
  public function getQuesChapterList()
  {
      global $ques_chapter_list;

      if (isset($ques_chapter_list) === false) {
          $ques_chapter_list["请选择知识点"] = array("" => "----------------------------------");
          $fst_chapter_names = array();

          $exam_question_chapter_tbls = Doctrine::getTable("ExamQuestionChapterTbl")->findAll()->getData();
          foreach ($exam_question_chapter_tbls as $exam_question_chapter_tbl) {
              if (empty($exam_question_chapter_tbl["parent_cid"])) {
                  if (isset($ques_chapter_list[$exam_question_chapter_tbl["name"]]) === false) {
                      $ques_chapter_list[$exam_question_chapter_tbl["name"]] = array();
                      $fst_chapter_names[$exam_question_chapter_tbl["id"]] = $exam_question_chapter_tbl["name"];
                  }
              } else {
                  $ques_chapter_list[$fst_chapter_names[$exam_question_chapter_tbl["parent_cid"]]] += array($exam_question_chapter_tbl["id"] => $exam_question_chapter_tbl["name"]);
              }
          }
      }
      return $ques_chapter_list;
  }
}
