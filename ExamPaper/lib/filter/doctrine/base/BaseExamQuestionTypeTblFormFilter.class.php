<?php

/**
 * ExamQuestionTypeTbl filter form base class.
 *
 * @package    ExamPaper
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionTypeTblFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'qt_name'     => new sfWidgetFormFilterInput(),
      'qt_abbr'     => new sfWidgetFormFilterInput(),
      'sequence'    => new sfWidgetFormFilterInput(),
      'delete_flag' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'qt_name'     => new sfValidatorPass(array('required' => false)),
      'qt_abbr'     => new sfValidatorPass(array('required' => false)),
      'sequence'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'delete_flag' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_question_type_tbl_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionTypeTbl';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'qt_name'     => 'Text',
      'qt_abbr'     => 'Text',
      'sequence'    => 'Number',
      'delete_flag' => 'Text',
    );
  }
}
