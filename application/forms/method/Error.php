<?php

class Application_Form_Method_Error extends Zend_Form
{
    public function init()
    {
        $this->setName('methodsAdd');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

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

        $body= new Zend_Form_Element_Textarea('body');
        $body->setLabel('Body:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );


        $submit = new Zend_Form_Element_Submit('add');
        $submit->setLabel('Add')->setAttrib('class','btn btn-primary');


        $this->addElements(array($name, $description,$body, $submit));


        $this->setMethod('post');
    }
}
