<?php
/**
 * @brief navmedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
    "Media Navigator",                  // Name
    "Navigate between media in folder", // Description
    "Franck Paul",                      // Author
    '1.3',                              // Version
    [
        'requires'    => [['core', '2.13']], // Dependencies
        'permissions' => 'contentadmin',     // Permissions
        'type'        => 'plugin',           // Type
        'priority'    => 10000              // Priority
    ]
);
