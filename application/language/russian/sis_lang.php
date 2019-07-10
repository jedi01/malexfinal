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
$lang['lang']                             = "ru";
$lang['site_title_head']                  = 'Система Smart Invoice';
$lang['site_title']                       = 'Система Smart <span class="bold">Invoice</span>';
$lang['is_demo']                          = "Это демонстрационная версия, вы не можете запускать все параметры";
$lang['remove_install_file']              = "Для обеспечения безопасности программы удалите установочный файл \ &quot;install.php \&quot; из основной папки";

$lang['invoice']                          = 'Выставленный счет';
$lang['invoices']                         = 'Счета-фактуры';
$lang['invoices_subheading']              = 'Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтра результатов.';
$lang['reference']                        = 'Справка';
$lang['date']                             = 'Дата';
$lang['date_due']                         = 'Срок';
$lang['valid_till']                       = 'Годен до';
$lang['status']                           = 'Положение дел';
$lang['invoice_note']                     = "Счет-фактура";
$lang['invoice_terms']                    = "Условия счета";
$lang['total']                            = 'Всего';
$lang['actions']                          = 'действия';
$lang['details']                          = 'Детали';
$lang['delete']                           = 'Удалить';
$lang['edit']                             = 'редактировать';
$lang['duplicate']                        = 'дублировать';
$lang['refresh']                          = 'обновление';
$lang['filter']                           = 'Фильтр';
$lang['yes']                              = 'да';
$lang['no']                               = 'нет';
$lang['ok']                               = 'ОК';
$lang['cancel']                           = "Отмена";
$lang['clear']                            = "Очистить";
$lang['save']                             = "Сохранить";
$lang['next']                             = "следующий";
$lang['previous']                         = "предыдущий";
$lang['confirmation']                     = 'подтверждение';
$lang['alert_confirmation']               = 'Вы хотите подтвердить это действие. Нажмите ДА, чтобы продолжить, или НЕТ, чтобы вернуться назад';
$lang['name']                             = 'имя';
$lang['description']                      = 'Описание';
$lang['show_description']                 = 'Покажите описание';

$lang["system"]                           = 'система';
$lang['create_invoice']                   = 'Создать счет-фактуру';
$lang['edit_invoice']                     = "Изменить счет-фактуру";
$lang['create_invoice_subheading']        = "Чтобы создать новый счет-фактуру, введите следующую информацию.";
$lang['edit_invoice_subheading']          = "Чтобы изменить этот счет, введите информацию ниже.";
$lang['preview_invoice_error']            = "Чтобы просмотреть этот счет, введите всю необходимую информацию.";
$lang['invoice_title']                    = "Название счета";
$lang['invoice_description']              = "Введите счет-фактуру ...";
$lang['basic_informations']               = "Основные сведения";
$lang['contact_informations']             = "Контактная информация";
$lang['account_informations']             = "Информация об учетной записи";
$lang['additional_informations']          = "Дополнительная информация";
$lang['attn']                             = "Вниманию";
$lang['company']                          = "Компания";
$lang['company_name']                     = "Название компании";
$lang['fullname']                         = "Полное имя";
$lang['contact_name']                     = "Контактное лицо";
$lang['phone']                            = "Телефон";
$lang['email']                            = "Эл. адрес";
$lang['address']                          = "Адрес";
$lang['percent']                          = "Процент (%)";
$lang['flat']                             = "Квартира ($)";
$lang['off']                              = "от";
$lang['invoice_setting']                  = "Настройки счета";
$lang['currency']                         = "валюта";
$lang['tax_type']                         = "Тип налога";
$lang['discount_type']                    = "Тип скидки";
$lang['tax']                              = "налог";
$lang['taxes']                            = "налоги";
$lang['discount']                         = "скидка";
$lang['discounts']                        = "Скидки";
$lang['total_due']                        = "Общая сумма";
$lang['issued_on']                        = "Выпущено";
$lang['issued_date']                      = "Дата выпуска";

$lang['all_invoices']                     = "Все счета-фактуры";
$lang['unpaid']                           = "неоплаченный";
$lang['paid']                             = "оплаченный";
$lang['partial']                          = "частичный";
$lang['due']                              = "В связи";
$lang['overdue']                          = "просроченный";
$lang['canceled']                         = "отменен";
$lang['draft']                            = "Проект";

$lang['due_receipt']                      = "-";
$lang['after_7_days']                     = "Через 7 дней";
$lang['after_15_days']                    = "Через 15 дней";
$lang['after_30_days']                    = "Через 30 дней";
$lang['after_45_days']                    = "Через 45 дней";
$lang['after_60_days']                    = "Через 60 дней";
$lang['custom']                           = "Пользовательская дата";

$lang['more']                             = "Больше ...";
$lang['add']                              = "Добавить";
$lang['quantity']                         = "Количество";
$lang['unit_price']                       = "Цена за единицу";
$lang['add_row']                          = "Добавить ряд";
$lang['subtotal']                         = "Промежуточный итог";
$lang['global_tax']                       = "Глобальный налог";
$lang['global_discount']                  = "Глобальная скидка";
$lang['preview']                          = "Предварительный просмотр";
$lang['create']                           = "Создайте";
$lang['open']                             = "открыто";
$lang['invoice_no']                       = "Счет №";
$lang['invoice_items']                    = "Счета-фактуры";
$lang['n°']                               = "Н °";
$lang['code']                             = "Код";
$lang['print']                            = "Распечатать";
$lang['close']                            = "Закрыть";
$lang['title']                            = "заглавие";
$lang['system_setting']                   = "Системные настройки";
$lang['system_setting_subheading']        = "Чтобы обновить параметры системы, введите следующую информацию.";
$lang['settings_general']                 = "Настройки Общие";
$lang['settings_company']                 = "Настройки компании";
$lang['settings_invoice']                 = "Счет-фактура";
$lang['configuration_general']            = "Генеральная";
$lang['update_settings']                  = "Обновить настройки";
$lang['language']                         = "язык";
$lang['select']                           = "Выбрать";
$lang['selected']                         = "выбранный";
$lang['date_format']                      = "Формат даты";
$lang['currency_format']                  = "Формат валюты";
$lang['currency_format']                  = "Формат валюты";
$lang['default_currency']                 = "Валюта по умолчанию";
$lang['currency_place']                   = "Место для обмена валюты";
$lang['prefix_invoice']                   = "Префикс-счет-фактура";
$lang['estimate_prefix']                  = "Предпочитаемый префикс";
$lang['receipt_prefix']                   = "Префикс платежа";
$lang['contract_prefix']                  = "Префикс контракта";
$lang['expense_prefix']                   = "Префикс расходов";
$lang['invoice_next']                     = "Следующий счет-фактура";
$lang['estimate_next']                    = "Следующая оценка";
$lang['receipt_next']                     = "Следующее получение";
$lang['contract_next']                    = "Следующий контракт";
$lang['expense_next']                     = "Следующий расход";
$lang['biller_type']                      = "Тип биллера";
$lang['item_tax']                         = "Налог на предметы";
$lang['item_discount']                    = "Скидка на товары";
$lang['is_required']                      = "необходимо";
$lang['email_address']                    = "Адрес электронной почты";
$lang['city']                             = "город";
$lang['state']                            = "состояние";
$lang['postal_code']                      = "Почтовый индекс";
$lang['country']                          = "Страна";
$lang['website']                          = "ссылка на сайт";
$lang['configuration_company']            = "Компания";
$lang['update']                           = "Обновить";
$lang['logo']                             = "логотип";
$lang['perview']                          = "Предварительный просмотр";
$lang['configuration_invoice_template']   = "Шаблон счета-фактуры";
$lang['update_template']                  = "Обновить шаблон";
$lang['settings']                         = "настройки";
$lang['style']                            = "Стиль";
$lang['header']                           = "заголовок";
$lang['footer']                           = "Нижний колонтитул";
$lang['signature']                        = "Подпись";
$lang['template_configuration']           = "Конфигурация шаблонов";
$lang['default_layout']                   = "Макет по умолчанию";
$lang['default_size']                     = "Размер по умолчанию";
$lang['auto_print']                       = "Авто печать";
$lang['template_style_configuration']     = "Стиль шаблона";
$lang['font']                             = "Шрифт";
$lang['table_bordered']                   = "Граница в таблице";
$lang['table_striped']                    = "Полосатый стол";
$lang['primary_color']                    = "Основной цвет";
$lang['second_color']                     = "Вторичный цвет";
$lang['template_header_configuration']    = "Заголовок шаблона";
$lang['appearance']                       = "Внешность";
$lang['show_header']                      = "Показать спрятать";
$lang['header_bg_color']                  = "Цвет фона заголовка";
$lang['header_txt_color']                 = "Цвет текста заголовка";
$lang['template']                         = "шаблон";
$lang['header_text']                      = "Текст заголовка";
$lang['template_footer_configuration']    = "Нижний колонтитул шаблона";
$lang['show_footer']                      = "Показать спрятать";
$lang['footer_bg_color']                  = "Цвет фона нижнего колонтитула";
$lang['footer_txt_color']                 = "Цвет текста нижнего колонтитула";
$lang['footer_text']                      = "Нижний колонтитул";
$lang['template_signature_configuration'] = "Подпись шаблона";
$lang['signature_txt']                    = "Текст подписи";
$lang['order_by']                         = "Сортировать по";
$lang['title_invoice']                    = "Счёт счета";
$lang['no_zero_required']                 = "Поле% s требуется";
$lang['users']                            = 'пользователей';
$lang['dashboard']                        = 'Панель приборов';
$lang['settings_general_updated']         = "Общие настройки";
$lang['settings_company_updated']         = "Настройки компании";
$lang['invoice_template_updated']         = "Настройки шаблонов счета успешно обновлены";
$lang['invoice_add_success']              = "Перейти к началу]";
$lang['invoice_edit_success']             = "Счет успешно обновлен";
$lang['invoice_deleted']                  = "Счет успешно удален";
$lang['cant_delete_invoice']               = "Вы не можете удалить этот счет !, Потому что: <br><ul><li> Этот счет-фактура связан с другими пунктами </li></ul> Вам необходимо удалить все элементы, а затем повторить попытку";
$lang['invoice_duplicate_success']        = "Счет успешно дублирован";
$lang['access_denied']                    = "Доступ закрыт!";
$lang['language_is_changed']              = "Язык успешно изменен";
$lang['change_password']                  = "Изменить пароль";
$lang['logout']                           = "Выйти";
$lang['here']                             = "Вот";

