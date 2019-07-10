<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Smart Invoice System
 *
 * A simple and powerful web app based on PHP CodeIgniter framework manage invoices.
 *
 * @package Smart Invoice System
 * @author  Bessem Zitouni (bessemzitouni@gmail.com)
 * @copyright   Copyright (c) 2017
 * @since   Version 1.6.0
 * @filesource
 */
$lang['IS_RTL']                           = false;
$lang['lang']                             = "es";
$lang['site_title_head']                  = 'Sistema de factura inteligente';
$lang['site_title']                       = 'Sistema de <span class="bold">factura</span> inteligente';
$lang['is_demo']                          = "Esta es una versión demo, no se pueden ejecutar todas las opciones";
$lang['remove_install_file']              = "Para la seguridad del programa, elimine el archivo de instalación \ &quot;install.php \&quot; de la carpeta principal";

$lang['invoice']                          = 'Factura';
$lang['invoices']                         = 'Facturas';
$lang['invoices_subheading']              = 'Utilice la tabla siguiente para navegar o filtrar los resultados.';
$lang['reference']                        = 'Referencia';
$lang['date']                             = 'Fecha';
$lang['date_due']                         = 'Fecha de vencimiento';
$lang['valid_till']                       = 'Válida hasta';
$lang['status']                           = 'Estado';
$lang['invoice_note']                     = "Nota de factura";
$lang['invoice_terms']                    = "Términos de factura";
$lang['total']                            = 'Total';
$lang['actions']                          = 'Comportamiento';
$lang['details']                          = 'Detalles';
$lang['delete']                           = 'Borrar';
$lang['edit']                             = 'Editar';
$lang['duplicate']                        = 'Duplicar';
$lang['refresh']                          = 'Refrescar';
$lang['filter']                           = 'Filtrar';
$lang['yes']                              = 'Sí';
$lang['no']                               = 'No';
$lang['ok']                               = 'De acuerdo';
$lang['cancel']                           = "Cancelar";
$lang['clear']                            = "Claro";
$lang['save']                             = "Salvar";
$lang['next']                             = "Siguiente";
$lang['previous']                         = "Anterior";
$lang['confirmation']                     = 'Confirmación';
$lang['alert_confirmation']               = 'Desea confirmar esta acción. Pulse YES para continuar o NO para volver';
$lang['name']                             = 'Nombre';
$lang['description']                      = 'Descripción';
$lang['show_description']                 = 'Mostrar descripcion';

$lang["system"]                           = 'Sistema';
$lang['create_invoice']                   = 'Crear factura';
$lang['edit_invoice']                     = "Editar factura";
$lang['create_invoice_subheading']        = "Para crear una nueva factura, ingrese la siguiente información.";
$lang['edit_invoice_subheading']          = "Para editar esta Factura, ingrese la siguiente información.";
$lang['preview_invoice_error']            = "Para visualizar esta factura, ingrese todas las informaciones requeridas.";
$lang['invoice_title']                    = "Título de la factura";
$lang['invoice_description']              = "Escriba el resumen de la factura ...";
$lang['basic_informations']               = "Informaciones Básicas";
$lang['contact_informations']             = "Información de contacto";
$lang['account_informations']             = "Información de la cuenta";
$lang['additional_informations']          = "Información adicional";
$lang['attn']                             = "Attn";
$lang['company']                          = "Empresa";
$lang['company_name']                     = "Nombre de la compañía";
$lang['fullname']                         = "Nombre completo";
$lang['contact_name']                     = "Nombre de contacto";
$lang['phone']                            = "Teléfono";
$lang['email']                            = "Email";
$lang['address']                          = "Dirección";
$lang['percent']                          = "Porcentaje (%)";
$lang['flat']                             = "Piso ($)";
$lang['off']                              = "Apagado";
$lang['invoice_setting']                  = "Configuración de factura";
$lang['currency']                         = "Moneda";
$lang['tax_type']                         = "Tipo de impuesto";
$lang['discount_type']                    = "Tipo de descuento";
$lang['tax']                              = "Impuesto";
$lang['taxes']                            = "Impuestos";
$lang['discount']                         = "Descuento";
$lang['discounts']                        = "Descuentos";
$lang['total_due']                        = "Total debido";
$lang['issued_on']                        = "Emitido el";
$lang['issued_date']                      = "Fecha de asunto";

$lang['all_invoices']                     = "Todas las facturas";
$lang['unpaid']                           = "No pagado";
$lang['paid']                             = "Pagado";
$lang['partial']                          = "Parcial";
$lang['due']                              = "Debido";
$lang['overdue']                          = "Atrasado";
$lang['canceled']                         = "Cancelado";
$lang['draft']                            = "Borrador";

$lang['due_receipt']                      = "-";
$lang['after_7_days']                     = "Después de 7 días";
$lang['after_15_days']                    = "Después de 15 días";
$lang['after_30_days']                    = "Después de 30 días";
$lang['after_45_days']                    = "Después de 45 días";
$lang['after_60_days']                    = "Después de 60 días";
$lang['custom']                           = "Fecha personalizada";

$lang['more']                             = "Más ...";
$lang['add']                              = "Añadir";
$lang['quantity']                         = "Cantidad";
$lang['unit_price']                       = "Precio unitario";
$lang['add_row']                          = "Añadir fila";
$lang['subtotal']                         = "Total parcial";
$lang['global_tax']                       = "Impuesto global";
$lang['global_discount']                  = "Descuento global";
$lang['preview']                          = "Avance";
$lang['create']                           = "Crear";
$lang['open']                             = "Abierto";
$lang['invoice_no']                       = "Factura N°";
$lang['invoice_items']                    = "artículos de factura";
$lang['n°']                               = "N°";
$lang['code']                             = "Código";
$lang['print']                            = "Impresión";
$lang['close']                            = "Cerca";
$lang['title']                            = "Título";
$lang['system_setting']                   = "Configuración del sistema";
$lang['system_setting_subheading']        = "Para actualizar la configuración del sistema, ingrese la información a continuación.";
$lang['settings_general']                 = "Configuración General";
$lang['settings_company']                 = "Configuración de la empresa";
$lang['settings_invoice']                 = "Configuración de la factura";
$lang['configuration_general']            = "General";
$lang['update_settings']                  = "Ajustes de actualización";
$lang['language']                         = "Idioma";
$lang['select']                           = "Seleccionar";
$lang['selected']                         = "Seleccionado";
$lang['date_format']                      = "Formato de fecha";
$lang['currency_format']                  = "Formato de moneda";
$lang['currency_format']                  = "Formato de moneda";
$lang['default_currency']                 = "Moneda predeterminada";
$lang['currency_place']                   = "Moneda simbolo lugar";
$lang['prefix_invoice']                   = "Prefijo de factura";
$lang['estimate_prefix']                  = "Prefijo de estimación";
$lang['receipt_prefix']                   = "Prefijo de pago";
$lang['contract_prefix']                  = "Prefijo del contrato";
$lang['expense_prefix']                   = "Prefijo de gastos";
$lang['invoice_next']                     = "Próxima factura";
$lang['estimate_next']                    = "Próxima estimación";
$lang['receipt_next']                     = "Siguiente recibo";
$lang['contract_next']                    = "Siguiente contrato";
$lang['expense_next']                     = "Siguiente gasto";
$lang['biller_type']                      = "Tipo de Biller";
$lang['item_tax']                         = "Impuesto de artículo";
$lang['item_discount']                    = "Descuento de artículo";
$lang['is_required']                      = "es requerido";
$lang['email_address']                    = "Dirección de correo electrónico";
$lang['city']                             = "Ciudad";
$lang['state']                            = "Estado";
$lang['postal_code']                      = "Código postal";
$lang['country']                          = "País";
$lang['website']                          = "URL del sitio web";
$lang['configuration_company']            = "Empresa";
$lang['update']                           = "Actualizar";
$lang['logo']                             = "Logo";
$lang['perview']                          = "Avance";
$lang['configuration_invoice_template']   = "Plantilla de factura";
$lang['update_template']                  = "Plantilla de actualización";
$lang['settings']                         = "Ajustes";
$lang['style']                            = "Estilo";
$lang['header']                           = "Encabezamiento";
$lang['footer']                           = "Pie de página";
$lang['signature']                        = "Firma";
$lang['template_configuration']           = "Configuración de la plantilla";
$lang['default_layout']                   = "Diseño predeterminado";
$lang['default_size']                     = "Tamaño predeterminado";
$lang['auto_print']                       = "Impresión automática";
$lang['template_style_configuration']     = "Estilo de plantilla";
$lang['font']                             = "Fuente";
$lang['table_bordered']                   = "Tabla confinada";
$lang['table_striped']                    = "Mesa rayada";
$lang['primary_color']                    = "Color primario";
$lang['second_color']                     = "Color secundario";
$lang['template_header_configuration']    = "Cabecera de plantilla";
$lang['appearance']                       = "Apariencia";
$lang['show_header']                      = "Mostrar ocultar";
$lang['header_bg_color']                  = "Color de fondo del encabezado";
$lang['header_txt_color']                 = "Color del texto del encabezado";
$lang['template']                         = "Modelo";
$lang['header_text']                      = "Texto de cabecera";
$lang['template_footer_configuration']    = "Pie de página de la plantilla";
$lang['show_footer']                      = "Mostrar ocultar";
$lang['footer_bg_color']                  = "Color de fondo del pie de página";
$lang['footer_txt_color']                 = "Color de texto de pie de página";
$lang['footer_text']                      = "Texto de pie de página";
$lang['template_signature_configuration'] = "Firma de plantilla";
$lang['signature_txt']                    = "Texto de firma";
$lang['order_by']                         = "Ordenar por";
$lang['title_invoice']                    = "Título factura";
$lang['no_zero_required']                 = "Campo% s es necesario";
$lang['users']                            = 'Usuarios';
$lang['dashboard']                        = 'Tablero';
$lang['settings_general_updated']         = "La configuración general se actualiza correctamente";
$lang['settings_company_updated']         = "La configuración de la empresa se actualiza correctamente";
$lang['invoice_template_updated']         = "La configuración de la plantilla de factura se actualiza correctamente";
$lang['invoice_add_success']              = "Factura creada correctamente";
$lang['invoice_edit_success']             = "Factura actualizada correctamente";
$lang['invoice_deleted']                  = "Factura eliminada correctamente";
$lang['cant_delete_invoice']               = "No puede eliminar esta factura!, Causa: <br><ul><li> Esta factura está relacionada con otros elementos </li></ul> Debe eliminar todos los elementos e intentarlo de nuevo.";
$lang['invoice_duplicate_success']        = "Factura duplicada con éxito";
$lang['access_denied']                    = "¡Acceso denegado!";
$lang['language_is_changed']              = "Se cambia el idioma correctamente";
$lang['change_password']                  = "Cambia la contraseña";
$lang['logout']                           = "Cerrar sesión";
$lang['here']                             = "aquí";

