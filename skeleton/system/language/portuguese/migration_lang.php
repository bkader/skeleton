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

$lang['migration_none_found']          = 'Não foram encontradas migrações.';
$lang['migration_not_found']           = 'Não foram encontradas migrações com a versão: %s.';
$lang['migration_sequence_gap']        = 'Existe uma falha na sequência de versões das migrações junto à versão: %s.';
$lang['migration_multiple_version']    = 'Existem várias migrações com o mesmo numero de versão: %s.';
$lang['migration_class_doesnt_exist']  = 'Não foi possível encontrar a classe de migração "%s".';
$lang['migration_missing_up_method']   = 'Falta o método "up" à classe de migração "%s"';
$lang['migration_missing_down_method'] = 'Falta o método "down" à classe de migração "%s"';
$lang['migration_invalid_filename']    = 'A migração "%s" tem um nome de ficheiro inválido.';
