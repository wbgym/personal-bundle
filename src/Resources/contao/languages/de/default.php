<?php

/**
 * WBGym
 * 
 * Copyright (C) 2016 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package   WBUser
 * @author     Johannes Cram <craj.me@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


//Settings Overview
 
$GLOBALS['TL_LANG']['userSettings']['overview']['headline'] = 'Benutzer-Einstellungen';
$GLOBALS['TL_LANG']['userSettings']['overview']['edit_title'] = 'Bearbeiten';
$GLOBALS['TL_LANG']['userSettings']['overview']['hint'] = '';

//ResetMail

$GLOBALS['TL_LANG']['userSettings']['resetMail']['headline'] = 'Alternative E-Mail-Adresse';
$GLOBALS['TL_LANG']['userSettings']['resetMail']['hint'] = 'Hier können Sie eine alternative E-Mail-Adresse (z.B. eine private Adresse) angeben, um ihr Passwort bei Verlust zurücksetzen zu können.';
$GLOBALS['TL_LANG']['userSettings']['resetMail']['placeholder_email']	= 'Alternative E-Mail-Adresse';
$GLOBALS['TL_LANG']['userSettings']['resetMail']['additionally_set_redirection']	= 'Alle WBGym-E-Mails an diese Adresse weiterleiten';


//Password

$GLOBALS['TL_LANG']['userSettings']['password']['headline'] = 'Passwort für E-Mail und Website';
$GLOBALS['TL_LANG']['userSettings']['password']['hint'] = 'Hier können Sie ihr Passwort für Ihren E-Mail-Account und die Website ändern. Beide Passwörter sind immer gleich, auch nach einer Änderung.';
$GLOBALS['TL_LANG']['userSettings']['password']['placeholder_old'] = 'Altes Passwort';
$GLOBALS['TL_LANG']['userSettings']['password']['placeholder_p1'] = 'Neues Passwort';
$GLOBALS['TL_LANG']['userSettings']['password']['placeholder_p2'] = 'Neues Passwort wiederholen';

//ForwardingAddress

$GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['headline'] = 'E-Mail-Weiterleitung';
$GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['hint'] = 'Hier können Sie verwalten, an welche E-Mail-Adressen die Mails an Ihre wbgym-Adresse weitergeleitet werden sollen.';
$GLOBALS['TL_LANG']['userSettings']['forwardingAddress']['placeholder'] = 'E-Mail Adressen mit Komma getrennt angeben';

/*
* ReplaceUmlauts
*/
$GLOBALS['TL_LANG']['replace_umlauts']['title'] = array('Umlaute reparieren','Hier können Sie die Fragezeichen in den Namen der Mitglieder durch die entsprechenden Umlaute ersetzen lassen.');
$GLOBALS['TL_LANG']['replace_umlauts']['preview'] = 'Vorschau generieren';
$GLOBALS['TL_LANG']['replace_umlauts']['execute'] = 'Neue Namen speichern';

?>