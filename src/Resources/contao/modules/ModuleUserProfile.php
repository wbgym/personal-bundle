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

class ModuleUserProfile extends \Module
{
protected $strTemplate = 'wb_userprofile';

protected $isMe = false;

protected $objUser;

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
		$this->import('Database');
		
		$uid = \Input::get('user');
		$objMe = \FrontendUser::getInstance();
		
		//find user
		if($uid != $objMe->id) {
			$this->objUser = \MemberModel::findById($uid);
			$blnFound = is_object($this->objUser);
		}
		//set mode if it's the profile of current user
		else {
			$this->objUser = $objMe;
			$this->isMe = true;
			$this->isEditP = \Input::get('edit') == 'profile';
			$this->isEditA = \Input::get('edit') == 'avatar';
		}
		
		//generate 404 if user not found or user is guest
		if(\Input::get('user') == '' || $blnFound == false && !$this->isMe) {
			global $objPage;
			$objHandler = new $GLOBALS['TL_PTY']['error_404']();
			$objHandler->generate($objPage->id);
		}
		elseif(!FE_USER_LOGGED_IN) {
			global $objPage;
			$objHandler = new $GLOBALS['TL_PTY']['error_403']();
			$objHandler->generate($objPage->id);
		}
		$strType = WBUser::getUserType($uid);
		
		//generate name of user
		if($strType == 'Schüler' || $strType == 'Eltern') {
			$this->Template->name = $this->objUser->firstname . ' ' . $this->objUser->lastname;
		}
		elseif($strType == 'Lehrer' || $strType == 'Referendar') {
			$strSalutation = $this->objUser->gender == 'male' ? 'Herr' : 'Frau';
			$this->Template->name = $strSalutation . ' ' . $this->objUser->firstname[0] . '. ' . $this->objUser->lastname . ' <span class="abbr">| ' . $this->objUser->acronym . '</span>';
		}
		
		//save post data in db
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $this->isMe) {
			
			if(\Input::post('FORM_SUBMIT') == 'profile') $this->saveProfile();
			elseif(\Input::post('FORM_SUBMIT') == 'avatar') $this->saveAvatar();
		}

		//set template data
		if($this->isEditP) {
			global $objPage;
			$objPage->title = 'Profil bearbeiten';
		}
		elseif($this->isEditA) {
			global $objPage;
			$objPage->title = 'Profilbild bearbeiten';
		}
		
		$this->Template->fields = $this->compileFields($strType);
		$this->Template->isEditP = $this->isEditP;
		$this->Template->isEditA = $this->isEditA;
		$this->Template->url = \Environment::get('requestUri');
		$this->Template->baseUrl = explode('/edit',\Environment::get('requestUri'))[0];
		$this->Template->editUrlP = $this->addToUrl('edit=profile');
		$this->Template->editUrlA = $this->addToUrl('edit=avatar');
		$this->Template->browser = $this->replaceInsertTags('{{ua::browser}}');
		$this->Template->User = $this->objUser;
		$this->Template->avatar = WBUser::getUserAvatar($uid);
		$this->Template->type = WBUser::getUserType($uid);
		$this->Template->isMod = WBUser::isModerator($uid);
		$this->Template->isMe = $this->isMe;
	}
	
	/*
	* Generate the Profile Table for the Profile of the user
	*
	* @param string $strType The type of the user
	* @return array
	*/
	protected function compileFields($strType) {
		/*
		* Schüler
		*/
		if($strType == 'Schüler') {
			$arrFields = array(
				'Klasse / Kurs'	=>	array('value' => unserialize($this->objUser->privacy)['grade'], 'label' => WBGym::course($this->objUser->course), 'edit' => 'privacy', 'id' => 'grade'),
				'Alter'				=>	array('value' => unserialize($this->objUser->privacy)['age'], 'label' => floor((date("Ymd") - date("Ymd",$this->objUser->dateOfBirth)) / 10000) . ' Jahre', 'edit' => 'privacy', 'id' => 'age'),
				'Über mich'		=>	array('value' => $this->objUser->about, 'edit' => 'textarea', 'id' => 'about'),
				'Arbeitsgemeinschaften' =>	array('value' => $this->objUser->workshops, 'edit' => 'checkboxes', 'id' => 'workshops'),
				'Gremien'		=> array('value' => $this->getCommittees, 'edit' => 'none', 'id' => 'committees')
			);
		}
		/*
		* Lehrer / Referendare
		*/
		elseif($strType == 'Lehrer' || $strType == 'Referendar') {
			if($this->objUser->subjects) {
				$arrAll = WBGym::subjectList();
				$arrS = unserialize($this->objUser->subjects);
				
				//find all other subjects
				foreach($arrS as $sub) {
					$subject = WBGym::subject($sub);
					$strSubjects .= '<b>' . $subject['name'] . '</b> (' . $subject['abbreviation'] . ')<br />';
				}
				
				//find heading subjects
				foreach($arrAll as $sub) {
					if($sub['headTeacher'] == $this->objUser->id) {
						$strHeadSubjects .= '<b>' . $sub['name'] . '</b> (' . $sub['abbreviation'] . ')<br />';
					}
				}
			}
			$arrFields = array(
				'Unterichtende Fächer'	=> array('content' => $strSubjects, 'edit' => false),
				'Fachkonferenz-Leitung'	=> array('content' => $strHeadSubjects, 'edit' => false),
				'Klassenleitung'		=> array('content' => $strHeadClass, 'edit' => false),
			);
		}
		/*
		* Eltern
		*/
		elseif($strType == 'Eltern') {
			return true;
		}
		return $arrFields;
	}
	
	/*
	* Add the Edit Form fields to the profile table
	*
	* @param array $arrFields The current table data
	* @return array
	*/
	protected function addEditForm($arrFields) {
		/*
		* Schüler
		*/
		if($strType == 'Schüler') {
			return true;
		}
		/*
		* Lehrer / Referendare
		*/
		elseif($strType == 'Lehrer' || $strType == 'Referendar') {
			return true;
		}
		/*
		* Eltern
		*/
		elseif($strType == 'Eltern') {
			return true;
		}
		return $arrFields;
	}
	
	protected function saveProfile() {
		$arrNotSavedInputs = array('base64','REQUEST_TOKEN','FORM_SUBMIT');
		
		foreach($_POST as $i => $v) {
			$v = \Input::postHtml($i);
			if(strpos($i,'privacy-') === false && !in_array($i,$arrNotSavedInputs)) {
				$arrPost[$i] = html_entity_decode($v);
			}
			$arrPrivacy['age'] = ($_POST['privacy-age'] == 'on') ? 1 : 0;
			$arrPrivacy['grade'] = ($_POST['privacy-grade'] == 'on') ? 1 : 0;
		}
		if(isset($arrPrivacy)) $arrPost['privacy'] = serialize($arrPrivacy);
		
		foreach($arrPost as $i => $v) {
			$this->objUser->$i = $v;
			$this->objUser->save();
		}
	}
	
	protected function saveAvatar() {
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
?>