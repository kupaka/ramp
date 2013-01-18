<?php

class Ramp_Controller_Plugin_ActionSetup extends Zend_Controller_Plugin_Abstract
{

    /**
     * Take care of any items to do before any dispatch loop starts:
     *      Add items to the ActionStack, to enable multiple actions in 
     *              each dispatch.
     * From Zend Framework in Action by Allen, Lo, and Brown,
     *      2009, p. 73.
     *
     * @param Zend_Controller_Request_Abstract $request  the user request 
     * that this dispatch loop is addressing
     */ 
    public function dispatchLoopStartup(
        Zend_Controller_Request_Abstract $request)
    {
    }

}
