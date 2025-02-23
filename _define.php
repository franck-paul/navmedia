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
$this->registerModule(
    'Media Navigator',
    'Navigate between media in folder',
    'Franck Paul',
    '5.5',
    [
        'date'        => '2025-02-21T12:37:18+0100',
        'requires'    => [['core', '2.28']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'priority'    => 10000,

        'details'    => 'https://open-time.net/?q=navmedia',
        'support'    => 'https://github.com/franck-paul/navmedia',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/navmedia/main/dcstore.xml',
    ]
);
