<?php

/**
 * WBGym
 * 
 * Copyright (C) 2015 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @version 	0.3.0
 * @author 	Johannes Cram <craj.me@gmail.com>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace WBGym;

class ModuleUserMenu extends \Module
{
protected $strTemplate = 'wb_usermenu';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### WBGym User Menu ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		return parent::generate();
		
	}

protected function compile(){
	
	if(FE_USER_LOGGED_IN) {
		$this->Template->avatar = WBUser::getUserAvatar();
		$this->Template->mode = 1;
		/*$this->Template->newMessages = WBUser::getNewMessages();
		$this->Template->latestMessages = WBUser::getLatestMessages();*/
	}
	else $this->Template->mode = 0;
}

}
?>