$lang['paid_invoices']                    = "Платный счет (ы)";
$lang['unpaid_invoices']                  = "Неоплаченные счета)";
$lang['overdue_invoices']                 = "Просроченные счета)";
$lang['number_of_invoices']               = '<div class="font-weight-bold">%s</div><div class="text-muted"> <small>счета</small> - <small>фактуры</small> </div>';
$lang['last_invoices']                    = "Последние счета-фактуры";
$lang['last_invoices_subheading']         = "Показать список последних 5 созданных счетов-фактур";
$lang['overview_chart']                   = "Обзорный график";
$lang['overview_chart_subheading']        = "Круговая диаграмма, подсчитывающая счета за статус";
$lang['invoices_per_date']                = "Счета за день";
$lang['invoices_per_date_subheading']     = "Линейная диаграмма, отображающая общее количество счетов-фактур за дату";

$lang['settings_template']                = "шаблон";
$lang['defaults']                         = "Значения по умолчанию";
$lang['default_status']                   = "Статус по умолчанию";
$lang['manage_configurations']            = "Создание / обновление конфигураций";
$lang['printing_configurations']          = "Конфигурации печати";
$lang['show_invoice_status']              = "Показать статус счета";
$lang['show_total_due']                   = "Показать общую сумму";
$lang['show_payments_page']               = "Показать страницу с платежами";
$lang['note_terms_on_page']               = "Условия на странице";
$lang['enable_terms']                     = "Включить условия и условия";
$lang['payments_total']                   = "Сумма платежей";
$lang['invoice_total']                    = "Сумма счета";
$lang['description_inline']               = "Описание продукта";
$lang['description_inline_tip']           = "Показать описание продукта в той же строке с именем";

// Errors
$lang['error_csrf']                       = 'Это сообщение формы не прошло проверки безопасности.';
// Users Roles
$lang['role_superadmin']                  = 'Супер администратор';
$lang['role_admin']                       = 'администратор';
$lang['role_members']                     = 'Пользователь (участник)';
$lang['role_customer']                    = 'Клиент';
$lang['role_supplier']                    = 'поставщик';

// Login
$lang['login_heading']                    = 'Авторизоваться';
$lang['login_subheading']                 = 'Пожалуйста, войдите в систему, указав свой адрес электронной почты / имя пользователя и пароль ниже.';
$lang['login_identity_label']             = 'Email / Имя пользователя';
$lang['login_password_label']             = 'пароль';
$lang['login_remember_label']             = 'Запомни меня';
$lang['login_submit_btn']                 = 'Авторизоваться';
$lang['login_forgot_password']            = 'Забыли пароль?';

// Index
$lang['index_heading']                    = 'пользователей';
$lang['index_subheading']                 = 'Ниже содержать список пользователей.';
$lang['index_username_th']                = 'Имя пользователя';
$lang['index_name_th']                    = 'имя';
$lang['index_fname_th']                   = 'Имя';
$lang['index_lname_th']                   = 'Фамилия';
$lang['index_email_th']                   = 'Эл. адрес';
$lang['index_groups_th']                  = 'группы';
$lang['index_status_th']                  = 'Положение дел';
$lang['index_action_th']                  = 'действие';
$lang['index_active_link']                = 'активировать';
$lang['index_inactive_link']              = 'инактивировать';
$lang['index_create_user_link']           = 'Создать новый пользователь';
$lang['index_active_status']              = 'активный';
$lang['index_inactive_status']            = 'Неактивный';

// Deactivate User
$lang['deactivate_heading']                  = 'Деактивировать пользователя';
$lang['deactivate_subheading']               = "Вы действительно хотите отключить пользователя '%s'";
$lang['deactivate_confirm_y_label']          = 'да';
$lang['deactivate_confirm_n_label']          = 'нет';
$lang['deactivate_submit_btn']               = 'Отправить';
$lang['deactivate_validation_confirm_label'] = 'подтверждение';
$lang['deactivate_validation_user_id_label'] = 'Идентификатор пользователя';

// Create User
$lang['create_user_heading']                           = 'Создать пользователя';
$lang['create_user_subheading']                        = 'Пожалуйста, введите информацию пользователя ниже.';
$lang['create_user_fname_label']                       = 'Имя';
$lang['create_user_lname_label']                       = 'Фамилия';
$lang['create_user_company_label']                     = 'Название компании';
$lang['create_user_identity_label']                    = 'тождественность';
$lang['create_user_email_label']                       = 'Эл. адрес';
$lang['create_user_phone_label']                       = 'Телефон';
$lang['create_user_password_label']                    = 'пароль';
$lang['create_user_password_confirm_label']            = 'Подтвердите пароль';
$lang['create_user_submit_btn']                        = 'Создать пользователя';
$lang['create_user_validation_fname_label']            = 'Имя';
$lang['create_user_validation_lname_label']            = 'Фамилия';
$lang['create_user_validation_identity_label']         = 'тождественность';
$lang['create_user_validation_email_label']            = 'Адрес электронной почты';
$lang['create_user_validation_phone_label']            = 'Телефон';
$lang['create_user_validation_company_label']          = 'Название компании';
$lang['create_user_validation_password_label']         = 'пароль';
$lang['create_user_validation_password_confirm_label'] = 'Подтверждение пароля';

// Edit User
$lang['edit_user_heading']                           = 'Редактировать пользователя';
$lang['edit_user_subheading']                        = 'Пожалуйста, введите информацию пользователя ниже.';
$lang['edit_user_fname_label']                       = 'Имя';
$lang['edit_user_lname_label']                       = 'Фамилия';
$lang['edit_user_company_label']                     = 'Название компании';
$lang['edit_user_email_label']                       = 'Эл. адрес';
$lang['edit_user_phone_label']                       = 'Телефон';
$lang['edit_user_password_label']                    = 'пароль';
$lang['edit_user_password_confirm_label']            = 'Подтвердите пароль';
$lang['edit_user_password_help']                     = 'При смене пароля';
$lang['edit_user_groups_heading']                    = 'Член групп';
$lang['edit_user_submit_btn']                        = 'Сохранить пользователя';
$lang['edit_user_validation_fname_label']            = 'Имя';
$lang['edit_user_validation_lname_label']            = 'Фамилия';
$lang['edit_user_validation_email_label']            = 'Адрес электронной почты';
$lang['edit_user_validation_phone_label']            = 'Телефон';
$lang['edit_user_validation_company_label']          = 'Название компании';
$lang['edit_user_validation_groups_label']           = 'группы';
$lang['edit_user_validation_password_label']         = 'пароль';
$lang['edit_user_validation_password_confirm_label'] = 'Подтверждение пароля';

// Change Password
$lang['change_password_heading']                               = 'Изменить пароль';
$lang['change_password_old_password_label']                    = 'Старый пароль';
$lang['change_password_new_password_label']                    = 'Новый пароль (не менее% s)';
$lang['change_password_new_password_confirm_label']            = 'Подтвердите новый пароль';
$lang['change_password_submit_btn']                            = '+ Изменить';
$lang['change_password_validation_old_password_label']         = 'Старый пароль';
$lang['change_password_validation_new_password_label']         = 'Новый пароль';
$lang['change_password_validation_new_password_confirm_label'] = 'Подтвердите новый пароль';

// Forgot Password
$lang['forgot_password_heading']                 = 'Забыли пароль';
$lang['forgot_password_subheading']              = 'Пожалуйста, введите% s, чтобы мы могли отправить вам электронное письмо, чтобы сбросить пароль.';
$lang['forgot_password_identity_not_found']      = 'Идентичность не найдена.';
$lang['forgot_password_email_label']             = '% S:';
$lang['forgot_password_submit_btn']              = 'Отправить';
$lang['forgot_password_validation_email_label']  = 'Адрес электронной почты';
$lang['forgot_password_identity_label']          = 'Имя пользователя';
$lang['forgot_password_email_identity_label']    = 'Эл. адрес';
$lang['forgot_password_email_not_found']         = 'Нет записей этого адреса электронной почты.';

// Reset Password
$lang['reset_password_heading']                               = 'Изменить пароль';
$lang['reset_password_new_password_label']                    = 'Новый пароль (не менее% s):';
$lang['reset_password_new_password_confirm_label']            = 'Подтвердите новый пароль:';
$lang['reset_password_submit_btn']                            = '+ Изменить';
$lang['reset_password_validation_new_password_label']         = 'Новый пароль';
$lang['reset_password_validation_new_password_confirm_label'] = 'Подтвердите новый пароль';

