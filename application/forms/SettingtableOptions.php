<?php

class Application_Form_SettingtableOptions extends Zend_Form
{
	private $columnNames;

	public function __construct($tablenames){
		Zend_Db_Table::getDefaultAdapter();
		$table = new Zend_Db_Table($tablenames);
		//$metadata = $table->info();
		$this->columnNames = $table->info(Zend_Db_Table_Abstract::COLS);
		parent::__construct();
	}

    public function init()
	{
		$this->setMethod('post');
		$column = array_shift($this->columnNames);
		$this->addElement('text', $column, array('label' => $column)); 
		$this->addElement('submit', 'submit', array('ignore'=> true));
    }


}

