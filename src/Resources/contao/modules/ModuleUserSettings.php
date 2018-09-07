<?php

/**
 * WBGym
 * 
 * Copyright (C) 2015 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @version 	0.3.0
 * @author 	Johannes Cram <j-cram@gmx.de>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Namespace
 */
namespace WBGym;

class ModuleUserSettings extends \Module
{
protected $strTemplate = 'wb_usersettings';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### WBGym User-Einstellungen ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		 
		return parent::generate();
		
	}

protected function compile(){
	
	if(!FE_USER_LOGGED_IN){
		$objHandler = new $GLOBALS['TL_PTY']['error_403']();
		$objHandler->generate($objPage->id);
    }
	
	$this->Import('FrontendUser', 'User');
	$this->Import('Database');

	
	if(\Input::post('FORM_SUBMIT')) {
		
		/* == Execute Forms ========================================*/
		
		/*
		* ResetMail Form ===
		*/
		
		if(\Input::post('FORM_SUBMIT') == 'rm') {
			
		}
		
		/*
		* Password Change Form ===
		*/
		
		if(\Input::post('FORM_SUBMIT') == 'pw') {
			
		}
		
		/*
		* Mail Forwarding Form ===
		*/
		
		if(\Input::post('FORM_SUBMIT') == 'pw') {
			
		}
	}
	
		//Show Overview or Forms =======================================
		
		/*
		* Options Overview ===
		*/
		$arrAreas = array(
			array(
				'name'			=> 'resetMail',
				'param'			=> 'resetmail',
				'edit_href' 		=> $this->addToUrl('aktion=resetmail'),
				'title'				=> $GLOBALS['TL_LANG']['userSettings']['resetMail']['headline'],
				'hint' 				=> $GLOBALS['TL_LANG']['userSettings']['resetMail']['hint'],
				'content'		=> $this->User->resetMailAddress,
			),
			array(
				'name'			=> 'password',
				'param'			=> 'passwort',
				'edit_href' 		=> $this->addToUrl('aktion=passwort'),
				'title'				=> $GLOBALS['TL_LANG']['userSettings']['password']['headline'],
				'hint' 				=> $GLOBALS['TL_LANG']['userSettings']['password']['hint'],
			),
			array(
				'name'			=> 'forwardingAddress',
				'param'			=> 'weiterleitung',
				'edit_href' 		=> $this->addToUrl('aktion=weiterleitung'),
				'title'				=> $GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['headline'],
				'hint' 				=> $GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['hint'],
				'content'		=> /*getForwardingAddresses(),*/ ''
			)
		);
		
		if(\Input::get('aktion') == null) {
			$this->Template->isForm = false;
			$this->Template->h2 = $GLOBALS['TL_LANG']['userSettings']['overview']['headline'];
			$this->Template->hint = $GLOBALS['TL_LANG']['userSettings']['overview']['hint'];
			$this->Template->edit_title = $GLOBALS['TL_LANG']['userSettings']['overview']['edit_title'];
			$this->Template->areas = $arrAreas;
		}
		else
		{
			if(array_search(\Input::get('aktion'), array_column($arrAreas, 'param')) === false){
				$objHandler = new $GLOBALS['TL_PTY']['error_404']();
				$objHandler->generate($objPage->id);
			}
		}
		
		/*
		* Reset-Mail Form ===
		*/
		
		if(\Input::get('aktion') == 'resetmail') {
			$this->Template->isForm = true;
			$this->Template->h2 = $GLOBALS['TL_LANG']['userSettings']['resetMail']['headline'];
			$this->Template->formName = 'rm';
			$this->Template->hint = $GLOBALS['TL_LANG']['userSettings']['resetMail']['hint'];
			$this->Template->formElements = array(
				array(
					'type' 			=> 'email',
					'placeholder'	=> $GLOBALS['TL_LANG']['userSettings']['resetMail']['placeholder_email'],
					'value'			=> $this->User->resetMailAddress,
					'name'			=> 'resetMail'
				),
				array(
					'type'				=> 'checkbox',
					'label'				=> $GLOBALS['TL_LANG']['userSettings']['resetMail']['additionally_set_redirection'],
					'value'			=> '',
					'name'			=> 'additionally_set_redirection'
				)
			);
		}
		
		/*
		* Change E-Mail-Password Form
		*/
		
		if(\Input::get('aktion') == 'passwort') {
			$this->Template->isForm = true;
			$this->Template->h2 = $GLOBALS['TL_LANG']['userSettings']['password']['headline'];
			$this->Template->formName = 'pw';
			$this->Template->hint = $GLOBALS['TL_LANG']['userSettings']['password']['hint'];
			$this->Template->formElements = array(
				array(
					'type' 			=> 'password',
					'placeholder'	=> $GLOBALS['TL_LANG']['userSettings']['password']['placeholder_old'],
					'value'			=> '',
					'name'			=> 'oldpass'
				),
				array(
					'type' 			=> 'password',
					'placeholder'	=> $GLOBALS['TL_LANG']['userSettings']['password']['placeholder_p1'],
					'value'			=> '',
					'name'			=> 'newpass1'
				),
				array(
					'type' 			=> 'password',
					'placeholder'	=> $GLOBALS['TL_LANG']['userSettings']['password']['placeholder_p2'],
					'value'			=> '',
					'name'			=> 'newpass2'
				)
			);
		}
		
		/*
		* Change E-Mail Forwarding Address Form
		*/
		
		if(\Input::get('aktion') == 'weiterleitung') {
			$this->Template->isForm = true;
			$this->Template->h2 = $GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['headline'];
			$this->Template->formName = 'fa';
			$this->Template->hint = $GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['hint'];
			$this->Template->formElements = array(
				array(
					'type' 			=> 'textarea',
					'placeholder'	=> $GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['placeholder'],
					'value'			=> /*getForwardingAddresses(),*/ '',
					'name'			=> 'forwardingAddress'
				)
			);
		}
		
	
}
}
?>