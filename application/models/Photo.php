<?php

/**
 * Class representing Staticpage model
 * @author pavel
 *
 */
class models_Photo {

    public $id;
    public $extention;

    public function toArray() {
        return array(
            'id' => $this->id,
            'extention' => $this->extention,
        );
    }

}