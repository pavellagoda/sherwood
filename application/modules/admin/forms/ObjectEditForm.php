<?php

/**
 * modules_admin_forms_ObjectEditForm
 * 
 * @author pavel
 * @version 1
 */
	
class modules_admin_forms_ObjectEditForm extends Zend_Form
{

	public function init() 
	{
		$oEl = new Zend_Form_Element_Text('title');
                $oEl->setLabel('Заголовок:');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Textarea('short');
                $oEl->setLabel('Короткое описание:');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Textarea('full');
                $oEl->setLabel('Полное описание:');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Checkbox('is_tour');
                $oEl->setLabel('Виртуальный тур:');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('head_meta');
                $oEl->setLabel('Meta Keywords:');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('head_description');
                $oEl->setLabel('Meta Description:');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('head_title');
                $oEl->setLabel('Meta Title:');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Submit('submit');
                $oEl->setLabel('Сохранить');
		$oEl->setRequired(false);
		$this->addElement($oEl);
	}

}