$lang['paid_invoices']                    = "Factura (s) pagada (s)";
$lang['unpaid_invoices']                  = "Factura (s) no pagada (s)";
$lang['overdue_invoices']                 = "Facturas vencidas)";
$lang['number_of_invoices']               = '<div class="font-weight-bold">%s</div><div class="text-muted"> <small>facturas</small> </div>';
$lang['last_invoices']                    = "Últimas facturas";
$lang['last_invoices_subheading']         = "Mostrar lista de las últimas 5 facturas creadas";
$lang['overview_chart']                   = "Tabla de resumen";
$lang['overview_chart_subheading']        = "Gráfico de sectores que cuenta las facturas por estado";
$lang['invoices_per_date']                = "Facturas por fecha";
$lang['invoices_per_date_subheading']     = "Gráfico de líneas que muestra el total de facturas por fecha";

$lang['settings_template']                = "Modelo";
$lang['defaults']                         = "Predeterminados";
$lang['default_status']                   = "Estado predeterminado";
$lang['manage_configurations']            = "Creación / actualización de configuraciones";
$lang['printing_configurations']          = "Configuraciones de impresión";
$lang['show_invoice_status']              = "Mostrar estado de la factura";
$lang['show_total_due']                   = "Mostrar el total debido";
$lang['show_payments_page']               = "Mostrar página de pagos";
$lang['note_terms_on_page']               = "Términos en la página";
$lang['enable_terms']                     = "Habilitar los términos y condiciones";
$lang['payments_total']                   = "Pagos totales";
$lang['invoice_total']                    = "Total de la factura";
$lang['description_inline']               = "Descripción del producto";
$lang['description_inline_tip']           = "Mostrar la descripción del producto en la misma línea con nombre";

// Errors
$lang['error_csrf']                       = 'Este mensaje no pasó nuestros cheques de seguridad.';
// Users Roles
$lang['role_superadmin']                  = 'Super Admin';
$lang['role_admin']                       = 'Administrador';
$lang['role_members']                     = 'Usuario (Miembro)';
$lang['role_customer']                    = 'Cliente';
$lang['role_supplier']                    = 'Proveedor';

// Login
$lang['login_heading']                    = 'Iniciar sesión';
$lang['login_subheading']                 = 'Inicie sesión con su correo electrónico / nombre de usuario y contraseña a continuación.';
$lang['login_identity_label']             = 'Correo electrónico / Nombre de usuario';
$lang['login_password_label']             = 'Contraseña';
$lang['login_remember_label']             = 'Recuérdame';
$lang['login_submit_btn']                 = 'Iniciar sesión';
$lang['login_forgot_password']            = '¿Olvidaste tu contraseña?';

// Index
$lang['index_heading']                    = 'Usuarios';
$lang['index_subheading']                 = 'A continuación se muestra una lista de los usuarios.';
$lang['index_username_th']                = 'Nombre de usuario';
$lang['index_name_th']                    = 'Nombre';
$lang['index_fname_th']                   = 'Nombre de pila';
$lang['index_lname_th']                   = 'Apellido';
$lang['index_email_th']                   = 'Email';
$lang['index_groups_th']                  = 'Grupos';
$lang['index_status_th']                  = 'Estado';
$lang['index_action_th']                  = 'Acción';
$lang['index_active_link']                = 'Activar';
$lang['index_inactive_link']              = 'Inactivar';
$lang['index_create_user_link']           = 'Crear un nuevo usuario';
$lang['index_active_status']              = 'Activo';
$lang['index_inactive_status']            = 'Inactivo';

// Deactivate User
$lang['deactivate_heading']                  = 'Desactivar usuario';
$lang['deactivate_subheading']               = '¿Está seguro de que desea desactivar el usuario \ &#39;% s \&#39;';
$lang['deactivate_confirm_y_label']          = 'Sí';
$lang['deactivate_confirm_n_label']          = 'No';
$lang['deactivate_submit_btn']               = 'Enviar';
$lang['deactivate_validation_confirm_label'] = 'confirmación';
$lang['deactivate_validation_user_id_label'] = 'identidad de usuario';

// Create User
$lang['create_user_heading']                           = 'Crear usuario';
$lang['create_user_subheading']                        = 'Por favor ingrese la información del usuario a continuación.';
$lang['create_user_fname_label']                       = 'Nombre de pila';
$lang['create_user_lname_label']                       = 'Apellido';
$lang['create_user_company_label']                     = 'nombre de empresa';
$lang['create_user_identity_label']                    = 'Identidad';
$lang['create_user_email_label']                       = 'Email';
$lang['create_user_phone_label']                       = 'Teléfono';
$lang['create_user_password_label']                    = 'Contraseña';
$lang['create_user_password_confirm_label']            = 'Confirmar contraseña';
$lang['create_user_submit_btn']                        = 'Crear usuario';
$lang['create_user_validation_fname_label']            = 'Nombre de pila';
$lang['create_user_validation_lname_label']            = 'Apellido';
$lang['create_user_validation_identity_label']         = 'Identidad';
$lang['create_user_validation_email_label']            = 'Dirección de correo electrónico';
$lang['create_user_validation_phone_label']            = 'Teléfono';
$lang['create_user_validation_company_label']          = 'nombre de empresa';
$lang['create_user_validation_password_label']         = 'Contraseña';
$lang['create_user_validation_password_confirm_label'] = 'Confirmación de contraseña';

// Edit User
$lang['edit_user_heading']                           = 'editar usuario';
$lang['edit_user_subheading']                        = 'Por favor ingrese la información del usuario a continuación.';
$lang['edit_user_fname_label']                       = 'Nombre de pila';
$lang['edit_user_lname_label']                       = 'Apellido';
$lang['edit_user_company_label']                     = 'nombre de empresa';
$lang['edit_user_email_label']                       = 'Email';
$lang['edit_user_phone_label']                       = 'Teléfono';
$lang['edit_user_password_label']                    = 'Contraseña';
$lang['edit_user_password_confirm_label']            = 'Confirmar contraseña';
$lang['edit_user_password_help']                     = 'Si cambia la contraseña';
$lang['edit_user_groups_heading']                    = 'Miembro de grupos';
$lang['edit_user_submit_btn']                        = 'Guardar usuario';
$lang['edit_user_validation_fname_label']            = 'Nombre de pila';
$lang['edit_user_validation_lname_label']            = 'Apellido';
$lang['edit_user_validation_email_label']            = 'Dirección de correo electrónico';
$lang['edit_user_validation_phone_label']            = 'Teléfono';
$lang['edit_user_validation_company_label']          = 'nombre de empresa';
$lang['edit_user_validation_groups_label']           = 'Grupos';
$lang['edit_user_validation_password_label']         = 'Contraseña';
$lang['edit_user_validation_password_confirm_label'] = 'Confirmación de contraseña';

// Change Password
$lang['change_password_heading']                               = 'Cambia la contraseña';
$lang['change_password_old_password_label']                    = 'Contraseña anterior';
$lang['change_password_new_password_label']                    = 'Nueva contraseña (al menos% s caracteres)';
$lang['change_password_new_password_confirm_label']            = 'Confirmar nueva contraseña';
$lang['change_password_submit_btn']                            = 'Cambio';
$lang['change_password_validation_old_password_label']         = 'Contraseña anterior';
$lang['change_password_validation_new_password_label']         = 'nueva contraseña';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirmar nueva contraseña';

// Forgot Password
$lang['forgot_password_heading']                 = 'Se te olvidó tu contraseña';
$lang['forgot_password_subheading']              = 'Ingrese su% s para que podamos enviarle un correo electrónico para restablecer su contraseña.';
$lang['forgot_password_identity_not_found']      = 'Identidad no encontrada.';
$lang['forgot_password_email_label']             = '% S:';
$lang['forgot_password_submit_btn']              = 'Enviar';
$lang['forgot_password_validation_email_label']  = 'Dirección de correo electrónico';
$lang['forgot_password_identity_label']          = 'Nombre de usuario';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'No hay registro de esa dirección de correo electrónico.';

// Reset Password
$lang['reset_password_heading']                               = 'Cambia la contraseña';
$lang['reset_password_new_password_label']                    = 'Nueva contraseña (al menos% s caracteres):';
$lang['reset_password_new_password_confirm_label']            = 'Confirmar nueva contraseña:';
$lang['reset_password_submit_btn']                            = 'Cambio';
$lang['reset_password_validation_new_password_label']         = 'nueva contraseña';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirmar nueva contraseña';

