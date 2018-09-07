<?php

/**
 * WBGym
 * 
 * Copyright (C) 2016 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @version 	0.3.0
 * @author 		Johannes Cram <craj.me@gmail.com>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace WBGym;

class ModuleAvatarUpload extends \Module
{
protected $strTemplate = 'wb_avatarupload';
	
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### WBGym User-Profil ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		return parent::generate();
	}

	protected function compile(){
		
		$this->import('FrontendUser','User');
		
		if(\Input::get('user') != $this->User->id) {
			$this->Template->active = false;
			return;
		}
		$this->Template->active = true;
		
		if($this->User->student) $userType = 'student';
		elseif($this->User->teacher) $userType = 'teacher';
		
		$this->Template->userType = $userType;
		
		if($_SERVER['REQUEST_METHOD'] == 'POST' && FE_USER_LOGGED_IN && \Input::post('base64')) {
			//save new image in files/avatars
			$data = \Input::post('base64');
			$fileName = $this->User->username;
				
			//write new file
			$objFile = new \File('files/avatars/' . $fileName . '.png');
			$data = explode(',',$data)[1];
			$objFile->write(base64_decode($data));
			$objFile->close();
		}
	}

}

?>