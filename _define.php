<?php
/**
 * @brief featuredMedia, a plugin for Dotclear 2
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
    "Featured Media",                  // Name
    "Manage featured media for entry", // Description
    "Franck Paul",                     // Author
    '0.2',                             // Version
    [
        'requires'    => [['core', '2.13']],                             // Dependencies
        'support'     => 'https://github.com/franck-paul/featuredMedia', // Support URL
        'permissions' => 'usage,contentadmin,pages',                     // Permissions
        'priority'    => 999,                                            // Priority
        'type'        => 'plugin'                                        // Type
    ]
);
