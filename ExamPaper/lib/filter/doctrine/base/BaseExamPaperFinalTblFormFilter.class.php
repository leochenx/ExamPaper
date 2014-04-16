<?php

/**
 * ExamPaperFinalTbl filter form base class.
 *
 * @package    ExamPaper
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExamPaperFinalTblFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'exam_paper_id'     => new sfWidgetFormFilterInput(),
      'exam_ques_type_id' => new sfWidgetFormFilterInput(),
      'exam_ques_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionMasterTbl'), 'add_empty' => true)),
      'insert_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'update_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'delete_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'exam_paper_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'exam_ques_type_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'exam_ques_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExamQuestionMasterTbl'), 'column' => 'id')),
      'insert_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'update_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'delete_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('exam_paper_final_tbl_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamPaperFinalTbl';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'exam_paper_id'     => 'Number',
      'exam_ques_type_id' => 'Number',
      'exam_ques_id'      => 'ForeignKey',
      'insert_date'       => 'Date',
      'update_date'       => 'Date',
      'delete_date'       => 'Date',
    );
  }
}
