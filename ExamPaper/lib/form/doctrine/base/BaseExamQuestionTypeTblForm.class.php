<?php

/**
 * ExamQuestionTypeTbl form base class.
 *
 * @method ExamQuestionTypeTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionTypeTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'qt_name'     => new sfWidgetFormInputText(),
      'qt_abbr'     => new sfWidgetFormInputText(),
      'sequence'    => new sfWidgetFormInputText(),
      'delete_flag' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'qt_name'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'qt_abbr'     => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'sequence'    => new sfValidatorInteger(array('required' => false)),
      'delete_flag' => new sfValidatorString(array('max_length' => 1, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_question_type_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionTypeTbl';
  }

}
