<?php

class Application_Form_Bugs extends Zend_Form
{
    public function init()
    {

        $this->setName('bugs');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
        $text = new Zend_Form_Element_Textarea('text');
        $text
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
        $submit = new Zend_Form_Element_Button('addbugs');
        $submit->setLabel('send')->setAttrib('class','btn btn-primary');
        $this->addElements(array($text, $submit));
        $this->setMethod('post');
    }
}
