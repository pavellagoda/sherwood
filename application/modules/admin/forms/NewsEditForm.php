<?php

/**
 * modules_admin_forms_NewsEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_NewsEditForm extends Zend_Form
{

	public function init() 
	{
		$oEl = new Zend_Form_Element_Text('title_ru');
                $oEl->setLabel('Заголовок(рус):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
                
		$oEl = new Zend_Form_Element_Text('title_en');
                $oEl->setLabel('Заголовок(англ):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
                
		$oEl = new Zend_Form_Element_Text('title_ua');
                $oEl->setLabel('Заголовок(укр):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Textarea('short_ru');
                $oEl->setLabel('Короткое описание(рус):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(true);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('short_en');
                $oEl->setLabel('Короткое описание(англ):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(true);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('short_ua');
                $oEl->setLabel('Короткое описание(укр):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Textarea('full_ru');
                $oEl->setLabel('Полный текст новости(рус):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('full_en');
                $oEl->setLabel('Полный текст новости(англ):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Textarea('full_ua');
                $oEl->setLabel('Полный текст новости(укр):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
                $oEl = new Zend_Form_Element_Submit('submit');
                $oEl->setLabel('Сохранить');
		$oEl->setRequired(false);
		$this->addElement($oEl);
	}

}

