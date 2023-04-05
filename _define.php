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
$this->registerModule(
    'Featured Media',
    'Manage featured media for entry',
    'Franck Paul',
    '1.0',
    [
        'requires'    => [['core', '2.25']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
            initPages::PERMISSION_PAGES,
        ]),
        'priority' => 999,
        'type'     => 'plugin',

        'details'    => 'https://open-time.net/?q=featuredMedia',
        'support'    => 'https://github.com/franck-paul/featuredMedia',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/featuredMedia/master/dcstore.xml',
    ]
);
