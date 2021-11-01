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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'Featured Media',                  // Name
    'Manage featured media for entry', // Description
    'Franck Paul',                     // Author
    '0.4',                             // Version
    [
        'requires'    => [['core', '2.19']],                             // Dependencies
        'permissions' => 'usage,contentadmin,pages',                     // Permissions
        'priority'    => 999,                                            // Priority
        'type'        => 'plugin',                                       // Type

        'details'    => 'https://open-time.net/?q=featuredMedia',       // Details URL
        'support'    => 'https://github.com/franck-paul/featuredMedia', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/featuredMedia/master/dcstore.xml'
    ]
);
