<?php

class Application_Form_Settingtable extends Zend_Form
{

    public function init()
    {
		$this->setAction($this->getView()->url(array('controller'=>'settingtable', 'action'=>'add')));
		$this->setMethod('post');
		$this->addElement('text', 'tableName', array('label' => 'Table Name:'));
		$this->addElement('submit', 'submit', array('ignore'=> true));
    }


}