// Account Creation
$lang['account_creation_successful']            = 'Перейти к началу]';
$lang['account_creation_unsuccessful']          = 'Не удалось создать аккаунт';
$lang['account_creation_duplicate_email']       = 'Электронная почта уже используется или недействительна';
$lang['account_creation_duplicate_identity']    = 'Идентификация уже используется или недействительна';
$lang['account_creation_missing_default_group'] = 'Группа по умолчанию не установлена';
$lang['account_creation_invalid_default_group'] = 'Недопустимое значение имени группы по умолчанию';


// Password
$lang['password_change_successful']          = 'Пароль успешно изменен';
$lang['password_change_unsuccessful']        = 'Недействовать изменение пароля';
$lang['forgot_password_successful']          = 'Сброс электронной почты отправлен';
$lang['forgot_password_unsuccessful']        = 'Не удалось сбросить пароль';

// Activation
$lang['activate_successful']                 = 'Аккаунт активирован';
$lang['activate_unsuccessful']               = 'Не удалось активировать аккаунт';
$lang['deactivate_successful']               = 'Аккаунт деактивирован';
$lang['deactivate_unsuccessful']             = 'Не удалось деактивировать учетную запись';
$lang['activation_email_successful']         = 'Активация электронной почты отправлена. Проверьте входящие или спам';
$lang['activation_email_unsuccessful']       = 'Не удалось отправить электронную почту активации';

// Login / Logout
$lang['login_successful']                    = 'Записан';
$lang['login_unsuccessful']                  = 'Неверный логин';
$lang['login_unsuccessful_not_active']       = 'Аккаунт неактивен';
$lang['login_timeout']                       = 'Временно заблокирован. Попробуйте позже.';
$lang['logout_successful']                   = 'Успешно завершено';

// Account Changes
$lang['update_successful']                   = 'Информация об учетной записи успешно обновлена';
$lang['update_unsuccessful']                 = 'Не удалось обновить информацию об учетной записи';
$lang['delete_successful']                   = 'Пользователь удален';
$lang['delete_unsuccessful']                 = 'Не удалось удалить пользователя';

// Groups
$lang['group_creation_successful']           = 'Группа успешно создана';
$lang['group_already_exists']                = 'Имя группы уже принято';
$lang['group_update_successful']             = 'Информация о группе обновлена';
$lang['group_delete_successful']             = 'Группа удалена';
$lang['group_delete_unsuccessful']           = 'Не удалось удалить группу';
$lang['group_delete_notallowed']             = 'Не удалять группу администраторов';
$lang['group_name_required']                 = 'Имя группы - обязательное поле';
$lang['group_name_admin_not_alter']          = 'Имя группы администратора не может быть изменено';

// Password Strength
$lang['pass_strength_general']               = "Пароль должен иметь:";
$lang['pass_strength_minlength']             = "At leaset {{minlength}} characters";
$lang['pass_strength_number']                = "По крайней мере, одно число";
$lang['pass_strength_capital']               = "Не менее одной заглавной буквы";
$lang['pass_strength_special']               = "По крайней мере один специальный символ";

// Emails
$lang['email_caution']                       = '<b>Внимание</b> . Ссылка может использоваться только один раз. Если вы попытаетесь перенаправить второй раз, появится ошибка. Если у вас есть какие-либо вопросы, пожалуйста, напишите нам по электронной почте';
$lang['email_automatic']                     = 'Примечание: это письмо было сгенерировано и отправлено автоматически и не требует ответа.';
$lang['email_copyright']                     = 'Copyright ©% s% s, Все права защищены.';

// Activation Email
$lang['email_activation_subject']            = 'Активация аккаунта';
$lang['email_activate_heading']              = 'Поздравляем!';
$lang['email_activate_subheading']           = 'Привет <b>% s</b> , вы успешно зарегистрировались на <i>% s</i> . <br> Чтобы активировать свою учетную запись, пожалуйста, подтвердите свою регистрацию.';
$lang['email_activate_link']                 = 'Подтверждение регистрации';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Проверка забытого пароля';
$lang['email_forgot_password_heading']       = 'Его,';
$lang['email_forgot_password_subheading']    = 'Мы получили запрос на сброс пароля. <br> Ваше имя пользователя <b>% s</b> .';
$lang['email_forgot_password_link']          = 'Сброс пароля';

// New Password Email
$lang['email_new_password_subject']          = 'Новый пароль';
$lang['email_new_password_heading']          = 'Новый пароль';
$lang['email_new_password_subheading']       = 'Ваш пароль был сброшен:';

// Invoice Email
$lang['emails']                              = 'Сообщения электронной почты';
$lang['email_to']                            = "к";
$lang['email_subject']                       = "Предмет";
$lang['email_cc']                            = "CC";
$lang['email_bcc']                           = "BCC";
$lang['show_hide_cc_bcc']                    = "Показать / скрыть CC &amp; BCC";
$lang['send_email']                          = "Отправить электронное письмо";
$lang['emails_list']                         = 'Электронная почта (ы)';
$lang['send']                                = 'послать';
$lang['additional_content']                  = 'Дополнительный контент';
$lang['emails_example']                      = 'Пример: contact@sis.com, info@sis.com ...';
$lang['email_invoice_subject']               = 'Счёт-фактура из% s';
$lang['email_invoice_heading']               = 'Приветствую!';
$lang['email_invoice_subheading']            = 'Вы получили счет-фактуру <b>% s</b> . <br> Файл PDF прилагается.';
$lang['email_successful']                    = 'Письмо отправлено. Проверьте входящие или спам';
$lang['email_unsuccessful']                  = 'Не удалось отправить электронную почту, проверьте настройки электронной почты!';


$lang['email_dear']                          = 'Уважаемые %s ,';
$lang['send_payments_reminder']              = 'Отправить напоминания о платежах';
$lang['no_unpaid_invoies']                   = "у этого клиента нет никаких неоплаченных счетов-фактур!";
$lang['email_rinvoice_subject']              = 'Новый счет-фактура %s ';
$lang['email_rinvoice_subheading']           = 'Вы получили новый неоплаченный счет %s ,';
$lang['email_unpaid_subject']                = 'У вас есть неоплаченные счета-фактуры %s ';
$lang['email_unpaid_invoices']               = 'You have <b>%s</b> unpaid invoices.';
$lang['email_overdue_subject']               = 'У вас есть просроченный счет %s ';
$lang['email_overdue_reminder']              = 'Возможно, вы пропустили дату платежа, и счет теперь просрочен %s дней.';

$lang['overdue_reminder']                    = "Просроченное напоминание";
$lang['once_is']                             = "После того, как счет-фактура";
$lang['days_late']                           = "дней поздно";
$lang['and_every']                           = "и каждый";
$lang['days_after']                          = "дней после";

/* --------------------------- DATATABLES --------------------------------------------- */
$lang['loading_data']               =   "Загрузка данных с сервера";
$lang['sEmptyTable']                =   "В таблицах нет результатов";
$lang['no_data']                    =   "Результатов не найдено!";
$lang['sInfo']                      =   "Отобразить _START _-_ END_ из _TOTAL_ строк";
$lang['sInfoEmpty']                 =   "Отображение 0 из 0 из 0 строк";
$lang['sInfoFiltered']              =   "(Отфильтровано из _MAX_ всего записей)";
$lang['sInfoPostFix']               =   "";
$lang['sInfoThousands']             =   ",";
$lang['sLengthMenu']                =   "Показать _MENU_ строки";
$lang['sLoadingRecords']            =   "Загружается ...";
$lang['sProcessing']                =   "Обработка ...";
$lang['sSearch']                    =   "Поиск";
$lang['advanced_search']            =   "Расширенный поиск";
$lang['sZeroRecords']               =   "Результатов не найдено";
$lang['sFirst']                     =   "&lt;&lt;";
$lang['sLast']                      =   "&gt;&gt;";
$lang['sNext']                      =   "&gt;";
$lang['sPrevious']                  =   "&lt;";
$lang['sSortAscending']             =   ": Включить восходящую композицию";
$lang['sSortDescending']            =   ": Включить компоновку нисходящей линии связи";
$lang['colvis_buttonText']          =   "Показать / скрыть столбцы";
$lang['colvis_sRestore']            =   "Восстановить оригинал";
$lang['colvis_sShowAll']            =   "Показать все";
$lang['tabletool_csv']              =   "Загрузить CSV";
$lang['tabletool_xls']              =   "Загрузить Excel";
$lang['tabletool_copy']             =   "копия";
$lang['tabletool_pdf']              =   "Загрузить Pdf";
$lang['tabletool_text']             =   "Загрузить текст";
$lang['tabletool_print']            =   "Распечатать";
$lang['tabletool_print_sInfo']      =   "<H6> Предварительный просмотр </ h6><p> Для печати этой таблицы можно воспользоваться печатью браузера. Нажмите Esc, когда закончите. </p>";
$lang['tabletool_print_sToolTip']   =   "Просмотр печати";
$lang['tabletool_select']           =   "Выбрать";
$lang['tabletool_select_single']    =   "Выберите Single";
$lang['tabletool_select_all']       =   "Выбрать все";
$lang['tabletool_select_none']      =   "Выбрать все";
$lang['tabletool_ajax']             =   "Кнопка Ajax";
$lang['tabletool_collection']       =   "Скачать";
$lang['export']                     =   "экспорт";
$lang['export_csv']                 =   "Экспорт в формате CSV";
$lang['export_xls']                 =   "Экспорт в Excel";
$lang['export_pdf']                 =   "Экспорт в формате PDF";
$lang['export_text']                =   "Экспорт в виде текста";
$lang['all']                        = "Все";

