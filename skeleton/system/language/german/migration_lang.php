<?php
/**
 * System messages translations for CodeIgniter
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['migration_none_found']          = 'Es wurde keine Migration gefunden.';
$lang['migration_not_found']           = 'Die Migration mit der Versionsnummer %s wurde nicht gefunden.';
$lang['migration_sequence_gap']        = 'Es besteht eine Lücke in der Migrationsfolge nahe der Versionsnummer: %s.';
$lang['migration_multiple_version']    = 'Es existieren mehrere Migrationen mit der gleichen Versionsnummer: %s.';
$lang['migration_class_doesnt_exist']  = 'Die Migrationsklasse "%s" konnte nicht gefunden werden.';
$lang['migration_missing_up_method']   = 'Der Migrationsklasse "%s" fehlt eine "up" Methode.';
$lang['migration_missing_down_method'] = 'Der Migrationsklasse "%s" fehlt eine "down" Methode.';
$lang['migration_invalid_filename']    = 'Migration "%s" hat einen ungültigen Dateinamen.';
