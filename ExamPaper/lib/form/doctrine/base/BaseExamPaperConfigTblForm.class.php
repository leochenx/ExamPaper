<?php

/**
 * ExamPaperConfigTbl form base class.
 *
 * @method ExamPaperConfigTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamPaperConfigTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'ep_id'              => new sfWidgetFormInputText(),
      'ep_ques_type_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'add_empty' => true)),
      'ep_ques_chapter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionChapterTbl'), 'add_empty' => true)),
      'ep_ques_number'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ep_id'              => new sfValidatorInteger(array('required' => false)),
      'ep_ques_type_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'required' => false)),
      'ep_ques_chapter_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionChapterTbl'), 'required' => false)),
      'ep_ques_number'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_paper_config_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamPaperConfigTbl';
  }

}
