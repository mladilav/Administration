<?php

class Application_Form_Request extends Zend_Form
{
    public function init()
    {

        $this->setName('RequestMethods');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
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
        $this->addElements(array( $description, $submit));
        $this->setMethod('post');
    }
}
