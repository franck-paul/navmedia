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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'Media Navigator',                  // Name
    'Navigate between media in folder', // Description
    'Franck Paul',                      // Author
    '1.4',
    [
        'requires'    => [['core', '2.23']], // Dependencies
        'permissions' => 'contentadmin',     // Permissions
        'type'        => 'plugin',           // Type
        'priority'    => 10000,              // Priority

        'details'    => 'https://open-time.net/?q=navmedia',       // Details URL
        'support'    => 'https://github.com/franck-paul/navmedia', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/navmedia/master/dcstore.xml',
    ]
);
