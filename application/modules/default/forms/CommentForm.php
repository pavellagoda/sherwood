<?php

/**
 * modules_default_forms_CommentForm
 * 
 * @author valery
 * @version 1
 */
class modules_default_forms_CommentForm extends Zend_Form {

    public $captcha;

    public function init() {
        $textElement = new Zend_Form_Element_Textarea('text');
        $textElement->setRequired(true);
        $textElement->setAttrib('rows', 7);
        $textElement->setAttrib('cols', 35);
        $textElement->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('Errors');
        $this->addElement($textElement);

        $nameElement = new Zend_Form_Element_Text('name');
        $nameElement->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('Errors');
        $nameElement->setRequired(true);
        $this->addElement($nameElement);

        $emailElement = new Zend_Form_Element_Text('email');
        $emailElement->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('Errors');
        $validator = new Zend_Validate_EmailAddress();
        $emailElement->addValidator($validator);
        $emailElement->setRequired(true);
        $this->addElement($emailElement);
        
        Zend_Captcha_Word::$CN = Zend_Captcha_Word::$C = Zend_Captcha_Word::$VN = Zend_Captcha_Word::$V = array("0","1","2","3","4","5","6","7","8","9");
        
        $captchaElement = new Zend_Form_Element_Captcha('captcha', array(
                    'captcha' => array(
                        'captcha' => 'Image',
                        'wordLen' => 5,
                        'timeout' => 300,
                        'font' => 'fonts/arial.ttf',
                        'imgDir' => 'img/captcha',
                        'imgUrl' => '/img/captcha',
                        'imgAlt' => 'captcha-img',
                        'width' => 170,
                        'height' => 60,
                        'expiration' => 60,
                        'gcFreq' => 5,
                        'fsize' => 60,
                        'DotNoiseLevel' => 0,
                        'LineNoiseLevel' => 0
                    )
                ));

        $captchaElement->setRequired(true);
        $captchaElement->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('Errors');
        $this->captcha = $captchaElement;

        $this->addElement($captchaElement);
    }

}

