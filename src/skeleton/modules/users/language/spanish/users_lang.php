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
 * Users Module - Users Language (Spanish)
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

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'Signo En';
$lang['logout']          = 'Sesión';
$lang['register']        = 'Registro';
$lang['create_account']  = 'Crear Cuenta';
$lang['forgot_password'] = '¿Olvidó la contraseña?';
$lang['lost_password']   = 'Contraseña perdida';
$lang['send_link']       = 'Enviar vínculo';
$lang['resend_link']     = 'Enviar vínculo';
$lang['restore_account'] = 'Restauración de la cuenta';

$lang['profile']      = 'Perfil';
$lang['view_profile'] = 'Ver Perfil';
$lang['edit_profile'] = 'Editar Perfil';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'Nombre de usuario';
$lang['identity']          = 'Nombre de usuario o dirección de correo electrónico';

$lang['email_address']     = 'Dirección de correo electrónico';
$lang['new_email_address'] = 'Nueva dirección de correo electrónico';

$lang['password']          = 'Contraseña';
$lang['new_password']      = 'Nueva contraseña';
$lang['confirm_password']  = 'Confirmar contraseña';
$lang['current_password']  = 'Contraseña actual';

$lang['first_name']        = 'Primer nombre';
$lang['last_name']         = 'Apellido';
$lang['full_name']         = 'Nombre completo';

$lang['gender']            = 'Género';
$lang['male']              = 'Macho';
$lang['female']            = 'Hembra';

$lang['company']  = 'Empresa';
$lang['phone']    = 'Teléfono';
$lang['address']  = 'Dirección';
$lang['location'] = 'Ubicación';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title'] = 'Registro';
$lang['us_register_heading'] = 'Crear Cuenta';

$lang['us_register_success'] = 'Cuenta creada con éxito. Ahora puede ingresar.';
$lang['us_register_info']    = 'Cuenta creada con éxito. El enlace de activación ha sido enviado a usted.';
$lang['us_register_error']   = 'No se puede crear la cuenta.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'Este enlace de activación de cuenta no es válida.';
$lang['us_activate_error']       = 'No se puede activar la cuenta.';
$lang['us_activate_success']     = 'Cuenta activada con éxito. Ahora puede ingresar';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title'] = 'Enviar Enlace De Activación';
$lang['us_resend_heading'] = 'Enviar Vínculo';

$lang['us_resend_notice']  = 'Introduzca su nombre de usuario o dirección de correo electrónico y le enviaremos un enlace para activar su cuenta.';
$lang['us_resend_error']   = 'Incapaz de volver a enviar enlace de activación de cuenta.';
$lang['us_resend_enabled'] = 'Esta cuenta ya está activada.';
$lang['us_resend_success'] = 'Enlace de activación de cuenta correctamente resienten. Revise su bandeja de entrada o correo no deseado.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'Signo En';
$lang['us_login_heading'] = 'Inicio De Sesión De Miembro';
$lang['remember_me']      = 'Acuérdate de mí';

$lang['us_wrong_credentials'] = 'No válido nombre de usuario/dirección de correo electrónico y/o contraseña.';
$lang['us_account_disabled']  = 'Se cuenta aún no está activa. Utilice el enlace que fue enviado a usted o a %s para recibir una nueva.';
$lang['us_account_banned']    = 'Este usuario está baneado del sitio.';
$lang['us_account_deleted']   = 'Su cuenta ha sido eliminado, pero no se han quitado de la base de datos. %s si desea restaurar.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'Contraseña Perdida';
$lang['us_recover_heading'] = 'Contraseña Perdida';

$lang['us_recover_notice']  = 'Introduzca su nombre de usuario o dirección de correo electrónico y le enviaremos un enlace para restablecer tu contraseña.';
$lang['us_recover_success'] = 'Enlace de restablecimiento de contraseña se ha enviado correctamente.';
$lang['us_recover_error']   = 'No se pudo enviar el enlace de restablecimiento de contraseña.';


// ------------------------------------------------------------------------
// Reset password page.
// ------------------------------------------------------------------------
$lang['us_reset_title']   = 'Para Restablecer La Contraseña';
$lang['us_reset_heading'] = 'Para Restablecer La Contraseña';

$lang['us_reset_invalid_key'] = 'Este enlace de restablecimiento de contraseña no es válida.';
$lang['us_reset_error']       = 'Incapaz de restablecer la contraseña.';
$lang['us_reset_success']     = 'Contraseña de restablecimiento correcto.';

// ------------------------------------------------------------------------
// Restore account page.
// ------------------------------------------------------------------------
$lang['us_restore_title']   = 'Restauración De La Cuenta';
$lang['us_restore_heading'] = 'Restauración De La Cuenta';

$lang['us_restore_notice']  = 'Introduzca su nombre de usuario/dirección de correo electrónico y la contraseña para restaurar su cuenta.';
$lang['us_restore_deleted'] = 'Sólo se eliminan las cuentas pueden ser restaurados.';
$lang['us_restore_error']   = 'Incapaz de restaurar la cuenta.';
$lang['us_restore_success'] = 'Cuenta restaurado correctamente. Bienvenido de nuevo!';