/* --------------------------- DATERANGE --------------------------------------------- */
$lang['daterange_today']            = "Cегодня";
$lang['daterange_yesterday']        = "Вчера";
$lang['daterange_last_7_days']      = "Последние 7 дней";
$lang['daterange_last_30_days']     = "Последние 30 дней";
$lang['daterange_this_month']       = "Этот месяц";
$lang['daterange_last_month']       = "Прошлый месяц";
$lang['daterange_this_year']        = "В этом году";
$lang['daterange_custom']           = "Пользовательский диапазон";
$lang['daterange_end_of_last_month']= "Конец прошлого месяца";
$lang['daterange_end_of_year']      = "Конец прошлого года";

$lang['error']                      = 'ошибка';
$lang['success']                    = 'успех';

// Register
$lang['register_heading']           = 'регистр';
$lang['register_subheading']        = 'Создать аккаунт';
$lang['register_ask']               = 'У вас нет учетной записи?';
$lang['register_btn']               = 'Зарегистрируйтесь сейчас!';
$lang['register_username']          = 'Имя пользователя';
$lang['register_email']             = 'Адрес электронной почты';
$lang['register_password']          = 'пароль';
$lang['register_password_confirm']  = 'Подтвердите пароль';
$lang['register_submit_btn']        = 'Регистрация';

$lang['default_group']              = 'Новая группа учетных записей';
$lang['enable_register']            = 'Включить регистр';
$lang['reference_type']             = 'Тип ссылки';
$lang['show_reference']             = 'Показать ссылки';
$lang['reference_type_changed']     = 'Тип ссылки изменен! <br> Вы хотите сбросить ссылку на все счета-фактуры на новый тип?';
$lang['generate']                   = 'генерировать';
$lang['no_invoice_items']           = 'Требуются элементы счета. Должен быть как минимум 1 элемент как минимум';


$lang["loading"]                    = 'Загружается ...';
$lang["file"]                       = 'файл';
$lang["shortcut_help"]              = 'Помощь по ярлыку';
$lang["shortcut_help_title"]        = 'Горячие клавиши';
$lang["documentations"]             = 'документация';
$lang["about"]                      = 'Около';
$lang["shortcut"]                   = 'Кратчайший путь';
$lang["main_menu"]                  = 'Главное меню';

$lang["settings_email"]             = 'Настройка электронной почты';
$lang["configuration_email"]        = 'Настройки электронной почты';
$lang["protocol"]                   = 'протокол';
$lang["smtp_crypto"]                = 'Шифрование';
$lang["smtp_host"]                  = 'SMTP-хост';
$lang["smtp_port"]                  = 'Порт SMTP';
$lang["smtp_user"]                  = 'Пользователь SMTP';
$lang["smtp_pass"]                  = 'Пароль SMTP';
$lang["mailpath"]                   = 'Путь письма';
$lang["settings_email_updated"]     = "Настройки электронной почты успешно обновлены";

// importing data
$lang['import_data']                   = "Импорт данных";
$lang['idata_title']                   = "Импорт данных";
$lang['idata_subheading']              = "Какие данные вы хотите импортировать?";
$lang['idata_upload_file']             = "Загрузить файл";
$lang['idata_upload_file_subheading']  = 'Пожалуйста, введите информацию ниже.';
$lang['idata_match_fields']            = "Поля совпадения";
$lang['idata_match_fields_subheading'] = "Адаптируйте поля в поля приложения";
$lang['idata_confirm_data']            = "Подтверждение данных";
$lang['idata_confirm_data_subheading'] = "Подтверждение и удаление данных";
$lang['idata_add_to_database']         = "Добавить в базу данных";
$lang['idata_add_to_db_subheading']    = "Добавление к базе данных и заключительный этап";
$lang['idata_customers']               = "Импорт клиентов";
$lang['idata_customers_description']   = "Импорт клиентов (имена, адреса и т. Д.)";
$lang['idata_suppliers']               = "Импорт поставщиков";
$lang['idata_suppliers_description']   = "Импорт поставщиков (имена, адреса и т. Д.)";
$lang['idata_ex_cats']                 = "Импорт категорий расходов";
$lang['idata_ex_cats_description']     = "Импорт категорий расходов (тип, ярлык)";
$lang['idata_users']                   = "Импорт пользователей";
$lang['idata_users_description']       = "Импорт пользователей (имя пользователя, пароль, электронная почта и т. Д.)";
$lang['idata_tax_rates']               = "Импорт ставок налога";
$lang['idata_tax_rates_description']   = "Импорт ставок налога (метка, стоимость и тип)";
$lang['idata_items']                   = "Импорт товаров";
$lang['idata_items_description']       = "Импорт товаров (имя, описание, цена и т. Д.)";
$lang['idata_item_cats']               = "Импорт категорий товаров";
$lang['idata_item_cats_description']   = "Импорт категорий товаров (ярлык)";


$lang['idata_info']                    = "Список полей, которые может содержать ваш файл данных. Поля, выделенные жирным шрифтом, обязательны для заполнения. Если вы импортируете данные со специальными символами (запятыми, точками с запятой и т. Д.), Убедитесь, что у вас есть эти поля с цитатой!";
$lang['idata_checklist']               = "Проверьте свой список перед импортом";
$lang['idata_file_format']             = "Формат принятых CSV-файлов (* .csv) или файлов Excel (* .xls, * .xlsx)";
$lang['idata_download_sample_file']    = "Загрузите файл примера, чтобы узнать, что мы можем импортировать.";
$lang['idata_download_sample']         = "Загрузить образец файла";
$lang['idata_csv_delimiter']           = "Сепаратор CSV";
$lang['idata_semicolon']               = "Точка с запятой";
$lang['idata_comma']                   = "запятая";
$lang['idata_tab']                     = "табуляция";
$lang['idata_file']                    = "файл";
$lang['idata_max_file_size']           = "Максимальный размер 2 МБ или 1000 строк";
$lang['idata_delete_item']             = "Удалить этот элемент";
$lang['idata_items_are_imported']      = "Элементы импортируются";
$lang['idata_item_is_imported']        = "Товар импортирован";
$lang['idata_imported']                = "Импорт данных завершен с успехом";
$lang['idata_failed']                  = "Импорт данных не удался, проверьте ваши записи снова!";
$lang['idata_no_data']                 = "Вы не вставляете никаких данных, снова проверьте свои данные!";


$lang["settings_db"]                   = 'Резервные копии';
$lang["configuration_db"]              = 'Резервные копии базы данных';
$lang["create_backup"]                 = 'Создать резервную копию';
$lang["date_creation"]                 = "Дата создания";
$lang["filename"]                      = "Имя файла";
$lang["restore_backup"]                = 'Восстановление резервной копии';
$lang["delete_backup"]                 = 'Удаление резервной копии';
$lang["restore_backup_success"]        = "Резервное копирование базы данных восстанавливается";
$lang["restore_backup_failed"]         = "Ошибка резервного копирования базы данных";
$lang["backup_deleted"]                = "Резервное копирование базы данных успешно удалено";



$lang['tax_rate']                      = "Ставка налога";
$lang['settings_tax_rates']            = "Налоговые ставки";
$lang['configuration_tax_rates']       = "Налоговые ставки";
$lang["no_tax"]                        = "Нет налога";
$lang['create_tax_rate']               = "Добавить ставку налога";
$lang['tax_rate_label']                = "Налоговый кодекс";
$lang['tax_rate_value']                = "Ставка / Сумма";
$lang['tax_rate_type']                 = "Тип налоговой ставки";
$lang['tax_rate_default']              = "Ставка налога по умолчанию";
$lang['tax_rate_new']                  = "Создать новую ставку налога";
$lang['tax_rate_update']               = "Обновить налоговую ставку";
$lang['tax_rate_added']                = "Налоговая ставка успешно добавлена";
$lang['tax_rate_updated']              = "Налоговая ставка успешно обновлена";
$lang['tax_rate_deleted']              = "Налоговая ставка успешно удалена";
$lang['condition']                     = "Состояние";
$lang['conditional_taxes']             = "Условные налоги";
$lang['conditional_taxes_subheading']  = "Добавьте ставку налога на свои должности (счет / смету) с условием промежуточного итога";
$lang['conditional_taxes_tip']         = "ex: налог на добавленную стоимость 7 $ на все счета-фактуры имеет промежуточный итог больше или равен 150 $";
$lang['is_default']                    = "По умолчанию";
$lang['default']                       = "По умолчанию";
$lang['add_tax']                       = "Добавить налог";
$lang['shipping']                      = "Перевозка";
$lang['condition_terms']               = "Условия и положения";
$lang['invoice_note']                  = "Счет-фактура";
$lang['note']                          = "Счет-фактура";
$lang['set_status']                    = "Изменить статус";
$lang['set_status_subheading']         = "Выберите новый статус этого счета";
$lang['old_status']                    = "Старый статус";
$lang['clear_filter']                  = "Очистить фильтр";
$lang['shown_columns']                 = "Активные столбцы";
$lang['number_format']                 = "Формат номера";
$lang['round_number']                  = "Круглые номера";
$lang['decimal_place']                 = "Десятичное число";
$lang['disabled']                      = "Отключено";
$lang['enabled']                       = "Включено";
$lang['apply_to_subtotal']             = "Применить к заявлению sub total";
$lang['apply_to_line']                 = "Применить к позициям";

