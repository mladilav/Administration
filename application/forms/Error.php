<?php

class Application_Form_Error extends Zend_Form
{
    public function init()
    {

        $this->setName('error');


        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        $capture = new Zend_Form_Element_Text('capture');
        $capture->setLabel('Capture:')
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
        $submit->setLabel('Add');


        $this->addElements(array($capture, $description, $submit));
        $this->setMethod('post');
    }
}