// Account Creation
$lang['account_creation_successful']            = 'Cuenta creada con éxito';
$lang['account_creation_unsuccessful']          = 'No se puede crear una cuenta';
$lang['account_creation_duplicate_email']       = 'Correo electrónico ya utilizado o no válido';
$lang['account_creation_duplicate_identity']    = 'Identidad ya utilizada o no válida';
$lang['account_creation_missing_default_group'] = 'El grupo predeterminado no está configurado';
$lang['account_creation_invalid_default_group'] = 'Conjunto de nombres de grupo predeterminado no válido';


// Password
$lang['password_change_successful']          = 'Contraseña cambiada correctamente';
$lang['password_change_unsuccessful']        = 'No se puede cambiar la contraseña';
$lang['forgot_password_successful']          = 'Correo electrónico de restablecimiento de contraseña enviado';
$lang['forgot_password_unsuccessful']        = 'No se puede restablecer la contraseña';

// Activation
$lang['activate_successful']                 = 'Cuenta activada';
$lang['activate_unsuccessful']               = 'No se puede activar la cuenta';
$lang['deactivate_successful']               = 'Cuenta desactivada';
$lang['deactivate_unsuccessful']             = 'No se puede desactivar la cuenta';
$lang['activation_email_successful']         = 'Correo electrónico de activación enviado. Comprueba tu bandeja de entrada o spam';
$lang['activation_email_unsuccessful']       = 'No se puede enviar correo electrónico de activación';

// Login / Logout
$lang['login_successful']                    = 'Iniciar sesión con éxito';
$lang['login_unsuccessful']                  = 'Inicio de sesión incorrecto';
$lang['login_unsuccessful_not_active']       = 'La cuenta está inactiva';
$lang['login_timeout']                       = 'Bloqueado temporalmente. Vuelva a intentarlo más tarde.';
$lang['logout_successful']                   = 'Salido con éxito';

// Account Changes
$lang['update_successful']                   = 'La información de la cuenta se ha actualizado correctamente';
$lang['update_unsuccessful']                 = 'No se puede actualizar la información de la cuenta';
$lang['delete_successful']                   = 'Usuario eliminado';
$lang['delete_unsuccessful']                 = 'No se puede eliminar usuario';

// Groups
$lang['group_creation_successful']           = 'Grupo creado con éxito';
$lang['group_already_exists']                = 'Nombre del grupo ya tomado';
$lang['group_update_successful']             = 'Detalles del grupo actualizados';
$lang['group_delete_successful']             = 'Grupo eliminado';
$lang['group_delete_unsuccessful']           = 'No se puede eliminar el grupo';
$lang['group_delete_notallowed']             = 'No se puede eliminar el grupo de administradores';
$lang['group_name_required']                 = 'El nombre del grupo es un campo obligatorio.';
$lang['group_name_admin_not_alter']          = 'No se puede cambiar el nombre del grupo de administradores';

// Password Strength
$lang['pass_strength_general']               = "La contraseña debe tener:";
$lang['pass_strength_minlength']             = "At leaset {{minlength}} characters";
$lang['pass_strength_number']                = "Al menos un número";
$lang['pass_strength_capital']               = "Al menos una letra mayuscula";
$lang['pass_strength_special']               = "Al menos un carácter especial";

// Emails
$lang['email_caution']                       = '<b>Atención</b> El enlace sólo se puede utilizar una vez. Si intenta redirigir una segunda vez, aparecerá un error. Si tiene alguna pregunta, envíe un correo electrónico a nuestro';
$lang['email_automatic']                     = 'Nota: esta carta se generó y se envió automáticamente y no requiere ninguna respuesta.';
$lang['email_copyright']                     = 'Copyright ©% s% s, Todos los derechos reservados.';

// Activation Email
$lang['email_activation_subject']            = 'activación de cuenta';
$lang['email_activate_heading']              = 'Enhorabuena !';
$lang['email_activate_subheading']           = 'Hola <b>% s</b> , has registrado correctamente en el <i>% s</i> . <br> Para activar su cuenta, confirme su registro.';
$lang['email_activate_link']                 = 'Confirmar registro';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Verificación de la contraseña olvidada';
$lang['email_forgot_password_heading']       = 'Su,';
$lang['email_forgot_password_subheading']    = 'Hemos recibido una solicitud para restablecer su contraseña. <br> Su nombre de usuario es <b>% s</b> .';
$lang['email_forgot_password_link']          = 'Restablecer la contraseña';

// New Password Email
$lang['email_new_password_subject']          = 'nueva contraseña';
$lang['email_new_password_heading']          = 'nueva contraseña';
$lang['email_new_password_subheading']       = 'Su contraseña se ha restablecido a:';

// Invoice Email
$lang['emails']                              = 'Correos electrónicos';
$lang['email_to']                            = "A";
$lang['email_subject']                       = "Tema";
$lang['email_cc']                            = "CC";
$lang['email_bcc']                           = "BCC";
$lang['show_hide_cc_bcc']                    = "Mostrar / ocultar CC &amp; BCC";
$lang['send_email']                          = "Enviar correo electrónico";
$lang['emails_list']                         = 'Correo (s)';
$lang['send']                                = 'Enviar';
$lang['additional_content']                  = 'Contenido adicional';
$lang['emails_example']                      = 'Ex: contact@sis.com, info@sis.com ...';
$lang['email_invoice_subject']               = 'Factura PDF de% s';
$lang['email_invoice_heading']               = 'Saludos !';
$lang['email_invoice_subheading']            = 'Ha recibido una factura de <b>% s</b> . <br> Se adjunta un archivo PDF.';
$lang['email_successful']                    = 'Email enviado. Comprueba tu bandeja de entrada o spam';
$lang['email_unsuccessful']                  = 'No se puede enviar correo electrónico, comprueba tu configuración de correo electrónico.';


$lang['email_dear']                          = 'querido %s ,';
$lang['send_payments_reminder']              = 'Enviar un recordatorio de pagos';
$lang['no_unpaid_invoies']                   = "este cliente no tiene facturas pendientes de pago!";
$lang['email_rinvoice_subject']              = 'Nueva factura de %s ';
$lang['email_rinvoice_subheading']           = 'Ha recibido una nueva factura no pagada de %s .';
$lang['email_unpaid_subject']                = 'Tiene facturas pendientes de pago de %s ';
$lang['email_unpaid_invoices']               = 'Tienes %s facturas pendientes de pago.';
$lang['email_overdue_subject']               = 'Tiene factura vencida de %s ';
$lang['email_overdue_reminder']              = 'Es posible que haya perdido la fecha de pago y la factura esté atrasada por %s días.';

$lang['overdue_reminder']                    = "Recordatorio atrasado";
$lang['once_is']                             = "Una vez que la factura es";
$lang['days_late']                           = "días de retraso";
$lang['and_every']                           = "y cada";
$lang['days_after']                          = "dias despues";

/* --------------------------- DATATABLES --------------------------------------------- */
$lang['loading_data']               =   "Cargando datos desde el servidor";
$lang['sEmptyTable']                =   "No se han encontrado resultados en tablas";
$lang['no_data']                    =   "No se han encontrado resultados !";
$lang['sInfo']                      =   "Mostrar _START_ a _END_ de _TOTAL_ líneas";
$lang['sInfoEmpty']                 =   "Mostrando 0 de 0 de 0 filas";
$lang['sInfoFiltered']              =   "(Filtrado de _MAX_ entradas totales)";
$lang['sInfoPostFix']               =   "";
$lang['sInfoThousands']             =   ",";
$lang['sLengthMenu']                =   "Mostrar _MENU_ líneas";
$lang['sLoadingRecords']            =   "Cargando...";
$lang['sProcessing']                =   "Tratamiento...";
$lang['sSearch']                    =   "Buscar";
$lang['advanced_search']            =   "Búsqueda Avanzada";
$lang['sZeroRecords']               =   "No se han encontrado resultados";
$lang['sFirst']                     =   "&lt;&lt;";
$lang['sLast']                      =   "&gt;&gt;";
$lang['sNext']                      =   "&gt;";
$lang['sPrevious']                  =   "&lt;";
$lang['sSortAscending']             =   ": Habilitar arreglos ascendentes";
$lang['sSortDescending']            =   ": Habilitar arreglos de enlace descendente";
$lang['colvis_buttonText']          =   "Mostrar / ocultar columnas";
$lang['colvis_sRestore']            =   "Restaurar original";
$lang['colvis_sShowAll']            =   "Mostrar todo";
$lang['tabletool_csv']              =   "Descargar CSV";
$lang['tabletool_xls']              =   "Descargar Excel";
$lang['tabletool_copy']             =   "Dupdo";
$lang['tabletool_pdf']              =   "Descargar PDF";
$lang['tabletool_text']             =   "Descargar texto";
$lang['tabletool_print']            =   "Impresión";
$lang['tabletool_print_sInfo']      =   "<H6> Vista previa de impresión </ h6><p> Utilice la función de impresión de su navegador para imprimir esta tabla. Pulse Esc cuando haya terminado. </p>";
$lang['tabletool_print_sToolTip']   =   "Ver vista de impresión";
$lang['tabletool_select']           =   "Seleccionar";
$lang['tabletool_select_single']    =   "Seleccionar Individual";
$lang['tabletool_select_all']       =   "Seleccionar todo";
$lang['tabletool_select_none']      =   "Seleccionar todo";
$lang['tabletool_ajax']             =   "Botón Ajax";
$lang['tabletool_collection']       =   "Descargar";
$lang['export']                     =   "Exportar";
$lang['export_csv']                 =   "Exportar como CSV";
$lang['export_xls']                 =   "Exportar como Excel";
$lang['export_pdf']                 =   "Exportar como PDF";
$lang['export_text']                =   "Exportar como texto";
$lang['all']                        = "Todas";

