<?php

class Application_Form_SettingtableOptions extends Zend_Form
{
	private $tableName;
	private $columnNames;
	private $url;

	public function __construct($tablenames){
		Zend_Db_Table::getDefaultAdapter();
		$table = new Zend_Db_Table($tablenames);
		$tableInfo = $table->info();
		$this->tableName = $tableInfo['name'];
		//$metadata = $table->info();
		$this->columnNames = $table->info(Zend_Db_Table_Abstract::COLS);
		parent::__construct();
	}
	
	//uses code from http://stackoverflow.com/questions/3848188/appending-or-prepending-html-tags-to-zend-form-element
    public function init()
	{
		$this->setAction('write');
		$this->setMethod('post');
		$tName = $this->createElement('hidden',"tableName");
		$tName->setValue($this->tableName);
		$this->addElement($tName);
		foreach($this->columnNames as $column)
		{
			$name = $this->createElement('text', "field_" . $column . "_label", array('label'=>'Readable name for ' . $column));
			$name->setDecorators(array(
				'ViewHelper',
				'Errors',
				'Label',
				array(array('openDiv'=>'HtmlTag'),
					array('tag'=>'div','openOnly'=> true)
				)
			));
			$this->addElement($name);
			$show = $this->createElement('checkbox', "field_" . $column . "_hide", array('label'=>'Hide '));
			$show->setDecorators(array(
				'ViewHelper',
				'Errors',
				'Label',
				array(array('closeDiv'=>'HtmlTag'),
					array('tag'=>'div','closeOnly'=> true)
				)
			));
			$this->addElement($show);
		}
		$this->addElement('submit', 'submit', array('ignore'=> true));
    }
}

