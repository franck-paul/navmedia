<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of Media Navigator, a plugin for Dotclear 2.
#
# Copyright (c) Franck Paul and contributors
# carnet.franck.paul@gmail.com
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */				"Media Navigator",
	/* Description*/		"Navigate between media in folder",
	/* Author */			"Franck Paul",
	/* Version */			'1.2',
	/* Permissions */		'contentadmin',
	/* Priority */			10000
);
?>