/* --------------------------- DATERANGE --------------------------------------------- */
$lang['daterange_today']            = "Hoy";
$lang['daterange_yesterday']        = "Ayer";
$lang['daterange_last_7_days']      = "Los últimos 7 días";
$lang['daterange_last_30_days']     = "Últimos 30 días";
$lang['daterange_this_month']       = "Este mes";
$lang['daterange_last_month']       = "El mes pasado";
$lang['daterange_this_year']        = "Este año";
$lang['daterange_custom']           = "Rango personalizado";
$lang['daterange_end_of_last_month']= "Fin del mes pasado";
$lang['daterange_end_of_year']      = "Fin del año pasado";

$lang['error']                      = 'Error';
$lang['success']                    = 'Éxito';

// Register
$lang['register_heading']           = 'Registro';
$lang['register_subheading']        = 'Crea tu cuenta';
$lang['register_ask']               = '¿No tienes una cuenta?';
$lang['register_btn']               = '¡Regístrate ahora!';
$lang['register_username']          = 'Nombre de usuario';
$lang['register_email']             = 'Dirección de correo electrónico';
$lang['register_password']          = 'Contraseña';
$lang['register_password_confirm']  = 'Confirmar contraseña';
$lang['register_submit_btn']        = 'Crear una cuenta';

$lang['default_group']              = 'Nuevo grupo de cuentas';
$lang['enable_register']            = 'Habilitar registro';
$lang['reference_type']             = 'Tipo de referencia';
$lang['show_reference']             = 'Mostrar referencia';
$lang['reference_type_changed']     = '¡El tipo de referencia ha cambiado! <br> ¿Desea restablecer la referencia de todas las facturas al nuevo tipo?';
$lang['generate']                   = 'Generar';
$lang['no_invoice_items']           = 'Se requieren los elementos de factura. Debe tener al menos 1 elemento como mínimo';


$lang["loading"]                    = 'Cargando...';
$lang["file"]                       = 'Archivo';
$lang["shortcut_help"]              = 'Ayuda de acceso directo';
$lang["shortcut_help_title"]        = 'Atajos de teclado Ayuda';
$lang["documentations"]             = 'Documentaciones';
$lang["about"]                      = 'Acerca de';
$lang["shortcut"]                   = 'Atajo';
$lang["main_menu"]                  = 'Menú principal';

$lang["settings_email"]             = 'Configuración del correo electrónico';
$lang["configuration_email"]        = 'Ajustes del correo electrónico';
$lang["protocol"]                   = 'Protocolo';
$lang["smtp_crypto"]                = 'Encripción';
$lang["smtp_host"]                  = 'Anfitrión SMTP';
$lang["smtp_port"]                  = 'Puerto SMTP';
$lang["smtp_user"]                  = 'Usuario SMTP';
$lang["smtp_pass"]                  = 'Contraseña SMTP';
$lang["mailpath"]                   = 'Ruta de correo';
$lang["settings_email_updated"]     = "La configuración de correo electrónico se actualiza correctamente";

// importing data
$lang['import_data']                   = "Importación de datos";
$lang['idata_title']                   = "Importación de datos";
$lang['idata_subheading']              = "¿Qué datos desea importar?";
$lang['idata_upload_file']             = "Subir archivo";
$lang['idata_upload_file_subheading']  = 'Por favor ingrese la información a continuación.';
$lang['idata_match_fields']            = "Campos de coincidencia";
$lang['idata_match_fields_subheading'] = "Adapte sus campos a los campos de aplicación";
$lang['idata_confirm_data']            = "Confirmación de datos";
$lang['idata_confirm_data_subheading'] = "Confirme y borre sus datos";
$lang['idata_add_to_database']         = "Añadir a base de datos";
$lang['idata_add_to_db_subheading']    = "La adición a la base de datos y el paso final";
$lang['idata_customers']               = "Importación de clientes";
$lang['idata_customers_description']   = "Importación de clientes (nombres, direcciones, etc.)";
$lang['idata_suppliers']               = "Importación de proveedores";
$lang['idata_suppliers_description']   = "Importación de proveedores (nombres, direcciones, etc.)";
$lang['idata_ex_cats']                 = "Importar categorías de gastos";
$lang['idata_ex_cats_description']     = "Importar categorías de gastos (tipo, etiqueta)";
$lang['idata_users']                   = "Importar usuarios";
$lang['idata_users_description']       = "Importar usuarios (nombre de usuario, contraseña, correo electrónico, etc.)";
$lang['idata_tax_rates']               = "Importación de las tasas de impuestos";
$lang['idata_tax_rates_description']   = "Importación de las tasas de impuestos (etiqueta, valor y tipo)";
$lang['idata_items']                   = "Importación de elementos";
$lang['idata_items_description']       = "Importación de artículos (nombre, descripción, precio, etc.)";
$lang['idata_item_cats']               = "Importación de categorías de artículo";
$lang['idata_item_cats_description']   = "Importación de categorías de artículo (etiqueta)";


$lang['idata_info']                    = "Lista de campos que puede contener el archivo de datos. Los campos marcados en negrita son obligatorios. Si está importando datos con símbolos especiales (comas, puntos y comas, etc.), asegúrese de que tiene estos campos indicados con cita!";
$lang['idata_checklist']               = "Revise su lista antes de importar";
$lang['idata_file_format']             = "Formato de archivos CSV aceptados (* .csv) o archivos de Excel (* .xls, * .xlsx)";
$lang['idata_download_sample_file']    = "Descargue un archivo de ejemplo para ver lo que podemos importar.";
$lang['idata_download_sample']         = "Descargar archivo de muestra";
$lang['idata_csv_delimiter']           = "Separador CSV";
$lang['idata_semicolon']               = "Punto y coma";
$lang['idata_comma']                   = "Coma";
$lang['idata_tab']                     = "Lengüeta";
$lang['idata_file']                    = "Archivo";
$lang['idata_max_file_size']           = "Tamaño máximo de 2MB o 1000 líneas";
$lang['idata_delete_item']             = "Eliminar este elemento";
$lang['idata_items_are_imported']      = "Los artículos se importan";
$lang['idata_item_is_imported']        = "El artículo se importa";
$lang['idata_imported']                = "La importación de datos se completa con éxito";
$lang['idata_failed']                  = "La importación de datos no se comprueba sus entradas de nuevo!";
$lang['idata_no_data']                 = "Usted no inserta ningún dato, revise sus entradas de nuevo!";


$lang["settings_db"]                   = 'Copias de seguridad';
$lang["configuration_db"]              = 'Copias de seguridad de bases de datos';
$lang["create_backup"]                 = 'Crear copia de seguridad';
$lang["date_creation"]                 = "Fecha de creación";
$lang["filename"]                      = "Nombre del archivo";
$lang["restore_backup"]                = 'Restaurar copia de seguridad';
$lang["delete_backup"]                 = 'Eliminar copia de seguridad';
$lang["restore_backup_success"]        = "La copia de seguridad de la base de datos se restaura correctamente";
$lang["restore_backup_failed"]         = "La copia de seguridad de la base de datos no funciona";
$lang["backup_deleted"]                = "La copia de seguridad de la base de datos se eliminó correctamente";



$lang['tax_rate']                      = "Tasa de impuesto";
$lang['settings_tax_rates']            = "Las tasas de impuestos";
$lang['configuration_tax_rates']       = "Las tasas de impuestos";
$lang["no_tax"]                        = "Sin impuestos";
$lang['create_tax_rate']               = "Añadir tasa impositiva";
$lang['tax_rate_label']                = "Código de impuestos";
$lang['tax_rate_value']                = "Tasa / cantidad";
$lang['tax_rate_type']                 = "Tipo de tasa impositiva";
$lang['tax_rate_default']              = "Tasa de impuesto predeterminada";
$lang['tax_rate_new']                  = "Crear una nueva tasa de impuesto";
$lang['tax_rate_update']               = "Actualizar tasa de impuesto";
$lang['tax_rate_added']                = "Tasa de impuestos agregada con éxito";
$lang['tax_rate_updated']              = "Tasa de impuesto actualizada con éxito";
$lang['tax_rate_deleted']              = "La tasa de impuesto eliminada correctamente";
$lang['condition']                     = "Condición";
$lang['conditional_taxes']             = "Impuestos condicionales";
$lang['conditional_taxes_subheading']  = "Agregue una tasa de impuestos a sus publicaciones (factura / estimación) con una condición sobre el subtotal";
$lang['conditional_taxes_tip']         = "ex: agregar impuesto de $ 7 en todas las facturas tiene subtotal mayor o igual $ 150";
$lang['is_default']                    = "Es predeterminado";
$lang['default']                       = "Defecto";
$lang['add_tax']                       = "Añadir impuesto";
$lang['shipping']                      = "Envío";
$lang['condition_terms']               = "Términos y condiciones";
$lang['invoice_note']                  = "Nota de factura";
$lang['note']                          = "Nota de factura";
$lang['set_status']                    = "Cambiar Estado";
$lang['set_status_subheading']         = "Elegir el nuevo estado de esta factura";
$lang['old_status']                    = "Estado antiguo";
$lang['clear_filter']                  = "Filtro claro";
$lang['shown_columns']                 = "Columnas activas";
$lang['number_format']                 = "Formato numérico";
$lang['round_number']                  = "Números redondos";
$lang['decimal_place']                 = "Decimal";
$lang['disabled']                      = "Discapacitado";
$lang['enabled']                       = "Habilitado";
$lang['apply_to_subtotal']             = "Aplicar al subtotal de la declaración";
$lang['apply_to_line']                 = "Aplicar a elementos de línea";