$lang['estimate']                      = "Оценить";
$lang['estimates']                     = "оценки";
$lang['estimates_subheading']          = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['estimate_no']                   = "Оценка N °";
$lang['estimate_items']                = "Оценить предметы";
$lang['estimate_title']                = "Оценить название";
$lang['estimate_note']                 = "Оценочная записка";
$lang['create_estimate']               = "Создать оценку";
$lang['create_estimate_subheading']    = "Чтобы создать новую оценку, введите следующую информацию.";
$lang['estimate_add_success']          = "Оценка успешно создана";
$lang['edit_estimate']                 = "Изменить оценку";
$lang['edit_estimate_subheading']      = "Чтобы изменить эту оценку, введите следующую информацию.";
$lang['estimate_edit_success']         = "Оценка успешно обновлена";
$lang['estimate_deleted']              = "Оценка успешно удалена";
$lang['cant_delete_estimate']          = "Вы не можете удалить эту оценку !, причина: <br><ul><li> Эта оценка связана с другими пунктами </li></ul> Вам необходимо удалить все элементы, а затем повторить попытку";
$lang['estimate_duplicate_success']    = "Оценка успешно дублируется";
$lang['email_estimate_subject']        = "Оценка PDF из% s";
$lang['no_estimate_items']             = "Элементы оценки необходимы. Должен быть как минимум 1 элемент как минимум";
$lang['preview_estimate_error']        = "Чтобы просмотреть эту оценку, введите всю необходимую информацию.";
$lang['email_estimate_heading']        = 'Приветствую !';
$lang['email_estimate_subheading']     = 'Вы получили оценку от <b>% s</b> . <br> Файл PDF прилагается.';
$lang['convert_to_invoice']            = "Конвертировать в счет-фактуру";
$lang['sent']                          = "Отправлено";
$lang['accepted']                      = "Принято";
$lang['invoiced']                      = "Фактурная";
$lang['approve']                       = "Одобрить";
$lang['reject']                        = "отклонять";

$lang['cash']                          = "Денежные средства";
$lang['check']                         = "Проверьте";
$lang['bank_transfer']                 = "банковский перевод";
$lang['online']                        = "В сети";
$lang['other']                         = "Другие";

$lang['payment']                       = "Оплата";
$lang['payments']                      = "платежи";
$lang['payments_subheading']           = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['payments_create']               = "Создать платеж";
$lang['payments_create_subheading']    = "Чтобы создать новый платеж, пожалуйста, введите следующую информацию.";
$lang['payments_create_success']       = "Успешная оплата";
$lang['payments_edit']                 = "Изменить платеж";
$lang['payments_edit_subheading']      = "Чтобы изменить этот платеж, введите информацию ниже.";
$lang['payments_edit_success']         = "Оплата успешно обновлена";
$lang['payments_deleted']              = "Оплата успешно удалена";
$lang['payment_number']                = "Номер платежа";
$lang['payment_details']               = "Детали оплаты";
$lang['amount']                        = "Количество";
$lang['payment_method']                = "Способ оплаты";
$lang['method']                        = "метод";
$lang['total_paid']                    = "Итого";
$lang['email_payment_subject']         = "Оплата PDF из% s";
$lang['no_payment_items']              = "Платежные элементы необходимы. Должен быть как минимум 1 элемент как минимум";
$lang['preview_payment_error']         = "Чтобы просмотреть этот платеж, введите всю необходимую информацию.";
$lang['email_payment_heading']         = 'Приветствую !';
$lang['email_payment_subheading']      = 'Вы получили платеж от <b>% s</b> . <br> Файл PDF прилагается.';
$lang['payment_for']                   = "Платеж за";
$lang['set_status_payment_subheading'] = "Выберите новый статус этой платежной квитанции";

$lang['receipt']                       = "Квитанция об оплате";
$lang['receipts']                      = "Платежные чеки";
$lang['receipt_no']                    = "Получение платежа N °";
$lang['receipt_for']                   = "Получение для";
$lang['create_receipt']                = "создать квитанцию";
$lang['receipts_create']               = "Создать расписку";
$lang['receipts_create_subheading']    = "Чтобы получить новую квитанцию, введите следующую информацию.";
$lang['receipts_edit']                 = "Изменить расписку";
$lang['receipts_edit_subheading']      = "Чтобы изменить эту расписку, введите следующую информацию.";
$lang['receipts_create_success']       = "Квитанция успешно создана";
$lang['receipts_edit_success']         = "Квитанция успешно обновлена";
$lang['receipts_deleted']              = "Квитанция успешно удалена";


// PAYMENTS ONLINE
$lang['payments_online']               = "Онлайн-платежи";
$lang['general']                       = "Генеральная";
$lang['paypal']                        = "Paypal";
$lang['stripe']                        = "Stripe";
$lang['twocheckout']                   = "2Checkout";
$lang['mobilpay']                      = "MobilPay";
$lang['payments_online_requirements']  = "Этот сервер не имеет минимальных требований для оплаты онлайн-платежей!";
$lang['payments_online_enable']        = "включить";
$lang['biller_accounts']               = "Счет в биллинге";
$lang['enable']                        = "включить";
$lang['username']                      = "имя пользователя";
$lang['password']                      = "пароль";
$lang['sandbox']                       = "песочница";
$lang['enable']                        = "включить";
$lang['api_key']                       = "Апи ключ";
$lang['enable']                        = "включить";
$lang['account_number']                = "Номер аккаунта";
$lang['secretWord']                    = "Секретное слово";
$lang['merchant_id']                   = "Идентификатор продавца";
$lang['public_key']                    = "Открытый ключ";
$lang['test_mode']                     = "Тестовый режим";
$lang['panding']                       = "в ожидании";
$lang['released']                      = "Выпущенный";
$lang['active']                        = "активный";
$lang['expired']                       = "Истекший";
$lang['finished']                      = "Законченный";
$lang['payment_released']              = "Оплата успешно выпущена";
$lang['payment_canceled']              = "Оплата отменена";



$lang['credit_card']                   = "Кредитная карта";
$lang['credit_card_firstName']         = "Имя";
$lang['credit_card_lastName']          = "Фамилия";
$lang['credit_card_number']            = "Номер кредитной карты";
$lang['credit_card_expiryMonth']       = "Месяц истечения срока действия";
$lang['credit_card_expiryYear']        = "Срок годности";
$lang['credit_card_cvv']               = "CVV / CVC";

$lang["settings_po_updated"]           = "Настройки онлайн-платежей успешно обновляются";

$lang['custom_field']                  = "Пользовательское поле";
$lang['custom_fields']                 = "Настраиваемые поля";
$lang['custom_field_label']            = "Пользовательская метка поля";
$lang['custom_field_value']            = "Значение настраиваемого поля";
$lang['customer_cf']                   = "Пользовательские поля клиента";
$lang['custom_field_1']                = "Пользовательское поле1";
$lang['custom_field_2']                = "Пользовательское поле2";
$lang['custom_field_3']                = "Пользовательское поле3";
$lang['custom_field_4']                = "Пользовательское поле4";
$lang['vat_number']                    = "Номер НДС";
$lang['vat_number_placeholder']        = "Идентификационный номер НДС";



// CUSTOMERS
$lang['customer_bill_to']             = 'Законопроект о';
$lang['customer']                     = 'клиент';
$lang['customers']                    = 'клиенты';
$lang['customer_add_success']         = "Клиент успешно добавлен";
$lang['customer_edit_success']        = "Клиент успешно обновлен";
$lang['customer_deleted']             = "Клиент успешно удален";
$lang['cant_delete_customer']         = "Вы не можете удалить этого клиента !, потому что: <br><ul><li> Этот клиент связан с другим счетом </li></ul> Вы должны удалить все его счета-фактуры, а затем повторите попытку";
$lang['customers_subheading']         = 'Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.';
$lang['create_customer']              = 'Добавить клиента';
$lang['edit_customer']                = "Изменить клиент";
$lang['details_customer']             = "Информация о клиенте";
$lang['create_customer_subheading']   = "Чтобы добавить нового клиента, введите следующую информацию.";
$lang['edit_customer_subheading']     = "Чтобы изменить этот клиент, введите информацию ниже.";
$lang['profile_customer']             = "Профиль клиента";
$lang['profile']                      = "Профиль";
$lang['edit_customer_account']        = "Редактировать аккаунт";
$lang['create_customer_account']      = "Регистрация";
$lang['account_created']              = "Учетная запись клиента успешно создана";
$lang['account_username']             = "Имя учетной записи";
$lang['account_status']               = "Статус аккаунта";


// SUPPLIERS
$lang['supplier_bill_to']             = 'Билл от';
$lang['supplier']                     = 'поставщик';
$lang['suppliers']                    = 'Поставщики';
$lang['supplier_add_success']         = "Поставщик успешно добавлен";
$lang['supplier_edit_success']        = "Поставщик успешно обновлен";
$lang['supplier_deleted']             = "Поставщик успешно удален";
$lang['cant_delete_supplier']         = "Вы не можете удалить этого поставщика !, причина: <br><ul><li> Этот поставщик связан с другим счетом </li></ul> Вы должны удалить все его счета-фактуры, а затем повторите попытку";
$lang['suppliers_subheading']         = 'Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.';
$lang['create_supplier']              = 'Добавить поставщика';
$lang['edit_supplier']                = "Изменить поставщика";
$lang['details_supplier']             = "Информация о поставщике";
$lang['create_supplier_subheading']   = "Чтобы добавить нового поставщика, введите следующую информацию.";
$lang['edit_supplier_subheading']     = "Чтобы отредактировать этого поставщика, введите следующую информацию.";

