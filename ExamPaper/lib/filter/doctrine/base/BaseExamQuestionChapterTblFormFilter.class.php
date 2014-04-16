<?php

/**
 * ExamQuestionChapterTbl filter form base class.
 *
 * @package    ExamPaper
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionChapterTblFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_cid' => new sfWidgetFormFilterInput(),
      'name'       => new sfWidgetFormFilterInput(),
      'is_parent'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'parent_cid' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'       => new sfValidatorPass(array('required' => false)),
      'is_parent'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_question_chapter_tbl_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionChapterTbl';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'parent_cid' => 'Number',
      'name'       => 'Text',
      'is_parent'  => 'Text',
    );
  }
}