$lang['estimate']                      = "Estimar";
$lang['estimates']                     = "Estimados";
$lang['estimates_subheading']          = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['estimate_no']                   = "N ° de estimación";
$lang['estimate_items']                = "Estimar elementos";
$lang['estimate_title']                = "Título estimado";
$lang['estimate_note']                 = "Nota de estimación";
$lang['create_estimate']               = "Crear estimación";
$lang['create_estimate_subheading']    = "Para crear una nueva estimación, ingrese la información a continuación.";
$lang['estimate_add_success']          = "Estimación creada correctamente";
$lang['edit_estimate']                 = "Editar estimación";
$lang['edit_estimate_subheading']      = "Para editar esta estimación, ingrese la información a continuación.";
$lang['estimate_edit_success']         = "Estimación actualizada correctamente";
$lang['estimate_deleted']              = "Se ha eliminado correctamente la estimación";
$lang['cant_delete_estimate']          = "No puede eliminar esta estimación!, Causa: <br><ul><li> Esta Estimación está relacionada con otros ítems </li></ul> Debe eliminar todos los elementos e intentarlo de nuevo.";
$lang['estimate_duplicate_success']    = "Estimación duplicada correctamente";
$lang['email_estimate_subject']        = "Calcule el PDF de% s";
$lang['no_estimate_items']             = "Se requieren los Elementos de estimación. Debe tener al menos 1 elemento como mínimo";
$lang['preview_estimate_error']        = "Para previsualizar esta estimación, ingrese todas las informaciones requeridas.";
$lang['email_estimate_heading']        = 'Saludos !';
$lang['email_estimate_subheading']     = 'Ha recibido una estimación de <b>% s</b> . <br> Se adjunta un archivo PDF.';
$lang['convert_to_invoice']            = "Convertir a factura";
$lang['sent']                          = "Expedido";
$lang['accepted']                      = "Aceptado";
$lang['invoiced']                      = "Facturado";
$lang['approve']                       = "Aprobar";
$lang['reject']                        = "Rechazar";

$lang['cash']                          = "Efectivo";
$lang['check']                         = "Comprobar";
$lang['bank_transfer']                 = "transferencia bancaria";
$lang['online']                        = "En línea";
$lang['other']                         = "Otro";

$lang['payment']                       = "Pago";
$lang['payments']                      = "Pagos";
$lang['payments_subheading']           = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['payments_create']               = "Crear pago";
$lang['payments_create_subheading']    = "Para crear un nuevo pago, ingrese la información a continuación.";
$lang['payments_create_success']       = "Pago creado correctamente";
$lang['payments_edit']                 = "Modificar pago";
$lang['payments_edit_subheading']      = "Para editar este pago, ingrese la información a continuación.";
$lang['payments_edit_success']         = "Pago actualizado con éxito";
$lang['payments_deleted']              = "Pago eliminado correctamente";
$lang['payment_number']                = "Número de pago";
$lang['payment_details']               = "Detalles del pago";
$lang['amount']                        = "Cantidad";
$lang['payment_method']                = "Método de pago";
$lang['method']                        = "Método";
$lang['total_paid']                    = "Total pagado";
$lang['email_payment_subject']         = "Pago PDF de% s";
$lang['no_payment_items']              = "Se requieren los elementos de pago. Debe tener al menos 1 elemento como mínimo";
$lang['preview_payment_error']         = "Para obtener una vista previa de este pago, ingrese todas las informaciones requeridas.";
$lang['email_payment_heading']         = 'Saludos !';
$lang['email_payment_subheading']      = 'Ha recibido un pago de <b>% s</b> . <br> Se adjunta un archivo PDF.';
$lang['payment_for']                   = "Pago por";
$lang['set_status_payment_subheading'] = "Elija el nuevo estado de este recibo de pago";

$lang['receipt']                       = "Recibo de pago";
$lang['receipts']                      = "Recibos de pago";
$lang['receipt_no']                    = "Recibo de pago N °";
$lang['receipt_for']                   = "Recibo de";
$lang['create_receipt']                = "crear un recibo";
$lang['receipts_create']               = "Crear recibo";
$lang['receipts_create_subheading']    = "Para hacer un recibo nuevo, ingrese la información a continuación.";
$lang['receipts_edit']                 = "Editar recibo";
$lang['receipts_edit_subheading']      = "Para editar este recibo, ingrese la siguiente información.";
$lang['receipts_create_success']       = "Recepción creada correctamente";
$lang['receipts_edit_success']         = "Recibo actualizado correctamente";
$lang['receipts_deleted']              = "Recepción eliminada correctamente";


// PAYMENTS ONLINE
$lang['payments_online']               = "Pagos en línea";
$lang['general']                       = "General";
$lang['paypal']                        = "Paypal";
$lang['stripe']                        = "Stripe";
$lang['twocheckout']                   = "2Checkout";
$lang['mobilpay']                      = "MobilPay";
$lang['payments_online_requirements']  = "Este servidor no tiene los requisitos mínimos para habilitar los pagos en línea!";
$lang['payments_online_enable']        = "Habilitar";
$lang['biller_accounts']               = "Cuenta de Biller";
$lang['enable']                        = "Habilitar";
$lang['username']                      = "Nombre de usuario";
$lang['password']                      = "Contraseña";
$lang['sandbox']                       = "Salvadera";
$lang['enable']                        = "Habilitar";
$lang['api_key']                       = "Clave API";
$lang['enable']                        = "Habilitar";
$lang['account_number']                = "Número de cuenta";
$lang['secretWord']                    = "Palabra secreta";
$lang['merchant_id']                   = "Identificación del comerciante";
$lang['public_key']                    = "Llave pública";
$lang['test_mode']                     = "Modo de prueba";
$lang['panding']                       = "Pendiente";
$lang['released']                      = "Liberado";
$lang['active']                        = "Activo";
$lang['expired']                       = "Muerto";
$lang['finished']                      = "Terminado";
$lang['payment_released']              = "Pago liberado con éxito";
$lang['payment_canceled']              = "Pago cancelado";



$lang['credit_card']                   = "Tarjeta de crédito";
$lang['credit_card_firstName']         = "Nombre de pila";
$lang['credit_card_lastName']          = "Apellido";
$lang['credit_card_number']            = "Número de tarjeta de crédito";
$lang['credit_card_expiryMonth']       = "Meses de vencimiento";
$lang['credit_card_expiryYear']        = "Año de vencimiento";
$lang['credit_card_cvv']               = "CVV / CVC";

$lang["settings_po_updated"]           = "La configuración de pagos en línea se actualiza correctamente";

$lang['custom_field']                  = "Campo personalizado";
$lang['custom_fields']                 = "Campos Personalizados";
$lang['custom_field_label']            = "Etiqueta de campo personalizada";
$lang['custom_field_value']            = "Valor del campo personalizado";
$lang['customer_cf']                   = "Campos personalizados de cliente";
$lang['custom_field_1']                = "Campo personalizado1";
$lang['custom_field_2']                = "Campo personalizado2";
$lang['custom_field_3']                = "Campo personalizado3";
$lang['custom_field_4']                = "Campo personalizado4";
$lang['vat_number']                    = "Número de valor agregado";
$lang['vat_number_placeholder']        = "Número de identificación del IVA";



// CUSTOMERS
$lang['customer_bill_to']             = 'Cobrar a';
$lang['customer']                     = 'Cliente';
$lang['customers']                    = 'Clientela';
$lang['customer_add_success']         = "Cliente agregado correctamente";
$lang['customer_edit_success']        = "Cliente actualizado correctamente";
$lang['customer_deleted']             = "Cliente eliminado correctamente";
$lang['cant_delete_customer']         = "No puede eliminar este cliente!, Causa: <br><ul><li> Este cliente está relacionado con otra factura </li></ul> Debe eliminar todas sus facturas y, a continuación, intente de nuevo.";
$lang['customers_subheading']         = 'Utilice la tabla siguiente para navegar o filtrar los resultados.';
$lang['create_customer']              = 'Agregar cliente';
$lang['edit_customer']                = "Editar cliente";
$lang['details_customer']             = "Detalles del cliente";
$lang['create_customer_subheading']   = "Para agregar un nuevo cliente, ingrese la información a continuación.";
$lang['edit_customer_subheading']     = "Para editar este cliente, ingrese la información a continuación.";
$lang['profile_customer']             = "Perfil del cliente";
$lang['profile']                      = "Perfil";
$lang['edit_customer_account']        = "Editar cuenta";
$lang['create_customer_account']      = "Crear una cuenta";
$lang['account_created']              = "Se ha creado correctamente la cuenta de cliente";
$lang['account_username']             = "Nombre de usuario";
$lang['account_status']               = "estado de la cuenta";


// SUPPLIERS
$lang['supplier_bill_to']             = 'Factura de';
$lang['supplier']                     = 'Proveedor';
$lang['suppliers']                    = 'Proveedores';
$lang['supplier_add_success']         = "Proveedor añadido correctamente";
$lang['supplier_edit_success']        = "Proveedor actualizado correctamente";
$lang['supplier_deleted']             = "Proveedor eliminado correctamente";
$lang['cant_delete_supplier']         = "No puede eliminar este proveedor!, Causa: <br><ul><li> Este proveedor está relacionado con otra factura </li></ul> Debe eliminar todas sus facturas y, a continuación, intente de nuevo.";
$lang['suppliers_subheading']         = 'Utilice la tabla siguiente para navegar o filtrar los resultados.';
$lang['create_supplier']              = 'Añadir proveedor';
$lang['edit_supplier']                = "Editar proveedor";
$lang['details_supplier']             = "Detalles del Proveedor";
$lang['create_supplier_subheading']   = "Para agregar un nuevo proveedor, ingrese la información a continuación.";
$lang['edit_supplier_subheading']     = "Para editar este proveedor, ingrese la información a continuación.";

