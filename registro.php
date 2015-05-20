<?php
/**
 * @copyright  Copyright (C) 2012 Mark Dexter & Louis Landry. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
jimport('joomla.plugin.plugin');

/**
 * This is our custom registration plugin class.  It verifies that the user
 *  checked the boxes indicating that he/she agrees to the terms of service
 *  and is old enough to use the site.
 */
class plgUserRegistro extends JPlugin
{
    /**
     * Method to handle the "onUserBeforeSave" event and determine
     * whether we are happy with the input enough that we will allow
     * the save to happen.  Specifically we are checking to make sure that
     * this is saving a new user (user registration), and that the
     * user has checked the boxes that indicate agreement to the terms of
     * service and that he/she is old enough to use the site.
     *
     * @param   array  $previousData  The currently saved data for the user.
     * @param   bool   $isNew         True if the user to be saved is new.
     * @param   array  $futureData    The new data to save for the user.
     *
     * @return  bool   True to allow the save process to continue,
     *                   false to stop it.
     *
     * @since   1.0
     */

    function onUserBeforeSave($previousData, $isNew, $futureData)
    {
         // If we aren't saving a "new" user (registration), or if we are not
         // in the front end of the site, then let the
         //   save happen without interruption.
         if (!$isNew || !JFactory::getApplication()->isSite()) {
            return true;
         }

         // Load the language file for the plugin
         $this->loadLanguage();
         $result = true;

         // Verify that the "I agree to the terms of service for this site."
         //   checkbox was checked.
         if (!JRequest::getBool('tos_agree')) {
             JError::raiseWarning(100,
                 JText::_('PLG_USER_REGISTRATION_TOS_AGREE_REQUIRED'));
            $result =  false;
         }

         // Verify that the "I am at least 18 years old." checkbox was checked.
         if (!JRequest::getBool('old_enough')) {
            JError::raiseWarning(100,
                 JText::_('PLG_USER_REGISTRATION_OLD_ENOUGH_REQUIRED'));
            $result =  false;
         }

         return $result;
    }
}