<?php

/**
 * Class representing Comments table
 * @author pavel
 *
 */

class models_DbTable_Comments extends Zend_Db_Table_Abstract
{
	
	public $_name = 'comments';
	
	public $_primary = 'id';
}