// ITEMS
$lang['item']                     = 'ít.';
$lang['items']                    = "Artículos";
$lang['price']                    = 'Precio';
$lang['default_tax']              = 'Impuestos por defecto';
$lang['default_discount']         = 'Descuento por defecto';
$lang['item_add_success']         = "Elemento agregado correctamente";
$lang['item_edit_success']        = "Elemento actualizado correctamente";
$lang['item_deleted']             = "Elemento eliminado correctamente";
$lang['cant_delete_item']         = "No puede eliminar este elemento!, Causa: <br><ul><li> Este elemento está relacionado con otra factura </li></ul> Tienes que borrar todas sus facturas, luego vuelve a intentarlo";
$lang['items_subheading']         = 'Utilice la tabla siguiente para navegar o filtrar los resultados.';
$lang['create_item']              = 'Añadir artículo';
$lang['edit_item']                = "Editar elemento";
$lang['details_item']             = "detalles del artículo";
$lang['create_item_subheading']   = "Para agregar un nuevo artículo, ingrese la información a continuación.";
$lang['edit_item_subheading']     = "Para editar este elemento, ingrese la información que aparece a continuación.";
$lang['prices']                   = "Precios";
$lang['unit']                     = "Unidad";
$lang['add_new_price']            = "Añadir nuevo precio";
$lang['no_item_prices']           = "Se requiere el precio del artículo. Debe tener al menos 1 precio para este artículo como mínimo";
$lang['category']                 = "Categoría";
$lang['categories']               = "Categorías";
$lang['items_categories']         = "Categorías";
$lang['category_create']          = "Crear una nueva categoría";
$lang['category_update']          = "Actualizar categoría";
$lang['category_added']           = "Categoría añadida correctamente";
$lang['category_updated']         = "Categoría actualizada con éxito";
$lang['category_deleted']         = "Categoría eliminada correctamente";


$lang['invoices_activities']      = "Actividades de facturación";
$lang['estimates_activities']     = "Estimar Actividades";
$lang['activities']               = "Ocupaciones";


$lang['files']                    = "Archivos";
$lang['files_subheading']         = "Files_subheading";
$lang['file_rename']              = "Cambiar el nombre de un archivo / carpeta";
$lang['create_folder']            = "Crear carpeta";
$lang['file_move_to']             = "Movimiento";
$lang['files_view']               = "Avance";
$lang['files_share']              = "Compartir";
$lang['file_deleted']             = "Archivo eliminado correctamente";
$lang['file_moved_trash']         = "El archivo se trasladó correctamente a la papelera";
$lang['file_restored']            = "Archivo restaurado correctamente";
$lang['cant_delete_file']         = "¡No puedes borrar este archivo!";
$lang['file_rename_success']      = "Archivo / carpeta renombrada correctamente";
$lang['file_moved_success']       = "Archivo / carpeta movida correctamente";
$lang['create_folder_success']    = "Carpeta creada correctamente";
$lang['filename']                 = "Nombre del archivo";
$lang['size']                     = "tamaño";
$lang['file_type']                = "Tipo de archivo";
$lang['upload_date']              = "Fecha de carga";
$lang['gohome']                   = "Vete a casa";
$lang['goback']                   = "Regresa";
$lang['open_trash']               = "Abrir la Papelera";
$lang['delete_definitive']        = "Eliminar definitivo";
$lang['restore_file']             = "Restaurar archivo";
$lang['grid']                     = "Vista en cuadrícula";
$lang['list']                     = "Vista de la lista";
$lang['sort']                     = "Ordenar";
$lang['upload']                   = "Subir";
$lang['share']                    = "Compartir";
$lang['copylink']                 = "Copiar link";
$lang['copy']                     = "Dupdo";
$lang['move_to']                  = "Mover a";
$lang['move']                     = "Movimiento";
$lang['rename']                   = "Rebautizar";
$lang['foldername']               = "Nombre de la carpeta";
$lang['folder']                   = "Carpeta";
$lang['text_is_copied']           = "El texto se copia en el portapapeles";
$lang['no_file_selected']         = "No se ha seleccionado ningún archivo para cargarlo.";
$lang['browse_files']             = "Búsqueda de archivos";
$lang['confirm']                  = "Confirmar";
$lang['dimensions']               = "Dimensiones";
$lang['duration']                 = "Duración";
$lang['crop']                     = "Cultivo";
$lang['rotate']                   = "Girar";
$lang['choose']                   = "Escoger";
$lang['to_upload']                = "subir";
$lang['files_were']               = "los archivos";
$lang['file_was']                 = "el archivo fue";
$lang['chosen']                   = "elegido";
$lang['drag_drop_file']           = "Arrastrar y soltar archivos aquí";
$lang['or']                       = "o";
$lang['drop_file']                = "Suelta los archivos aquí para Cargar";
$lang['paste_file']               = "Pegando un archivo, haga clic aquí para cancelar.";
$lang['remove_confirmation']      = "¿Seguro que desea eliminar este archivo?";
$lang['folder']                   = "Carpeta";
$lang['filesLimit']               = "Solamente %s los archivos se pueden cargar.";
$lang['filesType']                = "Solamente %s los archivos se pueden cargar.";
$lang['fileSize']                 = "¡Es demasiado largo! Elija un archivo de hasta %s MEGABYTE.";
$lang['filesSizeAll']             = "Los archivos que eligió son demasiado grandes! Cargue archivos hasta %s MEGABYTE.";
$lang['fileName']                 = "Archivo con el nombre %s ya está seleccionado. &#39;";
$lang['folderUpload']             = "No puedes subir carpetas.";
$lang['no_more_space']            = "No más espacio para subir estos archivos!";
$lang['add_attached_file']        = "Adjuntar archivo";
$lang['uploader']                 = "Documentos";
$lang['settings_files']           = "Configuración de subida";
$lang['configuration_files']      = "Configuración de la carga de archivos";
$lang['file_upload_enable']       = "habilitar la carga de archivos";
$lang['user_disc_space']          = "Espacio del disco del usuario";
$lang['user_disc_space_tip']      = "Cuánto espacio se permite a cada uno de los archivos de usuario tomar en su servidor (en megabytes).";
$lang['max_upload_size']          = "Tamaño máximo de subida";
$lang['max_upload_size_tip']      = "El tamaño máximo de archivo que los usuarios pueden subir (en megabytes).";
$lang['max_simult_uploads']       = "Máximo de subidas simultáneas.";
$lang['max_simult_uploads_tip']   = "Cuántos archivos el usuario puede subir al mismo tiempo.";
$lang['white_list']               = "Lista blanca";
$lang['white_list_tip']           = "Los usuarios sólo podrán subir archivos con estos formatos. Ejemplo: mp4, jpg, mp3, pdf.";
$lang["settings_files_updated"]   = "La configuración de los archivos se actualiza con éxito";

$lang['send_link_via_email']      = "Enviar este enlace por correo electrónico";
$lang['links']                    = "Campo de golf";
$lang['view_link']                = "Ver enlace";
$lang['direct_link']              = "Enlace directo";
$lang['download_link']            = "Enlace de descarga";
$lang['html_embed_code']          = "Código de inserción de HTML";
$lang['forum_embed_code']         = "Código de inserción del foro";
$lang['email_file_subject']       = "Archivo de %s ";

$lang['folder']                   = "Carpeta";
$lang['folder']                   = "Carpeta";
$lang['folder']                   = "Carpeta";
$lang['folder']                   = "Carpeta";
$lang['folder']                   = "Carpeta";


// RECURRING INVOICES
$lang['rinvoice']                      = "Factura recurrente";
$lang['rinvoices']                     = "Facturas recurrentes";
$lang['rinvoices_subheading']          = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['recu_invoice_schedule']         = "Plan de facturación recurrente";
$lang['frequency']                     = "Frecuencia";
$lang['every']                         = "Cada";
$lang['occurences']                    = "Ocurrencias";
$lang['daily']                         = "Diariamente";
$lang['weekly']                        = "Semanal";
$lang['monthly']                       = "Mensual";
$lang['yearly']                        = "Anual";
$lang['day']                           = "Día";
$lang['days']                          = "Días";
$lang['week']                          = "Semana";
$lang['weeks']                         = "Semanas";
$lang['month']                         = "Mes";
$lang['months']                        = "Meses";
$lang['year']                          = "Año";
$lang['years']                         = "Años";
$lang['recu_when_start']               = "¿Cuándo comenzará la programación automática?";
$lang['recu_when_create']              = "¿Cuándo se crearán las facturas?";
$lang['invoice_will_every']            = "La factura se creará cada";
$lang['on']                            = "en";
$lang['on_the']                        = "sobre el";
$lang['forever']                       = "Siempre";
$lang['for']                           = "para";
$lang['occurence_time']                = "1 vez";
$lang['occurence_times']               = "veces";
$lang['recurring_effective']           = "La recurrencia es efectiva";
$lang['package_name']                  = "Nombre del paquete";
$lang['create_rinvoice']               = "Crear factura recurrente";
$lang['create_rinvoice_subheading']    = "Para crear una nueva factura recurrente, ingrese la información a continuación.";
$lang['rinvoice_is_canceled']          = "¡Esta factura recurrente se cancela no se puede editar!";
$lang['edit_rinvoice']                 = "Editar factura recurrente";
$lang['edit_rinvoice_subheading']      = "Para editar esta Factura Recurrente, ingrese la información que aparece a continuación.";
$lang['rinvoices_activities']          = "Actividades de facturas recurrentes";
$lang['rinvoice_add_success']          = "Se ha creado correctamente la factura recurrente";
$lang['rinvoice_edit_success']         = "Factura recurrente actualizada correctamente";
$lang['rinvoice_deleted']              = "Se ha eliminado correctamente la factura recurrente";
$lang['cant_delete_rinvoice']          = "No puede eliminar esta factura recurrente!, Causa: <br><ul><li> Esta factura recurrente está relacionada con otros elementos </li></ul> Debe eliminar todos los elementos e intentarlo de nuevo.";
$lang['rinvoice_duplicate_success']    = "Factura recurrente duplicada correctamente";
$lang['rinvoice_started']              = "Se ha iniciado correctamente el perfil de factura recurrente";
$lang['rinvoice_canceled']             = "Se cancela el perfil de factura recurrente";
$lang['rinvoice_skipped']              = "La factura recurrente omitió la factura siguiente con éxito";
$lang['start_profile']                 = "Iniciar perfil";
$lang['cancel_profile']                = "Cancelar perfil";
$lang['skip_next_invoice']             = "Saltar la próxima factura";
$lang['scheduled']                     = "Programado";
$lang['skipped']                       = "Omitido";
$lang['this_invoice_skipped']          = "Esta factura se omite";
$lang['next_billing_date']             = "Próxima fecha de facturación";
$lang['today']                         = "Hoy";
$lang['cronjob_desactivated']          = "para habilitar las facturas recurrentes que tiene que agregar este comando %s en el trabajo cron en su CPanel";
$lang['rinvoice_draft']                = "Guardar factura como un borrador en cada ocurrencia";
$lang['rinvoice_sent']                 = "Enviar factura por correo electrónico directamente al cliente en cada caso";


