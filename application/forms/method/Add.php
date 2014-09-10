<?php

class Application_Form_Method_Add extends Zend_Form
{
    public function init()
    {
        $this->setName('methodsAdd');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        $project = new Application_Model_DbTable_Projects();

        $projectId = new Zend_Form_Element_Select('projectId');
        $projectId
            ->setLabel('Project:')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addMultiOptions($project->getSelect())
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );



        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $short = new Zend_Form_Element_Textarea('short');
        $short->setLabel('Short:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
        $success = new Zend_Form_Element_Textarea('success');
        $success
            ->setLabel('Success:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $data = new Zend_Form_Element_Textarea('data');
        $data ->setLabel('Data:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $submit = new Zend_Form_Element_Submit('add');
        $submit->setLabel('Add')->setAttrib('class','btn btn-primary');


        $this->addElements(array($name,$projectId,$short, $description,$success,$data, $submit));


        $this->setMethod('post');
    }
}
