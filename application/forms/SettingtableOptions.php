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
		foreach($this->columnNames as $column)
		{
			$this->addElement('text', $column . "Name", array('label'=>'Readable name for ' . $column));
			$this->addElement('checkbox', $column . "Show", array('label'=>'Show ' . $column));
		}
		$this->addElement('submit', 'submit', array('ignore'=> true));
    }
}

