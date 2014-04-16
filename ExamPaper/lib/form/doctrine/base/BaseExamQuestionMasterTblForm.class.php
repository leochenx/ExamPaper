<?php

/**
 * ExamQuestionMasterTbl form base class.
 *
 * @method ExamQuestionMasterTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionMasterTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'ques_content'      => new sfWidgetFormTextarea(),
      'ques_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'add_empty' => true)),
      'ques_chapter_ids'  => new sfWidgetFormInputText(),
      'ques_difficulties' => new sfWidgetFormInputText(),
      'pic_path'          => new sfWidgetFormInputText(),
      'insert_date'       => new sfWidgetFormDateTime(),
      'update_date'       => new sfWidgetFormDateTime(),
      'delete_date'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ques_content'      => new sfValidatorString(array('required' => false)),
      'ques_type_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'required' => false)),
      'ques_chapter_ids'  => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'ques_difficulties' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'pic_path'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'insert_date'       => new sfValidatorDateTime(array('required' => false)),
      'update_date'       => new sfValidatorDateTime(array('required' => false)),
      'delete_date'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_question_master_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionMasterTbl';
  }

}
