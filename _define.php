<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of featuredMedia, a plugin for Dotclear 2.
#
# Copyright (c) Franck Paul and contributors
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */			"Featured Media",
	/* Description*/	"Manage featured media for entry",
	/* Author */		"Franck Paul",
	/* Version */		'0.1',
	array(
		/* Dependencies */	'requires' 		=>	array(array('core','2.9')),
		/* Permissions */	'permissions' 	=>	'usage,contentadmin,pages',
		/* Priority */		'priority' 		=>	999,
		/* Type */			'type'			=>	'plugin'
	)
);
