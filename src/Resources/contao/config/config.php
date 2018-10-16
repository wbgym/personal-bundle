<?php

/**
 * WBGym
 * 
 * Copyright (C) 2016 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @author 		Johannes Cram <craj.me@gmail.com>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/*
 * Front end modules
 */
$GLOBALS['FE_MOD']['wbuser']['wb_usersettings']  = 'WBGym\ModuleUserSettings';
$GLOBALS['FE_MOD']['wbuser']['wb_usermenu']  = 'WBGym\ModuleUserMenu';
$GLOBALS['FE_MOD']['wbuser']['wb_userprofile']  = 'WBGym\ModuleUserProfile';
$GLOBALS['FE_MOD']['wbuser']['wb_avatarupload']  = 'WBGym\ModuleAvatarUpload';


/*
 * Hooks
 */

 $GLOBALS['TL_HOOKS']['parseTemplate'][] = array('WBGym\WBUser','modifyLoginTemplate');

?>