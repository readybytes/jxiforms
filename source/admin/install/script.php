<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of component
 */
class com_jxiformsInstallerScript
{
        /**
         * method to install the component
         *
         * @return void
         */
        function install($parent) 
        {
                // $parent is the class calling this method
                $parent->getParent()->setRedirectURL('index.php?option=com_jxiforms');
        }
}
