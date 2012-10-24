<?php

class SettingtableController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
		$this->view->form = new Application_Form_Settingtable();
    }

    public function addAction()
	{
		if($this->getRequest()->isPost()){	
			$this->view->form = new Application_Form_SettingtableOptions($this->getRequest()->getPost('tableName'));
		}
    }


}



