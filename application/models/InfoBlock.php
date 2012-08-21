<?php

/**
 * Class representing InfoBlock model
 * @author pavel
 *
 */
class models_InfoBlock
{

    public $id;
    public $text_ru;
    public $text_en;
    public $text_ua;
    public $background_extention;
    public $status;

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'text_ru' => $this->text_ru,
            'text_en' => $this->text_en,
            'text_ua' => $this->text_ua,
            'background_extention' => $this->background_extention,
            'status' => $this->status,
        );
    }

}