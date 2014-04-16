<?php

class listAction extends sfAction
{
  public function execute($request)
  {
      $this->config_list_form = new BaseForm();
      $this->config_list_form->setWidget("exam_paper_id", new sfWidgetFormInputHidden());
      $this->config_list_form->setWidget("page_number", new sfWidgetFormInputHidden());

      $page_number = $request->getParameter("page_number", 1);

      $config_query = Doctrine_Query::create()->from("ExamPaperMasterTbl e");
      $config_query->orderBy("e.update_date desc");

      $pager = new sfDoctrinePager("ExamPaperMasterTbl", 20);
      $pager->setQuery($config_query);
      $pager->setPage($page_number);
      $pager->init();

      $this->exam_paper_master_tbls = $pager;
  }
}
