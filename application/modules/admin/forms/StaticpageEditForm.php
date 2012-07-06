<?php

/**
 * modules_admin_forms_ObjectEditForm
 * 
 * @author pavel
 * @version 1
 */
	
class modules_admin_forms_StaticpageEditForm extends Zend_Form
{

	public function init() 
	{
		$oEl = new Zend_Form_Element_Text('title_ru');
                $oEl->setLabel('Страница(рус):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Text('title_en');
                $oEl->setLabel('Страница(англ):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Text('title_ua');
                $oEl->setLabel('Страница(укр):');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Textarea('content_ru');
                $oEl->setLabel('Текст страницы(рус):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
		$oEl = new Zend_Form_Element_Textarea('content_en');
                $oEl->setLabel('Текст страницы(англ):');
                $oEl->setAttrib('class', 'tiny');
		$oEl->setRequired(false);
		$this->addElement($oEl);
                
		$oEl = new Zend_Form_Element_Textarea('content_ua');
                $oEl->setLabel('Текст страницы(укр):');
                $oEl->setAttrib('class', 'tiny');
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

