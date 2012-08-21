<?php

/**
 * modules_admin_forms_ObjectEditForm
 * 
 * @author pavel
 * @version 1
 */
class modules_admin_forms_InfoEditForm extends Zend_Form
{

    public function init()
    {
        $oEl = new Zend_Form_Element_Textarea('text_ru');
        $oEl->setLabel('Текст(рус):');
        $oEl->setAttrib('class', 'tiny');
        $oEl->setRequired(true);
        $this->addElement($oEl);

        $oEl = new Zend_Form_Element_Textarea('text_en');
        $oEl->setLabel('Текст(англ):');
        $oEl->setAttrib('class', 'tiny');
        $oEl->setRequired(true);
        $this->addElement($oEl);

        $oEl = new Zend_Form_Element_Textarea('text_ua');
        $oEl->setLabel('Текст(укр):');
        $oEl->setAttrib('class', 'tiny');
        $oEl->setRequired(true);
        $this->addElement($oEl);

        $element = new Zend_Form_Element_File('bg');
        $element->setLabel('Фон:');
        $element->setAttrib('size', '51');
        $element->setValueDisabled(true);
        $element->addValidator('File_Count', false, array('count' => 1));
        $element->addValidator('File_Extension', false, array('png', 'jpg', 'gif', 'jpeg'));
        $this->addElement($element);

        $oEl = new Zend_Form_Element_Submit('submit');
        $oEl->setLabel('Сохранить');
        $oEl->setRequired(false);
        $this->addElement($oEl);
    }

}

