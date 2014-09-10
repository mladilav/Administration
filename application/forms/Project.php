<?php

class Application_Form_Project extends Zend_Form
{
    public function init()
    {
        $this->setName('ProjectAdd');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        $id = new Zend_Form_Element_Hidden('id');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
            ->setRequired(true)
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
        $submit = new Zend_Form_Element_Submit('add');
        $submit->setLabel('Add')->setAttrib('class','btn btn-primary');
        $this->addElements(array($id,$name, $description, $submit));
        $this->setMethod('post');
    }
}
