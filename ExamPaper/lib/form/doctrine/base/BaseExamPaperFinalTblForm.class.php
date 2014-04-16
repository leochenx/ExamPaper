<?php

/**
 * ExamPaperFinalTbl form base class.
 *
 * @method ExamPaperFinalTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamPaperFinalTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'exam_paper_id'     => new sfWidgetFormInputText(),
      'exam_ques_type_id' => new sfWidgetFormInputText(),
      'exam_ques_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionMasterTbl'), 'add_empty' => true)),
      'insert_date'       => new sfWidgetFormDateTime(),
      'update_date'       => new sfWidgetFormDateTime(),
      'delete_date'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'exam_paper_id'     => new sfValidatorInteger(array('required' => false)),
      'exam_ques_type_id' => new sfValidatorInteger(array('required' => false)),
      'exam_ques_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionMasterTbl'), 'required' => false)),
      'insert_date'       => new sfValidatorDateTime(array('required' => false)),
      'update_date'       => new sfValidatorDateTime(array('required' => false)),
      'delete_date'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_paper_final_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamPaperFinalTbl';
  }

}
