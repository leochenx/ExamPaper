<?php

/**
 * ExamPaperConfigTbl filter form base class.
 *
 * @package    ExamPaper
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExamPaperConfigTblFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ep_id'              => new sfWidgetFormFilterInput(),
      'ep_ques_type_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'add_empty' => true)),
      'ep_ques_chapter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExamQuestionChapterTbl'), 'add_empty' => true)),
      'ep_ques_number'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ep_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ep_ques_type_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExamQuestionTypeTbl'), 'column' => 'id')),
      'ep_ques_chapter_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExamQuestionChapterTbl'), 'column' => 'id')),
      'ep_ques_number'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('exam_paper_config_tbl_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamPaperConfigTbl';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'ep_id'              => 'Number',
      'ep_ques_type_id'    => 'ForeignKey',
      'ep_ques_chapter_id' => 'ForeignKey',
      'ep_ques_number'     => 'Number',
    );
  }
}
