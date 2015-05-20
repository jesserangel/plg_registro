<?php
/**
 * @copyright  Copyright (C) 2012 Mark Dexter & Louis Landry. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @author     Jesse Rangel, Web developer in portaldirecto.com
 */

defined('JPATH_BASE') or die;
jimport('joomla.plugin.plugin');


class plgUserValidterms extends JPlugin
{

    /* Metodo que se encargara de validar si el usuario marca las casillas de terminos de usuario y de mayoria de edad */

    function onUserBeforeSave($previousData, $isNew, $futureData)
    {
         
        /* Condicional que comprueba si estamos registrando al nuevo usuario desde el front-end */

         if (!$isNew || !JFactory::getApplication()->isSite()) {
            return true;
         }

         /* Carga de los archivos de lenguaje para el plugin */

         $this->loadLanguage();
         $result = true;

         /* Condicional que verifica si el usuario a marcado el checkbox correspondiente a los terminos de servicio */

         if (!JRequest::getBool('tos_agree')) {
             JError::raiseWarning(100,
                 JText::_('PLG_USER_VALIDTERMS_TOS_AGREE_REQUIRED'));
            $result =  false;
         }

         /* Condicional que verifica si el usuario a marcado el checkbox correspondiente a ser mayor de 18 años */

         if (!JRequest::getBool('old_enough')) {
            JError::raiseWarning(100,
                 JText::_('PLG_USER_VALIDTERMS_OLD_ENOUGH_REQUIRED'));
            $result =  false;
         }

        /* Devuelve "true" si salio todo bien o "false" en caso contrario */

         return $result;
    }
}