<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRegistryWithDB()
    {
        $this->bootstrap('db');
        $db = $this->getResource('db');
        Zend_Registry::set('db', $db);
    }

    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }

    /**
     * Register RAMP configuration settings.
     */
    protected function _initRamp()
    {
        $configOptions = $this->getOptions();
        if ( isset($configOptions['ramp']) )
        {
            // Read the configuration settings that may vary from Ramp 
            // application to application, or even among different 
            // environments within an application (e.g., production vs. 
            // test vs. development environments).
            $rampConfigSettings = $configOptions['ramp'];

            // Register the Access Control List roles.
            if ( ! empty($rampConfigSettings['aclNonGuestRole']) )
            {
                $aclRoles = $rampConfigSettings['aclNonGuestRole'];
                Zend_Registry::set('rampAclRoles', $aclRoles);
            }
            unset($rampConfigSettings['aclNonGuestRole']);

            // Register the Access Control List activity list resources.
            if ( !
                 empty($rampConfigSettings['activityListResourceDirectories'])
               )
            {
                $dirs = $rampConfigSettings['activityListResourceDirectories'];
                Zend_Registry::set('rampAclActivityListDirs', $dirs);
            }
            unset($rampConfigSettings['activityListResourceDirectories']);

            // Register the directory that stores table settings.
            if ( ! empty($rampConfigSettings['settingsDirectory']) )
            {
                $path = $rampConfigSettings['settingsDirectory'];
                Zend_Registry::set('rampSettingsDirectory', $path);
            }
            unset($rampConfigSettings['settingsDirectory']);

            // Register the rest of the configuration settings as a group.
            Zend_Registry::set('rampConfigSettings', $rampConfigSettings);
        }

	// Register the (currently empty) associated array of
	// read-in settings and setting information.
        $settings = array();
        Zend_Registry::set('rampTableViewingSequences', $settings);
    }

    /**
     * Register the ACL (Access Control List) plugin to check for
     * authorization to perform various actions.
     *
     * Based on a tutorial found at:
     *    http://www.ens.ro/2012/03/20/
     *        zend-authentication-and-authorization-tutorial-with-
     *        zend_auth-and-zend_acl/
     * -- Justin Leatherwood, 13 November 2012
     */
    protected function _initACL()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Ramp_');

        $objFront = Zend_Controller_Front::getInstance();
        $objFront->registerPlugin(new Ramp_Controller_Plugin_ACL(), 1);
        return $objFront;
    }

    protected function _initNavigation()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $configSettings = Zend_Registry::get('rampConfigSettings');
        $indexFilename = isset($configSettings['initialActivity']) ?
            $configSettings['initialActivity'] : null;
        $menuFilename = isset($configSettings['menuFilename']) ?
            $configSettings['menuFilename'] : null;
        $menu = new Zend_Navigation();
        $ini = new Zend_Config_Ini($menuFilename);
        foreach($ini as $entry)
        {
            $uri = '/';
            $children = array();
            //assumption: a menu entry with no url is the home entry
            if(!is_null($entry->url)){
                $uri = '/' . $entry->url->controller . '/' 
                    . $entry->url->action . '/activity/' 
                    //must double encode urls so they work properly with the activityController
                    . urlencode(urlencode($entry->url->activity));
            }
            else
            {
                $children = $this->_readActivityMenu(APPLICATION_PATH . '/settings/' . $indexFilename);
            }
            $menu->addPage(new Zend_Config(array(
                'label' => $entry->title,
                'uri' => $uri,
                'pages' => $children
            )));
        }
        $view->navigation($menu);
    }

    protected function _readActivityMenu($filename)
    {
        $activityMenu = new Zend_Config_Ini($filename);
        $pages = array();
        foreach($activityMenu as $activity)
        {
            if(!(is_null($activity->source)))
            {
                //assumption: all setting type activities have links
                $uri = '/table/index/_setting/'. urlencode(urlencode($activity->source));
                array_push($pages, array(
                    'label' => $activity->title,
                    'uri' => $uri
                ));
            }
        }
        return $pages;
    }
}

