<?php

class Application_Form_SettingtableOptions extends Zend_Form
{
	public function __construct($tableName){
		Zend_Db_Table::setDefaultAdapter($dbAdapter);
		$metadata = new Zend_Db_Table($tableName)->info();
		$columns = array_keys($metadata);
	}

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }


}

