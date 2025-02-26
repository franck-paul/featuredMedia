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
    '5.2',
    [
        'date'        => '2025-02-26T16:08:26+0100',
        'requires'    => [['core', '2.33']],
        'permissions' => 'My',
        'priority'    => 999,
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=featuredMedia',
        'support'    => 'https://github.com/franck-paul/featuredMedia',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/featuredMedia/main/dcstore.xml',
    ]
);
