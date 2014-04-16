<?php

/**
 * ExamQuestionChapterTbl form base class.
 *
 * @method ExamQuestionChapterTbl getObject() Returns the current form's model object
 *
 * @package    ExamPaper
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExamQuestionChapterTblForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'parent_cid' => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormInputText(),
      'is_parent'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_cid' => new sfValidatorInteger(array('required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_parent'  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('exam_question_chapter_tbl[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExamQuestionChapterTbl';
  }

}