// contracts
$lang['contract']                      = "Contrato";
$lang['contracts']                     = "Contratos";
$lang['contracts_subheading']          = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['create_contract']               = "Crear nuevo contrato";
$lang['create_contract_subheading']    = "Para crear un nuevo contrato, ingrese la siguiente información.";
$lang['edit_contract']                 = "Editar contrato";
$lang['edit_contract_subheading']      = "Para editar este Contrato, ingrese la siguiente información.";
$lang['contract_add_success']          = "Factura del contrato creada correctamente";
$lang['contract_edit_success']         = "Factura del contrato actualizada correctamente";
$lang['contract_deleted']              = "La factura del contrato se eliminó correctamente";
$lang['cant_delete_contract']          = "No puede eliminar este Contrato!, Causa: <br><ul><li> Esta factura recurrente está relacionada con otros elementos </li></ul> Debe eliminar todos los elementos e intentarlo de nuevo.";
$lang['subject']                       = "Tema";
$lang['contract_type']                 = "tipo de contrato";
$lang['contract_value']                = "Valor del contrato";
$lang['contract_description']          = "Descripción del contrato";
$lang['email_contract_subject']        = "Contrato PDF de %s ";
$lang['email_contract_heading']        = 'Saludos !';
$lang['email_contract_subheading']     = 'Ha recibido un contrato de %s . <br> Se adjunta un archivo PDF.';


// Expenses
$lang['expense']                       = "Gastos";
$lang['expenses']                      = "Gastos";
$lang['expenses_subheading']           = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['expenses_create']               = "Crear nuevo gasto";
$lang['expenses_create_subheading']    = "Para crear un nuevo gasto, ingrese la información a continuación.";
$lang['expenses_edit']                 = "Editar gastos";
$lang['expenses_edit_subheading']      = "Para editar este gasto, ingrese la información a continuación.";
$lang['expenses_create_success']       = "Gastos creados correctamente";
$lang['expenses_edit_success']         = "Gastos actualizados con éxito";
$lang['expenses_deleted']              = "Gastos eliminados correctamente";
$lang['category']                      = "Categoría";
$lang['attachments']                   = "Archivos adjuntos";
$lang['download_attachments']          = "Descargar archivos adjuntos";
$lang['invoice_number']                = "Número de factura";
$lang['expense_number']                = "Número de Gastos";
$lang['expenses_category']             = "Categoría";
$lang['expenses_categories']           = "Categorías";
$lang['expenses_subheading']           = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['expenses_category_create']      = "Crear una nueva categoría";
$lang['expenses_category_update']      = "Editar categoría";
$lang['expenses_category_added']       = "Categoría creada correctamente";
$lang['expenses_category_updated']     = "Categoría actualizada con éxito";
$lang['expenses_category_deleted']     = "Categoría eliminada correctamente";
$lang['expenses_category_type']        = "Tipo";
$lang['expenses_category_label']       = "Etiqueta";
$lang['expense_no']                    = "Gastos N °";



$lang['amount_in_words']         = 'Cantidad en palabras';
$lang['nbr_conjunction']         = 'y';
$lang['nbr_negative']            = 'negativo';
$lang['nbr_decimal']             = 'punto';
$lang['nbr_separator']           = ',';
$lang['nbr_inversed']            = false;
$lang['nbr_0']                   = 'cero';
$lang['nbr_1']                   = 'uno';
$lang['nbr_2']                   = 'dos';
$lang['nbr_3']                   = 'Tres';
$lang['nbr_4']                   = 'las cuatro';
$lang['nbr_5']                   = 'cinco';
$lang['nbr_6']                   = 'seis';
$lang['nbr_7']                   = 'siete';
$lang['nbr_8']                   = 'ocho';
$lang['nbr_9']                   = 'nueve';
$lang['nbr_10']                  = 'diez';
$lang['nbr_11']                  = 'once';
$lang['nbr_12']                  = 'doce';
$lang['nbr_13']                  = 'trece';
$lang['nbr_14']                  = 'catorce';
$lang['nbr_15']                  = 'quince';
$lang['nbr_16']                  = 'dieciséis';
$lang['nbr_17']                  = 'de diecisiete';
$lang['nbr_18']                  = 'Dieciocho';
$lang['nbr_19']                  = 'diecinueve';
$lang['nbr_20']                  = 'veinte';
$lang['nbr_30']                  = 'treinta';
$lang['nbr_40']                  = 'cuarenta';
$lang['nbr_50']                  = 'cincuenta';
$lang['nbr_60']                  = 'sesenta';
$lang['nbr_70']                  = 'setenta';
$lang['nbr_80']                  = 'ochenta';
$lang['nbr_90']                  = 'noventa';
$lang['nbr_100']                 = 'cien';
$lang['nbr_200']                 = 'doscientos';
$lang['nbr_300']                 = 'trescientos';
$lang['nbr_400']                 = 'cuatrocientos';
$lang['nbr_500']                 = 'quinientos';
$lang['nbr_600']                 = 'seiscientos';
$lang['nbr_700']                 = 'setecientos';
$lang['nbr_800']                 = 'ochocientos';
$lang['nbr_900']                 = 'novecientos';
$lang['nbr_1000']                = 'mil';
$lang['nbr_1000000']             = 'millón';
$lang['nbr_1000000000']          = 'mil millones';
$lang['nbr_1000000000000']       = 'billón';
$lang['nbr_1000000000000000']    = 'cuatrillón';
$lang['nbr_1000000000000000000'] = 'trillón';


$lang['report']                    = "Informe";
$lang['reports']                   = "Informes";
$lang['report_no_data']            = "No tiene datos para este período. Por favor, ajuste la fecha";
$lang['profit']                    = "Lucro";
$lang['income']                    = "Ingresos";
$lang['spending']                  = "Gasto";
$lang['total_spending']            = "Gasto total";
$lang['outstanding_revenue']       = "Ingresos pendientes";
$lang['total_outstanding']         = "Completo destaque";
$lang['total_profit']              = "Beneficio total";
$lang['total_profit']              = "Beneficio total";
$lang['accounts_aging']            = "Cuentas de Envejecimiento";
$lang['accounts_aging_subheading'] = "Averigüe cuáles son los clientes que tardan mucho tiempo en pagar";
$lang['no_aging_accounts']         = "No se han encontrado clientes vencidos. Por favor, ajuste la fecha.";
$lang['as_of']                     = "A partir de";
$lang['aging_age1']                = "00 - 30 días";
$lang['aging_age2']                = "31 - 60 días";
$lang['aging_age3']                = "61 - 90 días";
$lang['aging_age4']                = "Más de 90 días";
$lang['from']                      = "De";
$lang['to']                        = "A";
$lang['revenue_by_customer']       = "Ingresos por cliente";
$lang['invoice_details']           = "Detalles de la factura";
$lang['total_revenue']             = "Los ingresos totales";
$lang['total_invoiced']            = "Total de facturas";
$lang['total_due']                 = "Total debido";
$lang['total_paid']                = "Total pagado";
$lang['summary']                   = "Resumen";
$lang['tax_summary']               = "Resumen de impuestos";
$lang['tax_name']                  = "Nombre del impuesto";
$lang['taxable_amount']            = "Base imponible";
$lang['net']                       = "Red";
$lang['profit_loss']               = "Ganancias y pérdidas (gráficos)";
$lang['profit_loss_subheading']    = "Ayuda a determinar lo que debe en impuestos y si está haciendo más de lo que está gastando";
$lang['tax_summary_subheading']    = "Ayuda a determinar cuánto debe al gobierno en Impuestos sobre ventas";
$lang['invoice_det_subheading']    = "Un resumen detallado de todas las facturas que ha enviado durante un período de tiempo";
$lang['revenue_cust_subheading']   = "Ingresos clasificados por el cliente durante un período de tiempo específico";


$lang['chat']                      = "Charla";
$lang['chat_new_message_from']     = "Nuevo mensaje";
$lang['online']                    = "En línea";
$lang['offline']                   = "Desconectado";
$lang['delete_conversation']       = "Eliminar la conversación";
$lang['type_your_message']         = "Escribe tu mensaje ...";
$lang['support']                   = "Apoyo";
$lang['chat_support_label']        = "Nombre de soporte";
$lang['chat_support_id']           = "Administrador de soporte";

