<?php

class importAction extends sfAction
{
  public function execute($request)
  {
      $allow_upload_filesize = 50*1024*1024;
      $upload_files = $request->getFiles();

      foreach ($upload_files as $control_flag => $upload_file) {
          if (empty($upload_file) === false) {
              $upload_filetype = $upload_file["type"];
              $upload_filesize = $upload_file["size"];

              if ($upload_filesize <= $allow_upload_filesize && $upload_filetype == "application/zip") {
                  $target_zipfile = "uploads/assets/".date("YmdHis", time()).".zip";

                  if (move_uploaded_file($upload_file["tmp_name"], $target_zipfile)) {
                      if (file_exists($target_zipfile)) {
                          $zip_handle = new ZipArchive();

                          if ($zip_handle->open($target_zipfile) === true) {
                              $unpack_path = "uploads/assets/";
                              $zip_handle->extractTo($unpack_path);
                              $zip_handle->close();

                              unlink($target_zipfile);
                          }
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
                          // Read Excel File
                          $objPHPExcel = PHPExcel_IOFactory::load("uploads/assets/questions.xlsx");
                          $sheetCount = $objPHPExcel->getSheetCount();

                          for ($sIndex = 0; $sIndex < $sheetCount; $sIndex++) {
                              $objPHPExcel->setActiveSheetIndex($sIndex);
                              $worksheet = $objPHPExcel->getActiveSheet();
                              $title = $worksheet->getTitle();

                              if ($title == "试题库") {
                                  $exam_question_items = $worksheet->toArray();

                                  foreach ($exam_question_items as $kIndex => $exam_question_item) {
                                      if ($kIndex > 0) {
                                          if (empty($exam_question_item[1]) === false) {
                                              $exam_question_master_tbl = Doctrine::getTable("ExamQuestionMasterTbl")->findOneBy("ques_content", $exam_question_item[1]);

                                              if (empty($exam_question_master_tbl)) {
                                                  $exam_question_master_tbl = new ExamQuestionMasterTbl();

                                                  $exam_question_master_tbl->setQuesContent($exam_question_item[1]);
                                                  $exam_question_master_tbl->setInsertDate(date("Y-m-d H:i:s", time()));
                                              }
                                              if (empty($exam_question_item[10]) === false) {
                                                  if (array_search(trim($exam_question_item[10]), $exam_ques_types) !== false) {
                                                      $exam_question_master_tbl->setQuesTypeId(array_search(trim($exam_question_item[10]), $exam_ques_types));
                                                  } else {
                                                      // 补充
                                                  }
                                              }
                                              // Ques Chapters
                                              $ques_chapter_ids = "";
                                              $chapter01_val = trim($exam_question_item[8]);
                                              $chapter02_val = trim($exam_question_item[9]);

                                              if (empty($chapter01_val) === false) {
                                                  $ques_chapter_ids .= "[".array_search($chapter01_val, $exam_ques_chapters)."]";
                                              }
                                              if (empty($chapter02_val) === false) {
                                                  $ques_chapter_ids .= "[".array_search($chapter02_val, $exam_ques_chapters)."]";
                                              }
                                              $exam_question_master_tbl->setQuesChapterIds($ques_chapter_ids);
                                              // Ques Difficulties
                                              $ques_difficulties = "";
                                              $difficulty01_val = trim($exam_question_item[2]);
                                              $difficulty02_val = trim($exam_question_item[3]);
                                              $difficulty03_val = trim($exam_question_item[4]);
                                              $difficulty04_val = trim($exam_question_item[5]);
                                              $difficulty05_val = trim($exam_question_item[6]);
                                              $difficulty06_val = trim($exam_question_item[7]);

                                              if (empty($difficulty01_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty01_val."]";
                                              }
                                              if (empty($difficulty02_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty02_val."]";
                                              }
                                              if (empty($difficulty03_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty03_val."]";
                                              }
                                              if (empty($difficulty04_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty04_val."]";
                                              }
                                              if (empty($difficulty05_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty05_val."]";
                                              }
                                              if (empty($difficulty06_val) === false) {
                                                  $ques_difficulties .= "[".$difficulty06_val."]";
                                              }
                                              $exam_question_master_tbl->setQuesDifficulties($ques_difficulties);

                                              if (file_exists("uploads/assets/images/".$exam_question_item[11].".jpg")) {
                                                  $exam_question_master_tbl->setPicPath("uploads/assets/images/".$exam_question_item[11].".jpg");
                                              } else {
                                                  $exam_question_master_tbl->setPicPath("");
                                              }
                                              $exam_question_master_tbl->setUpdateDate(date("Y-m-d H:i:s", time()));
                                              $exam_question_master_tbl->setDeleteDate(null);
                                              $exam_question_master_tbl->save();
                                          }
                                      }
                                  }
                              }
                          }
                          unlink("uploads/assets/questions.xlsx");
                          //$this->delDir("uploads/assets/images/");
                      }
                  }
              }
          }
      }
      $this->redirect("question/list");
  }

  protected function delDir($d_path)
  {
      if (file_exists($d_path)) {
          if (is_dir($d_path)) {
              $open_handle = opendir($d_path);

              while (($filename = readdir($open_handle)) !== false) {
                  if (is_dir($d_path.$filename)) {
                      if ($filename != "." && $filename != "..") {
                          $this->delDir($d_path.$filename."/");
                      }
                  } else {
                      unlink($d_path.$filename);
                  }
              }
              closedir($open_handle);

              rmdir($d_path);
          } else {
              unlink($d_path);
          }
      }
  }
}
