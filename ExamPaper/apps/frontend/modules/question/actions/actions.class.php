<?php

class questionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $this->ques_file_form = new BaseForm();
      $this->ques_file_form->setWidget("exam_ques_file", new sfWidgetFormInputFile());
  }
}