// ITEMS
$lang['item']                     = 'Пункт';
$lang['items']                    = "Предметы";
$lang['price']                    = 'Цена';
$lang['default_tax']              = 'Налог по умолчанию';
$lang['default_discount']         = 'Скидка по умолчанию';
$lang['item_add_success']         = "Элемент успешно добавлен";
$lang['item_edit_success']        = "Товар успешно обновлен";
$lang['item_deleted']             = "Элемент успешно удален";
$lang['cant_delete_item']         = "Вы не можете удалить этот элемент!, Потому что: <br><ul><li> Этот элемент связан с другим счетом </li></ul> Вам нужно удалить все его счета-фактуры, а затем повторить попытку";
$lang['items_subheading']         = 'Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.';
$lang['create_item']              = 'Добавить элемент';
$lang['edit_item']                = "Изменить элемент";
$lang['details_item']             = "Детали товара";
$lang['create_item_subheading']   = "Чтобы добавить новый элемент, введите информацию ниже.";
$lang['edit_item_subheading']     = "Чтобы изменить этот элемент, введите информацию ниже.";
$lang['prices']                   = "Цены";
$lang['unit']                     = "Ед. изм";
$lang['add_new_price']            = "Добавить новую цену";
$lang['no_item_prices']           = "Цены товара требуются. Должна быть как минимум 1 цена за этот товар как минимум";
$lang['category']                 = "категория";
$lang['categories']               = "категории";
$lang['items_categories']         = "категории";
$lang['category_create']          = "Создать новую категорию";
$lang['category_update']          = "Обновить категорию";
$lang['category_added']           = "Категория успешно добавлена";
$lang['category_updated']         = "Категория успешно обновлена";
$lang['category_deleted']         = "Категория успешно удалена";


$lang['invoices_activities']      = "Операции с счетами";
$lang['estimates_activities']     = "Оценка деятельности";
$lang['activities']               = "мероприятия";


$lang['files']                    = "файлы";
$lang['files_subheading']         = "Files_subheading";
$lang['file_rename']              = "Переименуйте файл / папку";
$lang['create_folder']            = "Создать папку";
$lang['file_move_to']             = "Переехать";
$lang['files_view']               = "предварительный просмотр";
$lang['files_share']              = "Поделиться";
$lang['file_deleted']             = "Удаленный файл";
$lang['file_moved_trash']         = "Файл успешно перемещен в корзину";
$lang['file_restored']            = "Файл успешно восстановлен";
$lang['cant_delete_file']         = "Вы не можете удалить этот файл!";
$lang['file_rename_success']      = "Файл / папка успешно переименована";
$lang['file_moved_success']       = "Файл / папка успешно перемещена";
$lang['create_folder_success']    = "Папка успешно создана";
$lang['filename']                 = "Имя файла";
$lang['size']                     = "Размер";
$lang['file_type']                = "Тип файла";
$lang['upload_date']              = "Дата загрузки";
$lang['gohome']                   = "Иди домой";
$lang['goback']                   = "Возвращаться";
$lang['open_trash']               = "Открыть корзину";
$lang['delete_definitive']        = "Удалить окончательный";
$lang['restore_file']             = "Восстановить файл";
$lang['grid']                     = "Вид сетки";
$lang['list']                     = "Посмотреть список";
$lang['sort']                     = "Сортировать";
$lang['upload']                   = "Загрузить";
$lang['share']                    = "Поделиться";
$lang['copylink']                 = "Копировать ссылку";
$lang['copy']                     = "копия";
$lang['move_to']                  = "Перейдите к";
$lang['move']                     = "Переехать";
$lang['rename']                   = "переименовывать";
$lang['foldername']               = "Имя папки";
$lang['folder']                   = "скоросшиватель";
$lang['text_is_copied']           = "Текст скопирован в буфер обмена";
$lang['no_file_selected']         = "Файл не выбран для загрузки!";
$lang['browse_files']             = "Просмотр файлов";
$lang['confirm']                  = "подтвердить";
$lang['dimensions']               = "Габаритные размеры";
$lang['duration']                 = "продолжительность";
$lang['crop']                     = "урожай";
$lang['rotate']                   = "Поворот";
$lang['choose']                   = "выберите";
$lang['to_upload']                = "загружать";
$lang['files_were']               = "файлы были";
$lang['file_was']                 = "файл был";
$lang['chosen']                   = "выбранный";
$lang['drag_drop_file']           = "Перетащите файлы здесь.";
$lang['or']                       = "или";
$lang['drop_file']                = "Отбросьте файлы здесь, чтобы загрузить";
$lang['paste_file']               = "Вставка файла, нажмите здесь, чтобы отменить.";
$lang['remove_confirmation']      = "Вы действительно хотите удалить этот файл?";
$lang['folder']                   = "скоросшиватель";
$lang['filesLimit']               = "Только %s файлы могут быть загружены.";
$lang['filesType']                = "Только %s файлы могут быть загружены.";
$lang['fileSize']                 = "слишком велико! Выберите файл до %s MB.";
$lang['filesSizeAll']             = "Файлы, которые вы выбрали, слишком велики! Загрузите файлы до %s MB.";
$lang['fileName']                 = "Файл с именем %s уже выбран. &#39;";
$lang['folderUpload']             = "Вы не можете загружать папки.";
$lang['no_more_space']            = "Больше не нужно загружать файлы!";
$lang['add_attached_file']        = "Прикрепить файл";
$lang['uploader']                 = "документы";
$lang['settings_files']           = "Настройки загрузчика";
$lang['configuration_files']      = "Загрузка файлов конфигурации";
$lang['file_upload_enable']       = "включить загрузку файлов";
$lang['user_disc_space']          = "Пользовательское пространство на диске";
$lang['user_disc_space_tip']      = "Сколько места на всех файлах пользователей разрешено брать на вашем сервере (в мегабайтах).";
$lang['max_upload_size']          = "Максимальный размер загрузки";
$lang['max_upload_size_tip']      = "Максимальный размер файла, который пользователи могут загружать (в мегабайтах).";
$lang['max_simult_uploads']       = "Максимальная одновременная загрузка.";
$lang['max_simult_uploads_tip']   = "Сколько файлов пользователь может загрузить одновременно.";
$lang['white_list']               = "Белый список";
$lang['white_list_tip']           = "Пользователи смогут загружать файлы только с этими форматами. Пример: mp4, jpg, mp3, pdf.";
$lang["settings_files_updated"]   = "Настройки файлов успешно обновлены";

$lang['send_link_via_email']      = "Отправить ссылку по электронной почте";
$lang['links']                    = "связи";
$lang['view_link']                = "Просмотреть ссылку";
$lang['direct_link']              = "Прямая ссылка";
$lang['download_link']            = "Ссылка для скачивания";
$lang['html_embed_code']          = "Код встраивания HTML";
$lang['forum_embed_code']         = "Код встраивания форума";
$lang['email_file_subject']       = "Файл из %s ";

$lang['folder']                   = "скоросшиватель";
$lang['folder']                   = "скоросшиватель";
$lang['folder']                   = "скоросшиватель";
$lang['folder']                   = "скоросшиватель";
$lang['folder']                   = "скоросшиватель";


// RECURRING INVOICES
$lang['rinvoice']                      = "Повторяющийся счет-фактура";
$lang['rinvoices']                     = "Повторяющиеся счета-фактуры";
$lang['rinvoices_subheading']          = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['recu_invoice_schedule']         = "Периодическое расписание выставления счетов";
$lang['frequency']                     = "частота";
$lang['every']                         = "каждый";
$lang['occurences']                    = "вхождений";
$lang['daily']                         = "Ежедневно";
$lang['weekly']                        = "еженедельно";
$lang['monthly']                       = "ежемесячно";
$lang['yearly']                        = "каждый год";
$lang['day']                           = "День";
$lang['days']                          = "дней";
$lang['week']                          = "Неделю";
$lang['weeks']                         = "Недели";
$lang['month']                         = "Месяц";
$lang['months']                        = "Месяцы";
$lang['year']                          = "Год";
$lang['years']                         = "лет";
$lang['recu_when_start']               = "Когда начнется автоматическое расписание?";
$lang['recu_when_create']              = "Когда будут созданы счета-фактуры?";
$lang['invoice_will_every']            = "Счет будет создан каждый";
$lang['on']                            = "на";
$lang['on_the']                        = "на";
$lang['forever']                       = "навсегда";
$lang['for']                           = "для";
$lang['occurence_time']                = "1 раз";
$lang['occurence_times']               = "раз";
$lang['recurring_effective']           = "Рециркуляция эффективна";
$lang['package_name']                  = "Имя пакета";
$lang['create_rinvoice']               = "Создать повторяющийся счет-фактуру";
$lang['create_rinvoice_subheading']    = "Чтобы создать новый повторяющийся счет, введите следующую информацию.";
$lang['rinvoice_is_canceled']          = "Этот повторяющийся счет отменяется, вы не можете редактировать!";
$lang['edit_rinvoice']                 = "Изменить повторяющийся счет-фактуру";
$lang['edit_rinvoice_subheading']      = "Чтобы изменить этот повторяющийся счет, введите информацию ниже.";
$lang['rinvoices_activities']          = "Периодические счета-фактуры";
$lang['rinvoice_add_success']          = "Повторяющийся счет-фактура успешно создан";
$lang['rinvoice_edit_success']         = "Повторяющийся счет-фактура успешно обновлен";
$lang['rinvoice_deleted']              = "Повторяющийся счет-фактура успешно удален";
$lang['cant_delete_rinvoice']          = "Вы не можете удалить этот повторяющийся счет-фактуру !, потому что: <br><ul><li> Этот повторяющийся счет-фактура связан с другими товарами </li></ul> Вы должны удалить все элементы, затем повторите попытку";
$lang['rinvoice_duplicate_success']    = "Повторяющийся счет-фактура успешно дублируется";
$lang['rinvoice_started']              = "Повторный профиль счета успешно запущен";
$lang['rinvoice_canceled']             = "Повторяющийся профиль счета отменен";
$lang['rinvoice_skipped']              = "Повторяющийся счет-фактура успешно пропустил следующий счет-фактуру";
$lang['start_profile']                 = "Начало профиля";
$lang['cancel_profile']                = "Отменить профиль";
$lang['skip_next_invoice']             = "Пропустить следующий счет-фактуру";
$lang['scheduled']                     = "Запланированное";
$lang['skipped']                       = "Пропущенные";
$lang['this_invoice_skipped']          = "Этот счет-фактура пропущен";
$lang['next_billing_date']             = "Следующая дата выставления счета";
$lang['today']                         = "Cегодня";
$lang['cronjob_desactivated']          = "чтобы включить повторяющиеся счета-фактуры, вы должны добавить эту команду %s на работе cron в вашей CPanel";
$lang['rinvoice_draft']                = "Сохранять счет-фактуру в виде черновика в каждом случае";
$lang['rinvoice_sent']                 = "Прямой почтовый счет для клиента в каждом случае";


