<?php

class downloadAction extends sfAction
{
  public function execute($request)
  {
      $ques_savepath = "uploads/tmp/".date("YmdHis", time())."/";
      $ques_filename = "questions.xlsx";
      $library_filepath = $ques_savepath."library.zip";

      if (file_exists($ques_savepath) === false) {
          mkdir($ques_savepath);
      }
      // Zip Object
      $zipArchive = new ZipArchive();
      $res = $zipArchive->open($library_filepath, ZipArchive::CREATE);

      if ($res === true) {
          $zipArchive->addEmptyDir("images");
      }
      // Excel
      $objReader = PHPExcel_IOFactory::createReader("Excel2007");
      $objPHPExcel = $objReader->load("tools/excel_tpl/question_tpl.xlsx");

      $exam_ques_types = array();
      $exam_ques_chapters = array();

      $exam_question_type_tbls = Doctrine::getTable("ExamQuestionTypeTbl")->findBy("delete_flag", "0")->getData();
      foreach ($exam_question_type_tbls as $exam_question_type_tbl) {
          $exam_ques_types[$exam_question_type_tbl["id"]] = $exam_question_type_tbl["qt_name"];
      }
      $exam_question_chapter_tbls = Doctrine::getTable("ExamQuestionChapterTbl")->findBy("is_parent", "0")->getData();
      foreach ($exam_question_chapter_tbls as $exam_question_chapter_tbl) {
          $exam_ques_chapters[$exam_question_chapter_tbl["id"]] = $exam_question_chapter_tbl["name"];
      }
      $gc_query = Doctrine_Query::create()->from("ExamQuestionMasterTbl q")->where("q.delete_date is null");
      $exam_question_master_tbls = $gc_query->fetchArray();

      $cellIndex = 2;
      foreach ($exam_question_master_tbls as $exam_question_master_tbl) {
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$cellIndex, $cellIndex - 1);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B".$cellIndex, $exam_question_master_tbl["ques_content"]);

          $ques_difficulties = $exam_question_master_tbl["ques_difficulties"];
          $ques_difficulties = str_replace("][", "|", $ques_difficulties);
          $ques_difficulties = str_replace("[", "", $ques_difficulties);
          $ques_difficulties = str_replace("]", "", $ques_difficulties);
          $ques_difficulties = explode("|", $ques_difficulties);

          if (in_array("A1", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C".$cellIndex, "A1");
          }
          if (in_array("B1", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D".$cellIndex, "B1");
          }
          if (in_array("C1", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E".$cellIndex, "C1");
          }
          if (in_array("A2", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$cellIndex, "A2");
          }
          if (in_array("B2", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$cellIndex, "B2");
          }
          if (in_array("C2", $ques_difficulties)) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$cellIndex, "C2");
          }
          $ques_chapter_ids = $exam_question_master_tbl["ques_chapter_ids"];
          $ques_chapter_ids = str_replace("][", "|", $ques_chapter_ids);
          $ques_chapter_ids = str_replace("[", "", $ques_chapter_ids);
          $ques_chapter_ids = str_replace("]", "", $ques_chapter_ids);
          $ques_chapter_ids = explode("|", $ques_chapter_ids);

          if (count($ques_chapter_ids) == 2) {
              list($fst_ques_chapter_id, $sec_ques_chapter_id) = $ques_chapter_ids;
          } else {
              $fst_ques_chapter_id = implode("", $ques_chapter_ids);
              $sec_ques_chapter_id = "";
          }
          if (empty($fst_ques_chapter_id) === false) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I".$cellIndex, $exam_ques_chapters[$fst_ques_chapter_id]);
          }
          if (empty($sec_ques_chapter_id) === false) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J".$cellIndex, $exam_ques_chapters[$sec_ques_chapter_id]);
          }
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K".$cellIndex, $exam_ques_types[$exam_question_master_tbl["ques_type_id"]]);

          if (file_exists($exam_question_master_tbl["pic_path"])) {
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L".$cellIndex, str_replace(".jpg", "", basename($exam_question_master_tbl["pic_path"])));

              if ($res === true) {
                  $zipArchive->addFile($exam_question_master_tbl["pic_path"], "images/".basename($exam_question_master_tbl["pic_path"]));
              }
          }
          $cellIndex++;
      }
      $objPHPExcel->setActiveSheetIndex(0);

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
      $objWriter->save($ques_savepath.$ques_filename);

      if ($res === true) {
          $zipArchive->addFile($ques_savepath.$ques_filename, $ques_filename);
          $zipArchive->close();
      }
      unlink($ques_savepath.$ques_filename);

      // Download Setting
      $filename = "题库_".date("YmdHis", time()).".zip";
      $user_agent = $_SERVER["HTTP_USER_AGENT"];

      header("Content-Type: application/force-download");

      if (preg_match("/MSIE/", $user_agent)) {
          header("Content-Disposition: attachment;filename=".rawurlencode($filename));
      } else {
          header("Content-Disposition: attachment;filename=".$filename);
      }
      header("Cache-Control: max-age=0");

      readfile($library_filepath);
      exit;
  }
}
