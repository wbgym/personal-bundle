<?php

/**
 * WBGym
 * 
 * Copyright (C) 2016 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package   WGBym
 * @author     Johannes Cram <craj.me@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace WBGym;

class WBUser extends \System {
	
	/*
	* Get the path of the user avatar, if available
	*
	* @param int $uid If 0, use current user
	* @return mixed 
	*/
	public function getUserAvatar($uid = 0) {
		$objUser = \FrontendUser::getInstance();
		if($uid != 0) {
			$blnFound = $objUser->findBy('id',$uid);
			if($blnFound == false) return false;
		}
		$objAvatar = new \File('files/avatars/' . $objUser->username . '.png');
		if($objAvatar->exists()) {
			$objHandle = $objAvatar->handle;
			$content = fread($objHandle,filesize($objAvatar->value));
			return 'data:image/png;base64,' . base64_encode($content);
		}
		return false;
	}
	
	/*
	* Get User Type (student,teacher,parent)
	*
	* @param int $uid
	* @return str 'Schüler', etc
	*/
	public function getUserType($uid = 0) {
		if($uid == 0) {
			$objUser = \FrontendUser::getInstance();
		}
		else {
			if(!$objUser = \MemberModel::findById($uid)) return false;
		}
		$arrGroups = unserialize($objUser->groups);

		if($objUser->referendar == 1) return 'Referendar';
		elseif(in_array(WBGym::getGroupIdFor('teachers'),$arrGroups)) return 'Lehrer';
		elseif(in_array(WBGym::getGroupIdFor('students'),$arrGroups)) return 'Schüler';
		elseif(in_array(WBGym::getGroupIdFor('parents'),$arrGroups)) return 'Eltern';
		else return false;
	}
	
	/*
	* Get Profile Info
	*
	* @param str $strField
	* @param int $intId User Id, current user if null
	* @return mixed
	*/
	public function getProfile($strField, $intId = 0) {
		if($uid == 0) {
			$objUser = \FrontendUser::getInstance();
		}
		else {
			if(!$objUser = \MemberModel::findById($uid)) return false;
		}
		return $objUser->$strField;
	}
	
	/*
	* Find out if the user is a moderator
	*
	* @param int $uid
	* @return bln
	*/
	public function isModerator($uid = 0) {
		if($uid == 0) {
			$arrGroups = \FrontendUser::getInstance()->groups;
		}
		else {
			if(!$objUser = \MemberModel::findById($uid)) return false;
			//if accessed via MemberModel, the groups value is still serialized
			$arrGroups = unserialize($objUser->groups);
		}
		if(in_array(WBGym::getGroupIdFor('moderators'),$arrGroups)) return true;
		return false;
	}

	/**
	 * CONTAO HOOK
	 * Modify the wbgym parameters passed to the mod_login template.
	 * @param $objTemplate
	 * @return void
	 */
	public function modifyLoginTemplate($objTemplate) {
		if($objTemplate->getName() == 'mod_login' && $objTemplate->logout) {
			
			$objUser = \FrontendUser::getInstance();

			$objTemplate->firstname = $objUser->firstname;
			$objTemplate->lastname = $objUser->lastname;
			
			//Get URL of Profile Page
			if($objProfilePage = \PageModel::findById($objTemplate->wb_profilePage)) {
				$objTemplate->profileHref = $objProfilePage->getFrontendUrl('/user/'.$objUser->id);
			}
			//Get URL of Settings Page
			if($objSettingsPage = \PageModel::findById($objTemplate->wb_settingsPage)) {
				$objTemplate->settingsHref = $objSettingsPage->getFrontendUrl();
			}
			//Get URL of VPlan Page
			if($objVplanPage = \PageModel::findById($objTemplate->wb_vplanPage)) {
				$objTemplate->vplanHref = $objVplanPage->getFrontendUrl();
			}
			//Get Avatar
			$objTemplate->avatar = static::getUserAvatar();
			
			//Generate Webmail URL
			$objTemplate->webmailHref = str_replace("{{email}}",$objUser->email,$objTemplate->wb_emailLink);
		}
	}
}