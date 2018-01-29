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
 * Settings Module - Admin Language (Spanish)
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

$lang['settings'] = 'Configuración';

$lang['set_update_error']   = 'No se puede actualizar la configuración.';
$lang['set_update_success'] = 'Configuración actualizado correctamente.';

// ------------------------------------------------------------------------
// General Settings.
// ------------------------------------------------------------------------
$lang['general'] = 'General';
$lang['site_settings'] = 'Configuración Del Sitio';

// Site name.
$lang['set_site_name']     = 'Nombre Del Sitio';
$lang['set_site_name_tip'] = 'Introduzca el nombre de su sitio web.';

// Site description.
$lang['set_site_description']     = 'La Descripción Del Sitio';
$lang['set_site_description_tip'] = 'Ingrese una breve descripción de su sitio web.';

// Site keywords.
$lang['set_site_keywords']     = 'Keywords De La Página';
$lang['set_site_keywords_tip'] = 'Introduzca su separados por comas keywords de la página.';

// Site author.
$lang['set_site_author']     = 'Autor Del Sitio';
$lang['set_site_author_tip'] = 'Entrar en la web de autor si desea agregar el autor de la etiqueta meta.';

// Per page.
$lang['set_per_page']     = 'Por Página';
$lang['set_per_page_tip'] = 'Cuántos elementos se muestran en las páginas que el uso de la paginación.';

// Google analytics.
$lang['set_google_analytics_id'] = 'Google Anaytilcs ID';
$lang['set_google_analytics_id_tip'] = 'Ingrese a su cuenta de Google Anaytilcs ID';

// Google site verification.
$lang['set_google_site_verification'] = 'La Verificación Del Sitio De Google';
$lang['set_google_site_verification_tip'] = 'Entrar en tu sitio de Google el código de verificación.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'Configuración De Los Usuarios';

// Allow registration.
$lang['set_allow_registration']     = 'Permitir El Registro';
$lang['set_allow_registration_tip'] = 'Si se permite a los usuarios crear una cuenta en su sitio.';

// Email activation.
$lang['set_email_activation']     = 'Correo Electrónico De Activación';
$lang['set_email_activation_tip'] = 'Si se obliga a los usuarios a verificar sus direcciones de correo electrónico antes de poder iniciar la sesión.';

// Manual activation.
$lang['set_manual_activation']     = 'Activación Manual';
$lang['set_manual_activation_tip'] = 'Si a comprobar manualmente las cuentas de usuarios.';

// Login type.
$lang['set_login_type']     = 'Tipo De Inicio De Sesión';
$lang['set_login_type_tip'] = 'Los usuarios pueden iniciar sesión en el uso de nombres de usuario, direcciones de correo electrónico o ambos.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'Permiten Múltiples Sesiones';
$lang['set_allow_multi_session_tip'] = 'Si se permite que varios usuarios para iniciar sesión en la misma cuenta al mismo tiempo.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'Gravatar';
$lang['set_use_gravatar_tip'] = 'Gravatar o permitir a los usuarios subir sus avatares.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'Configuración De Correo Electrónico';

// Admin email.
$lang['set_admin_email']     = 'Admin Email';
$lang['set_admin_email_tip'] = 'La dirección de correo electrónico para que el sitio se envían notificaciones.';

// Server email.
$lang['set_server_email']     = 'Servidor De Correo Electrónico';
$lang['set_server_email_tip'] = 'La dirección de correo electrónico utilizada para enviar correos electrónicos a los usuarios. Establecer como "De". Usted puede utilizar "noreply@..." o una dirección de correo electrónico existente.';

// Mail protocol.
$lang['set_mail_protocol'] = 'Protocolo De Correo';
$lang['set_mail_protocol_tip'] = 'Elija el protocolo de correo que desea enviar mensajes de correo electrónico con.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'Sendmail Camino';
$lang['set_sendmail_path_tip'] = 'Introduzca el sendmail camino. Default: /usr/sbin/sendmail. Sólo se requiere si el uso de Sendmail protocolo.';

// SMTP host.
$lang['set_smtp_host'] = 'Host SMTP';
$lang['set_smtp_host_tip'] = 'Introduzca el nombre de host SMTP (he.e: smtp.gmail.com). Sólo se requiere si el uso del protocolo SMTP.';

// SMTP port.
$lang['set_smtp_port'] = 'Puerto SMTP';
$lang['set_smtp_port_tip'] = 'Introduzca el número de puerto SMTP proporcionada por su anfitrión. Sólo se requiere si el uso del protocolo SMTP.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'SMTP de Cifrado';
$lang['set_smtp_crypto_tip'] = 'Elija el SMTP de cifrado.';

// SMTP user.
$lang['set_smtp_user'] = 'El nombre de Usuario SMTP';
$lang['set_smtp_user_tip'] = 'Introduzca el nombre de usuario de su cuenta SMTP.';

// SMTP pass.
$lang['set_smtp_pass'] = 'Contraseña SMTP';
$lang['set_smtp_pass_tip'] = 'Introduzca la contraseña de su cuenta SMTP.';

// ------------------------------------------------------------------------
// Upload settings
// ------------------------------------------------------------------------
$lang['upload_settings'] = 'Configuración de carga';

// Upload path.
$lang['set_upload_path'] = 'Ruta de carga';
$lang['set_upload_path_tip'] = 'La ruta de acceso donde diferentes permitido que los archivos son enviados. Valor predeterminado: content/uploads/';

// Allowed file types.
$lang['set_allowed_types'] = 'Permite Archivos';
$lang['set_allowed_types_tip'] = 'Lista de archivos que pueden ser cargados. Utilizar "&#124;" para separar entre los tipos.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'Captcha configuración';

// Use captcha.
$lang['set_use_captcha'] = 'El uso de captcha';
$lang['set_use_captcha_tip'] = 'Si se habilita la captcha en algunos formularios del sitio.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'Utilizar reCAPTCHA';
$lang['set_use_recaptcha_tip'] = 'El uso de Google reCAPTCHA si está habilitado, de lo contrario usar CodeIgniter incorporado en el código de la imagen si el Uso de captcha está establecida en Sí.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'reCAPTCHA Sitio Clave';
$lang['set_recaptcha_site_key_tip'] = 'Introduzca el reCAPTCHA sitio de las claves proporcionadas por Google.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'reCAPTCHA Clave Privada';
$lang['set_recaptcha_private_key_tip'] = 'Introduzca el reCAPTCHA clave privada proporcionada por Google.';
