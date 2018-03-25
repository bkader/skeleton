<?php
/**
 * CodeIgniter Skeleton
 *
 * A ready-to-use CodeIgniter skeleton  with tons of new features
 * and a whole new concept of hooks (actions and filters) as well
 * as a ready-to-use and application-free theme and plugins system.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package 	CodeIgniter
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://github.com/bkader
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Module - Admin Language (Spanish)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

$lang['manage_languages'] = 'Administrar Idiomas';
$lang['manage_languages_tip'] = 'Habilitado, deshabilitar, instalación y configuración del sitio\'s idioma predeterminado. Habilitado idiomas están disponibles para los visitantes del sitio.';

$lang['folder']       = 'Carpeta';
$lang['abbreviation'] = 'Abreviatura';
$lang['is_default']   = 'El Valor Predeterminado';
$lang['enabled']      = 'Habilitado';

$lang['make_default'] = 'Por Defecto';

$lang['missing_language_folder'] = 'El idioma no se encuentra la carpeta.';

$lang['english_required'] = 'Necesaria e intocable.';

// ------------------------------------------------------------------------
// Messages.
// ------------------------------------------------------------------------

// Enable language.
$lang['language_enable_missing'] = 'El idioma que usted está tratando de permitir que no está disponible.';
$lang['language_enable_success'] = 'Idioma activado con éxito.';
$lang['language_enable_error']   = 'No puede activar el idioma.';
$lang['language_enable_already']   = 'Este lenguaje ya está habilitado.';

// Disable language.
$lang['language_disable_missing'] = 'El idioma que usted está tratando de desactivar no está disponible.';
$lang['language_disable_success'] = 'Idioma correctamente deshabilitar.';
$lang['language_disable_error']   = 'No se puede deshabilitar el idioma.';
$lang['language_disable_already'] = 'Este lenguaje ya está deshabilitada.';

// Set default language.
$lang['language_default_missing'] = 'El idioma que usted está tratando de hacer como predeterminada no está disponible.';
$lang['language_default_success'] = 'Idioma predeterminado cambiado correctamente.';
$lang['language_default_error']   = 'No se puede cambiar el idioma predeterminado.';
$lang['language_default_already'] = 'Este lenguaje es ya la de por defecto.';