$lang['tools']                     = "Herramientas";
$lang['low']                       = "Bajo";
$lang['medium']                    = "Medio";
$lang['high']                      = "Alto";
$lang['todo_task']                 = "Tarea a hacer";
$lang['todo_list']                 = "Lista de quehaceres";
$lang['priority']                  = "Prioridad";
$lang['mark_as_complete']          = "Marcar como completo";
$lang['create_todo']               = "Crear nueva tarea";
$lang['edit_todo']                 = "Editar tarea";
$lang['todo_add_success']          = "Tarea creada con éxito";
$lang['todo_edit_success']         = "Tarea correctamente actualizada";
$lang['todo_complete_success']     = "Tarea completada con éxito";
$lang['todo_delete_success']       = "Tarea eliminada correctamente";

$lang['calculator']                = "Calculadora";

$lang['calendar']                  = "Calendario de recordatorios";
$lang['calendar_subheading']       = "Haga clic en la fecha para añadir / modificar un recordatorio.";
$lang['create_reminder']           = "Crear recordatorio de correo electrónico";
$lang['create_reminder_subheading']= "Para agregar un nuevo recordatorio, ingrese la información a continuación.";
$lang['edit_reminder']             = "Actualizar recordatorio de correo electrónico";
$lang['edit_reminder_subheading']  = "Para editar este recordatorio, ingrese la información a continuación.";
$lang['reminder_add_success']      = "Recordatorio creado correctamente";
$lang['reminder_edit_success']     = "Recordatorio actualizado correctamente";
$lang['reminder_delete_success']   = "Recordatorio eliminado correctamente";
$lang['reminder_for']              = "Recordatorio para ";
$lang['repeat']                    = "Repetir";
$lang['repeat_every']              = "Repite cada";
$lang['end_date']                  = "Fecha final";
$lang['no_end']                    = "Sin fin";
$lang['no_repeat']                 = "Sin repetir";
$lang['reminder_subject']          = "Asunto del email";
$lang['reminder_content']          = "Contenido del correo electrónico";
$lang['untitled_reminder']         = "Recordatorio sin título";

$lang['notifications']             = "Notificaciones";
$lang['no_notifications']          = "0 Notificaciones";

$lang['exchange']                  = "Cambio de divisas";
$lang['exchange_subheading']       = "Cambio entre las tasas de cambio";
$lang['result']                    = "Resultado";
$lang['change']                    = "Cambio";
$lang['not_supported']             = "No soportado";


$lang['permission']                = "Permiso";
$lang['permissions']               = "Permisos";
$lang['members_permission']        = "Permisos de los miembros";
$lang['posts_level_permission']    = "Puestos de permisos de nivel";
$lang['posts_level_permission_p']  = "especificar qué posts los miembros pueden leer y editar";
$lang['posts_tip']                 = "Puestos son facturas, Ruccuring facturas, estimaciones, gastos, contratos";
$lang['read_his_posts']            = "Leer y editar publicaciones creadas por el miembro";
$lang['read_all_posts']            = "Leer y editar todos los mensajes";

$lang['customer_permission']       = "Permisos de los clientes";
$lang['customer_pay_methods']      = "Métodos de pago";
$lang['customer_pay_methods_p']    = "especificar qué métodos de pago pueden pagar los clientes con";
$lang['customer_pay_methods_tip']  = "Métodos fuera de línea (Efectivo, Cheque, Transferencia bancaria, otros), Métodos en línea: (Paypal, Stripe, 2Checkout ...)";
$lang['use_all_pay_methods']       = "Utilice todos los métodos de pago (Online y Offline)";
$lang['use_offline_pay_methods']   = "Usar métodos de pago sin conexión";


$lang['link']                           = "Enlazar";
$lang['overdue_days']                   = "Días atrasados";
$lang['update_email_template']          = "Actualizar plantilla de correo electrónico";
$lang['email_template_updated']         = "La plantilla de correo electrónico se actualiza con éxito";
$lang['template_name']                  = "Nombre de la plantilla";
$lang['template']                       = "Modelo";
$lang['templates']                      = "Plantillas";
$lang['activation_code']                = "Código de activación";
$lang['forgotten_password_code']        = "Código de contraseña olvidado";
$lang['send_invoices_to_customer']  = "Enviar facturas al cliente";
$lang['send_receipts_to_customer']  = "Enviar recibos al cliente";
$lang['send_rinvoices_to_customer'] = "Enviar facturas recurrentes al cliente";
$lang['send_estimates_to_customer'] = "Enviar estimaciones al cliente";
$lang['send_contracts_to_customer'] = "Enviar contratos al cliente";
$lang['send_customer_reminder']     = "Enviar recordatorio al cliente";
$lang['send_overdue_reminder']      = "Enviar recordatorio vencido";
$lang['send_forgotten_password']    = "Enviar contraseña olvidada";
$lang['send_activate']              = "Enviar código de activación de cuenta";
$lang['send_activate_customer']     = "Enviar código de activación de cuenta de cliente";
$lang['send_file']                  = "Enviar archivo";


$lang['customize_template']           = "Personalizar plantilla";
$lang['blank']                        = "Blanco";
$lang['customize']                    = "Personalizar";
$lang['font_size']                    = "Tamaño de fuente";
$lang['margin']                       = "Margen";
$lang['tables']                       = "Mesas";
$lang['bordered']                     = "Confinado";
$lang['striped']                      = "A rayas";
$lang['line_th_height']               = "Altura del encabezado";
$lang['line_td_height']               = "Altura de filas";
$lang['line_th_bg']                   = "Partida de fondo";
$lang['line_th_color']                = "Título de color del texto";
$lang['monocolor']                    = "Monocolor";
$lang['grayscale']                    = "Escala de grises";
$lang['background']                   = "Fondo";
$lang['color']                        = "Color";
$lang['image']                        = "Imagen";
$lang['position']                     = "Posición";
$lang['fit']                          = "Ajuste";
$lang['opacity']                      = "Opacidad";
$lang['bg_color']                     = "Color de fondo";
$lang['txt_color']                    = "Color de texto";
$lang['stamp']                        = "Sello";
$lang['select_color']                 = "Seleccionar el color";



// projects
$lang['project']                      = "Proyecto";
$lang['projects']                     = "Proyectos";
$lang['projects_subheading']          = "Utilice la tabla a continuación para navegar o filtrar los resultados.";
$lang['create_project']               = "Crear nuevo proyecto";
$lang['create_project_subheading']    = "Para crear un nuevo proyecto, ingrese la información a continuación.";
$lang['edit_project']                 = "Editar proyecto";
$lang['edit_project_subheading']      = "Para editar este proyecto, ingrese la información a continuación.";
$lang['project_add_success']          = "Proyecto creado exitosamente";
$lang['project_edit_success']         = "Proyecto actualizado con éxito";
$lang['project_deleted']              = "Proyecto eliminado exitosamente";
$lang['cant_delete_project']          = "¡No puedes borrar este proyecto!";
$lang['project_name']                 = "Nombre del proyecto";
$lang['billing_type']                 = "Tipo de facturación";
$lang['total_rate']                   = "Tasa total";
$lang['rate_per_hour']                = "Índice por hora";
$lang['estimated_hours']              = "Horas estimadas";
$lang['not_started']                  = "No empezado";
$lang['in_progress']                  = "En progreso";
$lang['on_hold']                      = "En espera";
$lang['fixed_rate']                   = "Tipo de interés fijo";
$lang['project_hours']                = "Horas del proyecto";
$lang['task_hours']                   = "Horas de tarea";
$lang['deadline']                     = "Fecha tope";
$lang['members']                      = "Miembros";
$lang['progress']                     = "Progreso";
$lang['task']                         = "Tarea";
$lang['tasks']                        = "Tareas";
$lang['tasks_list']                   = "Lista de tareas";
$lang['testing']                      = "Testing";
$lang['complete']                     = "Completar";
$lang['create_task']                  = "Crear nueva tarea";
$lang['edit_task']                    = "Editar tarea";
$lang['task_add_success']             = "Tarea creada correctamente";
$lang['task_edit_success']            = "Tarea actualizada correctamente";
$lang['task_complete_success']        = "Tarea completada con éxito";
$lang['task_delete_success']          = "Tarea eliminada correctamente";
$lang['project_progress']             = "Progreso del proyecto";
$lang['project_informations']         = "Información del proyecto";
$lang['not_completed_tasks']          = "Tareas no completadas";
$lang['days_left']                    = "Quedan días";
$lang['overview']                     = "Visión de conjunto";
$lang['hour_rate']                    = "Tasa de horas";
$lang['hour']                         = "Hora";


$lang['partial_invoices']                = "Facturas parciales";
$lang['partial_invoices_subheading']     = "Utilice la tabla siguiente para navegar o filtrar los resultados.";
$lang['paid_amount']                     = "Monto de pago";
$lang['amount_due']                      = "Cantidad debida";
$lang['payment_date']                    = "Fecha de pago";
$lang['rate']                            = "Tarifa";
$lang['activate_double_currency']        = "Activar la opción de doble moneda";
$lang['filter_customer']                 = "Filtrar por cliente";
$lang['customer_suggestion_placeholder'] = "Sugerencia del cliente";
$lang['daterange']                       = "Rango de fechas";
$lang['filtering']                       = "Filtración";
$lang['partial_invoice_details']         = "Detalles de la factura parcial";
$lang['partial_invoice_det_subheading']  = "Un resumen detallado de las facturas parciales que ha enviado durante un período de tiempo";
$lang['cost_per_supplier']               = "Costos por proveedor";
$lang['cost_per_supplier_subheading']    = "Costos categorizados por proveedor en un período de tiempo específico";
$lang['tasks_progress']                  = "Progreso de tareas";
$lang['filter_supplier']                 = "Filtro de proveedores";
$lang['supplier_suggestion_placeholder'] = "Sugerencia del proveedor";
$lang['exchange_api']                    = "API de Exchange";
$lang['create_an_account']               = "Crea una cuenta";
$lang['generates_an_api_key']            = "y genera una clave API";


?>
