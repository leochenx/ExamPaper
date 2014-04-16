<?php

/**
 * ExamPaperMasterTbl form base class.
 *
 * @method ExamPaperMasterTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamPaperMasterTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'title'         => new sfWidgetFormInputText(),
      'is_build_flag' => new sfWidgetFormInputText(),
      'insert_date'   => new sfWidgetFormDateTime(),
      'update_date'   => new sfWidgetFormDateTime(),
      'delete_date'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_build_flag' => new sfValidatorInteger(array('required' => false)),
      'insert_date'   => new sfValidatorDateTime(array('required' => false)),
      'update_date'   => new sfValidatorDateTime(array('required' => false)),
      'delete_date'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_paper_master_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamPaperMasterTbl';
  }

}