// contracts
$lang['contract']                      = "контракт";
$lang['contracts']                     = "контракты";
$lang['contracts_subheading']          = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['create_contract']               = "Создать новый контракт";
$lang['create_contract_subheading']    = "Чтобы создать новый Контракт, введите следующую информацию.";
$lang['edit_contract']                 = "Изменить контракт";
$lang['edit_contract_subheading']      = "Для редактирования этого Контракта, пожалуйста, введите следующую информацию.";
$lang['contract_add_success']          = "Контрактный счет успешно создан";
$lang['contract_edit_success']         = "Контрактный счет успешно обновлен";
$lang['contract_deleted']              = "Контрактный счет успешно удален";
$lang['cant_delete_contract']          = "Вы не можете удалить этот Контракт!, Потому что: <br><ul><li> Этот повторяющийся счет-фактура связан с другими товарами </li></ul> Вы должны удалить все элементы, затем повторите попытку";
$lang['subject']                       = "Предмет";
$lang['contract_type']                 = "Форма контракта";
$lang['contract_value']                = "Стоимость контракта";
$lang['contract_description']          = "Описание контракта по умолчанию";
$lang['email_contract_subject']        = "Договор PDF от %s ";
$lang['email_contract_heading']        = 'Приветствую !';
$lang['email_contract_subheading']     = 'Вы получили контракт от %s , <br> Файл PDF прилагается.';


// Expenses
$lang['expense']                       = "расходы";
$lang['expenses']                      = "Затраты";
$lang['expenses_subheading']           = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['expenses_create']               = "Создать новый расход";
$lang['expenses_create_subheading']    = "Чтобы создать новый Расчёт, введите информацию ниже.";
$lang['expenses_edit']                 = "Изменить расход";
$lang['expenses_edit_subheading']      = "Чтобы изменить этот Расчёт, введите информацию ниже.";
$lang['expenses_create_success']       = "Эффект успешно создан";
$lang['expenses_edit_success']         = "Расходы успешно обновлены";
$lang['expenses_deleted']              = "Затраты успешно удалены";
$lang['category']                      = "категория";
$lang['attachments']                   = "Вложения";
$lang['download_attachments']          = "Загрузить приложения";
$lang['invoice_number']                = "Номер счета";
$lang['expense_number']                = "Номер расхода";
$lang['expenses_category']             = "категория";
$lang['expenses_categories']           = "категории";
$lang['expenses_subheading']           = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['expenses_category_create']      = "Создать новую категорию";
$lang['expenses_category_update']      = "Изменить категорию";
$lang['expenses_category_added']       = "Категория успешно создана";
$lang['expenses_category_updated']     = "Категория успешно обновлена";
$lang['expenses_category_deleted']     = "Категория успешно удалена";
$lang['expenses_category_type']        = "Тип";
$lang['expenses_category_label']       = "метка";
$lang['expense_no']                    = "Расход N °";



$lang['amount_in_words']         = 'Сумма прописью';
$lang['nbr_conjunction']         = 'а также';
$lang['nbr_negative']            = 'отрицательный';
$lang['nbr_decimal']             = 'точка';
$lang['nbr_separator']           = ', ';
$lang['nbr_inversed']            = false;
$lang['nbr_0']                   = 'нуль';
$lang['nbr_1']                   = 'один';
$lang['nbr_2']                   = 'два';
$lang['nbr_3']                   = 'три';
$lang['nbr_4']                   = 'печь';
$lang['nbr_5']                   = 'пять';
$lang['nbr_6']                   = 'шесть';
$lang['nbr_7']                   = 'семь';
$lang['nbr_8']                   = 'восемь';
$lang['nbr_9']                   = 'девять';
$lang['nbr_10']                  = 'десять';
$lang['nbr_11']                  = 'одиннадцать';
$lang['nbr_12']                  = 'двенадцать';
$lang['nbr_13']                  = 'тринадцать';
$lang['nbr_14']                  = 'четырнадцать';
$lang['nbr_15']                  = 'пятнадцать';
$lang['nbr_16']                  = 'шестнадцать';
$lang['nbr_17']                  = 'семнадцать';
$lang['nbr_18']                  = 'восемнадцать';
$lang['nbr_19']                  = 'девятнадцать';
$lang['nbr_20']                  = 'двадцать';
$lang['nbr_30']                  = 'тридцать';
$lang['nbr_40']                  = 'сорок';
$lang['nbr_50']                  = 'пятьдесят';
$lang['nbr_60']                  = 'шестьдесят';
$lang['nbr_70']                  = 'семьдесят';
$lang['nbr_80']                  = 'восемьдесят';
$lang['nbr_90']                  = 'девяносто';
$lang['nbr_100']                 = 'сто';
$lang['nbr_200']                 = 'двести';
$lang['nbr_300']                 = 'три сотни';
$lang['nbr_400']                 = 'четыре сотни';
$lang['nbr_500']                 = 'пятьсот';
$lang['nbr_600']                 = 'шестьсот';
$lang['nbr_700']                 = 'семь сотен';
$lang['nbr_800']                 = 'восемьсот';
$lang['nbr_900']                 = 'девятьсот';
$lang['nbr_1000']                = 'тысяча';
$lang['nbr_1000000']             = 'миллиона';
$lang['nbr_1000000000']          = 'миллиард';
$lang['nbr_1000000000000']       = 'триллион';
$lang['nbr_1000000000000000']    = 'квадрильон';
$lang['nbr_1000000000000000000'] = 'нониллион';


$lang['report']                    = "отчет";
$lang['reports']                   = "Отчеты";
$lang['report_no_data']            = "У вас нет данных за этот период. Пожалуйста, настройте дату";
$lang['profit']                    = "прибыль";
$lang['income']                    = "доход";
$lang['spending']                  = "расходование";
$lang['total_spending']            = "Общие расходы";
$lang['outstanding_revenue']       = "Непогашенный доход";
$lang['total_outstanding']         = "Всего выдающихся";
$lang['total_profit']              = "Общая прибыль";
$lang['total_profit']              = "Общая прибыль";
$lang['accounts_aging']            = "Учетные записи";
$lang['accounts_aging_subheading'] = "Узнайте, какие клиенты тратят много времени на оплату";
$lang['no_aging_accounts']         = "Не было обнаружено просроченных клиентов. Пожалуйста, настройте дату.";
$lang['as_of']                     = "Начиная с";
$lang['aging_age1']                = "00 - 30 дней";
$lang['aging_age2']                = "31 - 60 дней";
$lang['aging_age3']                = "61 - 90 дней";
$lang['aging_age4']                = "Более 90 дней";
$lang['from']                      = "Из";
$lang['to']                        = "к";
$lang['revenue_by_customer']       = "Доход от клиента";
$lang['invoice_details']           = "Сведения о счете";
$lang['total_revenue']             = "Общий доход";
$lang['total_invoiced']            = "Всего выставленных счетов";
$lang['total_due']                 = "Общая сумма";
$lang['total_paid']                = "Итого";
$lang['summary']                   = "Резюме";
$lang['tax_summary']               = "Резюме налога";
$lang['tax_name']                  = "Налоговое имя";
$lang['taxable_amount']            = "Налогооблагаемая сумма";
$lang['net']                       = "Сеть";
$lang['profit_loss']               = "Прибыль и убытки (графики)";
$lang['profit_loss_subheading']    = "Помогает определить, что вы должны платить налоги, и если вы делаете больше, чем тратите";
$lang['tax_summary_subheading']    = "Помогает определить, сколько вы обязаны правительству в налогах с продаж";
$lang['invoice_det_subheading']    = "Подробное резюме всех счетов-фактур, которые вы отправили в течение определенного периода времени";
$lang['revenue_cust_subheading']   = "Доход, классифицированный клиентом в течение определенного периода времени";


$lang['chat']                      = "чат";
$lang['chat_new_message_from']     = "Новое сообщение";
$lang['online']                    = "В сети";
$lang['offline']                   = "Не в сети";
$lang['delete_conversation']       = "Удалить беседу";
$lang['type_your_message']         = "введите свое сообщение ...";
$lang['support']                   = "Поддержка";
$lang['chat_support_label']        = "Имя поддержки";
$lang['chat_support_id']           = "Администратор поддержки";

