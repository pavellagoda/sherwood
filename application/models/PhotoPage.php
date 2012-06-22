<?php

/**
 * Class representing Staticpage model
 * @author pavel
 *
 */
class models_PhotoPage {

    public $photo_id;
    public $page;

    public function toArray() {
        return array(
            'photo_id'      => $this->photo_id,
            'page'          => $this->page,
        );
    }

}