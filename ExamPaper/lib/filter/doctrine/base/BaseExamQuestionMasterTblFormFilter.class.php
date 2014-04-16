<?php

/**
 * ExamQuestionMasterTbl filter form base class.
 *
 * @package    ExamPaper
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionMasterTblFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ques_content'      => new sfWidgetFormFilterInput(),
      'ques_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'add_empty' => true)),
      'ques_chapter_ids'  => new sfWidgetFormFilterInput(),
      'ques_difficulties' => new sfWidgetFormFilterInput(),
      'pic_path'          => new sfWidgetFormFilterInput(),
      'insert_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'update_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'delete_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'ques_content'      => new sfValidatorPass(array('required' => false)),
      'ques_type_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'column' => 'id')),
      'ques_chapter_ids'  => new sfValidatorPass(array('required' => false)),
      'ques_difficulties' => new sfValidatorPass(array('required' => false)),
      'pic_path'          => new sfValidatorPass(array('required' => false)),
      'insert_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'update_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'delete_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('exam_question_master_tbl_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionMasterTbl';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'ques_content'      => 'Text',
      'ques_type_id'      => 'ForeignKey',
      'ques_chapter_ids'  => 'Text',
      'ques_difficulties' => 'Text',
      'pic_path'          => 'Text',
      'insert_date'       => 'Date',
      'update_date'       => 'Date',
      'delete_date'       => 'Date',
    );
  }
}
