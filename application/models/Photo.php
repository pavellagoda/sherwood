<?php

/**
 * Class representing Staticpage model
 * @author pavel
 *
 */
class models_Photo {

    public $id;
    public $extention;
    public $title_ru;
    public $title_en;
    public $title_ua;

    public function toArray() {
        return array(
            'id' => $this->id,
            'extention' => $this->extention,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'title_ua' => $this->title_ua,
        );
    }

}