$lang['tools']                     = "инструменты";
$lang['low']                       = "Низкий";
$lang['medium']                    = "средний";
$lang['high']                      = "Высокая";
$lang['todo_task']                 = "Целевая задача";
$lang['todo_list']                 = "Список дел";
$lang['priority']                  = "приоритет";
$lang['mark_as_complete']          = "Отметить как полностью";
$lang['create_todo']               = "Создать новую задачу";
$lang['edit_todo']                 = "Изменить задачу";
$lang['todo_add_success']          = "Задача успешно создана";
$lang['todo_edit_success']         = "Задача успешно обновлена";
$lang['todo_complete_success']     = "Задача успешно завершена";
$lang['todo_delete_success']       = "Задание успешно удалено";

$lang['calculator']                = "Калькулятор";

$lang['calendar']                  = "Календарь напоминаний";
$lang['calendar_subheading']       = "Нажмите кнопку, чтобы добавить / изменить напоминание.";
$lang['create_reminder']           = "Создать напоминание электронной почты";
$lang['create_reminder_subheading']= "Чтобы добавить новое напоминание, введите следующую информацию.";
$lang['edit_reminder']             = "Обновление напоминания по электронной почте";
$lang['edit_reminder_subheading']  = "Чтобы изменить это напоминание, введите информацию ниже.";
$lang['reminder_add_success']      = "Напоминание успешно создано";
$lang['reminder_edit_success']     = "Напоминание успешно обновлено";
$lang['reminder_delete_success']   = "Напоминание успешно удалено";
$lang['reminder_for']              = "Напоминание для ";
$lang['repeat']                    = "Повторение";
$lang['repeat_every']              = "Повторите каждый";
$lang['end_date']                  = "Дата окончания";
$lang['no_end']                    = "Нет конца";
$lang['no_repeat']                 = "Нет повтора";
$lang['reminder_subject']          = "Тема письма";
$lang['reminder_content']          = "Содержание электронной почты";
$lang['untitled_reminder']         = "Без названия";

$lang['notifications']             = "Уведомления";
$lang['no_notifications']          = "0 уведомлений";

$lang['exchange']                  = "Обмен валют";
$lang['exchange_subheading']       = "Изменение между курсами валют";
$lang['result']                    = "результат";
$lang['change']                    = "+ Изменить";
$lang['not_supported']             = "Не поддерживается";


$lang['permission']                = "разрешение";
$lang['permissions']               = "права доступа";
$lang['members_permission']        = "Пользователи";
$lang['posts_level_permission']    = "Разрешения на уровне сообщений";
$lang['posts_level_permission_p']  = "указать, какие сообщения пользователи могут читать и редактировать";
$lang['posts_tip']                 = "Посты - это счета-фактуры, выставляемые счета-фактуры, оценки, расходы, контракты";
$lang['read_his_posts']            = "Чтение и редактирование сообщений, созданных членом";
$lang['read_all_posts']            = "Читать и редактировать все сообщения";

$lang['customer_permission']       = "Разрешения для клиентов";
$lang['customer_pay_methods']      = "Способы оплаты";
$lang['customer_pay_methods_p']    = "указать, какие способы оплаты клиенты могут оплатить";
$lang['customer_pay_methods_tip']  = "Способы офлайн (наличные, чек, банковский перевод и т. Д.), Онлайн-методы: (Paypal, Stripe, 2Checkout ...)";
$lang['use_all_pay_methods']       = "Используйте все способы оплаты (онлайн и офлайн)";
$lang['use_offline_pay_methods']   = "Использовать автономные способы оплаты";


$lang['link']                           = "Ссылка";
$lang['overdue_days']                   = "Просроченные дни";
$lang['update_email_template']          = "Обновить шаблон электронной почты";
$lang['email_template_updated']         = "Шаблон электронной почты успешно обновлен";
$lang['template_name']                  = "Имя Шаблона";
$lang['template']                       = "шаблон";
$lang['templates']                      = "Шаблоны";
$lang['activation_code']                = "Код активации";
$lang['forgotten_password_code']        = "Забытый код пароля";
$lang['send_invoices_to_customer']  = "Отправлять счета клиенту";
$lang['send_receipts_to_customer']  = "Отправлять квитанции клиенту";
$lang['send_rinvoices_to_customer'] = "Отправлять возвращаемые счета-фактуры клиенту";
$lang['send_estimates_to_customer'] = "Отправка оценок клиенту";
$lang['send_contracts_to_customer'] = "Отправлять контракты клиенту";
$lang['send_customer_reminder']     = "Отправить напоминание клиента";
$lang['send_overdue_reminder']      = "Отправить просроченное напоминание";
$lang['send_forgotten_password']    = "Отправить забытый пароль";
$lang['send_activate']              = "Отправить код активации учетной записи";
$lang['send_activate_customer']     = "Отправить код активации учетной записи клиента";
$lang['send_file']                  = "Отправить файл";


$lang['customize_template']           = "Настройка шаблона";
$lang['blank']                        = "пустой";
$lang['customize']                    = "Customize";
$lang['font_size']                    = "Размер шрифта";
$lang['margin']                       = "Поле";
$lang['tables']                       = "таблицы";
$lang['bordered']                     = "окаймленный";
$lang['striped']                      = "В полоску";
$lang['line_th_height']               = "Высота заголовка";
$lang['line_td_height']               = "Высота строк";
$lang['line_th_bg']                   = "Фон заголовка";
$lang['line_th_color']                = "Цвет текста заголовка";
$lang['monocolor']                    = "Моно-цвет";
$lang['grayscale']                    = "Оттенки серого";
$lang['background']                   = "Задний план";
$lang['color']                        = "цвет";
$lang['image']                        = "Образ";
$lang['position']                     = "Должность";
$lang['fit']                          = "Поместиться";
$lang['opacity']                      = "помутнение";
$lang['bg_color']                     = "Фоновый цвет";
$lang['txt_color']                    = "Цвет текста";
$lang['stamp']                        = "Печать";
$lang['select_color']                 = "Выберите цвет";



// projects
$lang['project']                      = "проект";
$lang['projects']                     = "проектов";
$lang['projects_subheading']          = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['create_project']               = "Создать новый проект";
$lang['create_project_subheading']    = "Чтобы создать новый проект, введите следующую информацию.";
$lang['edit_project']                 = "Изменить проект";
$lang['edit_project_subheading']      = "Для редактирования этого проекта, пожалуйста, введите информацию ниже.";
$lang['project_add_success']          = "Проект успешно создан";
$lang['project_edit_success']         = "Проект успешно обновлен";
$lang['project_deleted']              = "Удаленный проект";
$lang['cant_delete_project']          = "Вы не можете удалить этот проект!";
$lang['project_name']                 = "Название проекта";
$lang['billing_type']                 = "Тип фактуры";
$lang['total_rate']                   = "Общий курс";
$lang['rate_per_hour']                = "Стоимость в час";
$lang['estimated_hours']              = "Расчетные часы";
$lang['not_started']                  = "Не начался";
$lang['in_progress']                  = "В ходе выполнения";
$lang['on_hold']                      = "На удерживании";
$lang['fixed_rate']                   = "Фиксированная ставка";
$lang['project_hours']                = "Время работы проекта";
$lang['task_hours']                   = "Часы работы";
$lang['deadline']                     = "Крайний срок";
$lang['members']                      = "члены";
$lang['progress']                     = "Прогресс";
$lang['task']                         = "задача";
$lang['tasks']                        = "Задания";
$lang['tasks_list']                   = "Список задач";
$lang['testing']                      = "тестирование";
$lang['complete']                     = "полный";
$lang['create_task']                  = "Создать новую задачу";
$lang['edit_task']                    = "Изменить задачу";
$lang['task_add_success']             = "Задача успешно создана";
$lang['task_edit_success']            = "Задача успешно обновлена";
$lang['task_complete_success']        = "Задача успешно завершена";
$lang['task_delete_success']          = "Задание успешно удалено";
$lang['project_progress']             = "Прогресс проекта";
$lang['project_informations']         = "Информация о проекте";
$lang['not_completed_tasks']          = "Не завершенные задания";
$lang['days_left']                    = "Осталось дней";
$lang['overview']                     = "обзор";
$lang['hour_rate']                    = "Часовая скорость";
$lang['hour']                         = "Час";


$lang['partial_invoices']                = "Частичные счета-фактуры";
$lang['partial_invoices_subheading']     = "Пожалуйста, используйте приведенную ниже таблицу для навигации или фильтрации результатов.";
$lang['paid_amount']                     = "Выплаченная сумма";
$lang['amount_due']                      = "Надлежащей суммы";
$lang['payment_date']                    = "Дата платежа";
$lang['rate']                            = "Ставка";
$lang['activate_double_currency']        = "Активация опции двойной валюты";
$lang['filter_customer']                 = "Фильтровать по клиенту";
$lang['customer_suggestion_placeholder'] = "Предложение клиента";
$lang['daterange']                       = "Диапазон дат";
$lang['filtering']                       = "фильтрация";
$lang['partial_invoice_details']         = "Детали частичного счета";
$lang['partial_invoice_det_subheading']  = "Подробное резюме частичных счетов-фактур, которые вы отправили в течение определенного периода времени";
$lang['cost_per_supplier']               = "Расходы на одного поставщика";
$lang['cost_per_supplier_subheading']    = "Расходы, классифицированные по поставщику в определенный период времени";
$lang['tasks_progress']                  = "Выполнение задач";
$lang['filter_supplier']                 = "Фильтр поставщиков";
$lang['supplier_suggestion_placeholder'] = "Предложение поставщика";
$lang['exchange_api']                    = "Exchange API";
$lang['create_an_account']               = "Завести аккаунт";
$lang['generates_an_api_key']            = "и генерирует ключ API";


?>
