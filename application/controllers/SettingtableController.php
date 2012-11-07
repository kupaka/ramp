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
    public function writeAction()
    {
	   $this->write_ini_file($this->getRequest()->getPost(), APPLICATION_PATH . "/settings/GenFiles/data.ini", false);
    }
// Method to write an ini file found at http://stackoverflow.com/questions/1268378/create-ini-file-write-values-in-php
function write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
    $content = ""; 
    if ($has_sections) { 
        foreach ($assoc_arr as $key=>$elem) { 
            $content .= "[".$key."]\n"; 
            foreach ($elem as $key2=>$elem2) { 
                if(is_array($elem2)) 
                { 
                    for($i=0;$i<count($elem2);$i++) 
                    { 
                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
                    } 
                } 
                else if($elem2==""); 
                else $content .= $key2." = \"".$elem2."\"\n"; 
            } 
        } 
    } 
    else { 
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
                } 
            } 
            else if($elem==""); 
            else $content .= $key." = \"".$elem."\"\n"; 
        } 
    } 

    if (!$handle = fopen($path, 'w')) { 
        return false; 
    } 
    if (!fwrite($handle, $content)) { 
        return false; 
    } 
    fclose($handle); 
    return true; 
}

}



