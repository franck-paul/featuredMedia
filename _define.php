<?php

/**
 * @brief featuredMedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'Featured Media',
    'Manage featured media for entry',
    'Franck Paul',
    '7.3.1',
    [
        'date'     => '2026-04-09T19:18:27+0200',
        'requires' => [
            ['core', '2.36'],
            ['TemplateHelper'],
        ],
        'permissions' => 'My',
        'priority'    => 999,
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=featuredMedia',
        'support'    => 'https://github.com/franck-paul/featuredMedia',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/featuredMedia/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
