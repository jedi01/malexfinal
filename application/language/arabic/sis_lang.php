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
$lang['IS_RTL']                           = true;
$lang['lang']                             = "ar-dz";
$lang['site_title_head']                  = "نظام الفاتورة الذكية";
$lang['site_title']                       = 'نظام <span class="bold">الفاتورة</span> الذكية';
$lang['is_demo']                          = "هذه نسخة تريبية فقط، لا يمكنك تشغيل جميع الخصائص";
$lang['remove_install_file']              = "لسلامة البرنامج يرجى حذف ملف التثبيت \"install.php\" من المجلد الرئيسي";

$lang['invoice']                          = "فاتورة";
$lang['invoices']                         = "الفواتير";
$lang['invoices_subheading']              = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['reference']                        = "الرقم المرجعي";
$lang['date']                             = "التاريخ";
$lang['date_due']                         = "تاريخ الاستحقاق";
$lang['valid_till']                       = 'صالح حتى';
$lang['status']                           = "الحالة";
$lang['invoice_note']                     = "ملاحظة الفاتورة";
$lang['invoice_terms']                    = "بنود الفاتورة";
$lang['total']                            = "المجموع";
$lang['actions']                          = "روابط";
$lang['details']                          = "تفاصيل";
$lang['delete']                           = "حذف";
$lang['edit']                             = "تعديل";
$lang['duplicate']                        = "نسخة طبق الأصل";
$lang['refresh']                          = "تحديث";
$lang['filter']                           = "تصفية";
$lang['yes']                              = "نعم";
$lang['no']                               = "لا";
$lang['ok']                               = 'موافق';
$lang['cancel']                           = "إلغاء";
$lang['clear']                            = "مسح";
$lang['save']                             = "حفظ";
$lang['next']                             = "التالى";
$lang['previous']                         = "سابق";
$lang['confirmation']                     = "التأكيد";
$lang['alert_confirmation']               = "تريد تأكيد هذا الإجراء. اضغط على نعم للمتابعة أو لا للرجوع";
$lang['name']                             = "الاسم";
$lang['description']                      = "الوصف";
$lang['show_description']                 = "عرض الوصف";

$lang["system"]                           = 'النظام';
$lang['create_invoice']                   = "إنشاء فاتورة";
$lang['edit_invoice']                     = "تعديل الفاتورة";
$lang['create_invoice_subheading']        = "لإنشاء فاتورة جديدة، يرجى إدخال المعلومات أدناه.";
$lang['edit_invoice_subheading']          = "لتعديل هذه الفاتورة يرجى إدخال المعلومات أدناه.";
$lang['preview_invoice_error']            = "لمعاينة هذه الفاتورة يرجى إكما جميع الحقول الإجبارية.";
$lang['invoice_title']                    = "عنوان الفاتورة";
$lang['invoice_description']              = "اكتب ملخص الفاتورة ...";
$lang['basic_informations']               = "المعلومات الأساسية";
$lang['contact_informations']             = "معلومات الاتصال";
$lang['account_informations']             = "معلومات الحساب";
$lang['additional_informations']          = "معلومات إضافية";
$lang['attn']                             = "";
$lang['company']                          = "الشركة";
$lang['company_name']                     = "اسم الشركة";
$lang['fullname']                         = "الاسم الكامل";
$lang['contact_name']                     = "اسم جهة الاتصال";
$lang['phone']                            = "الهاتف";
$lang['email']                            = "البريد الإلكتروني";
$lang['address']                          = "العنوان";
$lang['percent']                          = "نسبه مئويه (٪)";
$lang['flat']                             = "مبلغ معين ($)";
$lang['off']                              = "إيقاف";
$lang['invoice_setting']                  = "إعدادات الفاتورة";
$lang['currency']                         = "العملة";
$lang['tax_type']                         = "نوع الضريبة";
$lang['discount_type']                    = "نوع الخصم";
$lang['tax']                              = "ضريبة";
$lang['taxes']                            = "الضرائب";
$lang['discount']                         = "خصم";
$lang['discounts']                        = "خصومات";
$lang['total_due']                        = "الاجمالي المستحق";
$lang['issued_on']                        = "الصادر في";
$lang['issued_date']                      = "تاريخ الاصدار";

$lang['all_invoices']                     = "جميع الفواتير";
$lang['unpaid']                           = "غير مدفوع";
$lang['paid']                             = "مدفوعة";
$lang['partial']                          = "مدفوعة جزئيا";
$lang['due']                              = "بسبب";
$lang['overdue']                          = "متأخرة";
$lang['canceled']                         = "ألغيت";
$lang['draft']                            = "مسودة";

$lang['due_receipt']                      = "-";
$lang['after_7_days']                     = "بعد 7 أيام";
$lang['after_15_days']                    = "بعد 15 يوما";
$lang['after_30_days']                    = "بعد 30 يوما";
$lang['after_45_days']                    = "بعد 45 يوما";
$lang['after_60_days']                    = "بعد 60 يوما";
$lang['custom']                           = "تاريخ مخصص";

$lang['more']                             = "أكثر من ...";
$lang['add']                              = "إضافة";
$lang['quantity']                         = "الكمية";
$lang['unit_price']                       = "سعر الوحدة";
$lang['add_row']                          = "اضف سطر";
$lang['subtotal']                         = "المجموع الجزئي";
$lang['global_tax']                       = "الضريبة الكلية";
$lang['global_discount']                  = "الخصم الكلي";
$lang['preview']                          = "معاينة";
$lang['create']                           = "إنشاء";
$lang['open']                             = "فتح";
$lang['invoice_no']                       = "رقم الفاتورة";
$lang['invoice_items']                    = "عناصر الفاتورة";
$lang['n°']                               = "الرقم";
$lang['code']                             = "الرمز";
$lang['print']                            = "طباعة";
$lang['close']                            = "إغلاق";
$lang['title']                            = "العنوان";
$lang['system_setting']                   = "اعدادات النظام";
$lang['system_setting_subheading']        = "لتحديث إعدادات النظام يرجى إدخال المعلومات أدناه.";
$lang['settings_general']                 = "عامة";
$lang['settings_company']                 = "الشركة";
$lang['settings_invoice']                 = "الفاتورة";
$lang['configuration_general']            = "تحديث الإعدادات العامة";
$lang['update_settings']                  = "تحديث الإعدادات";
$lang['language']                         = "اللغة";
$lang['select']                           = "تحديد";
$lang['selected']                         = "المحدد";
$lang['date_format']                      = "صيغة التاريخ";
$lang['currency_format']                  = "تنسيق العملة";
$lang['currency_format']                  = "تنسيق العملة";
$lang['default_currency']                 = "العملة الافتراضية";
$lang['currency_place']                   = "مكان رمز العملة";
$lang['prefix_invoice']                   = "بادئة الفاتورة";
$lang['estimate_prefix']                  = "بادئة التقدير";
$lang['receipt_prefix']                   = "بادئة الدفع";
$lang['contract_prefix']                  = "بادئة العقد";
$lang['expense_prefix']                   = "بادئة النفقات";
$lang['invoice_next']                     = "الفاتورة التالية";
$lang['estimate_next']                    = "التقدير التالي";
$lang['receipt_next']                     = "الإيصال التالي";
$lang['contract_next']                    = "العقد التالي";
$lang['expense_next']                     = "النفقات التالية";
$lang['biller_type']                      = "نوع بيلر";
$lang['item_tax']                         = "الضريبة على العنصر";
$lang['item_discount']                    = "الخصم على العنصر";
$lang['is_required']                      = "إجباري";
$lang['email_address']                    = "عنوان البريد الإلكتروني";
$lang['city']                             = "المدينة";
$lang['state']                            = "المنطقة";
$lang['postal_code']                      = "الرمز البريدى";
$lang['country']                          = "البلد";
$lang['website']                          = "رابط الموقع";
$lang['configuration_company']            = "تحديث إعدادات الشركة";
$lang['update']                           = "تحديث الإعدادات";
$lang['logo']                             = "الشعار";
$lang['perview']                          = "معاينة الشعار";
$lang['configuration_invoice_template']   = "تحديث إعدادات قالب الفاتورة";
$lang['update_template']                  = "تحديث الإعدادات";
$lang['settings']                         = "الإعدادات";
$lang['style']                            = "الستايل العام";
$lang['header']                           = "رأس الصفحة";
$lang['footer']                           = "تذييل الصفحة";
$lang['signature']                        = "التوقيع";
$lang['template_configuration']           = "تحديث الإعدادات الإفتاضية للقالب";
$lang['default_layout']                   = "التخطيط الافتراضي";
$lang['default_size']                     = "الحجم الافتراضي";
$lang['auto_print']                       = "الطباعة التلقائية";
$lang['template_style_configuration']     = "تحديث إعدادات الستايل العام";
$lang['font']                             = "الخط";
$lang['table_bordered']                   = "الجدول مخطط";
$lang['table_striped']                    = "فصل السطور";
$lang['primary_color']                    = "اللون الأولي";
$lang['second_color']                     = "اللون الثانوي";
$lang['template_header_configuration']    = "تحديث إعدادات رأس الصفحة";
$lang['appearance']                       = "المظهر الخارجي";
$lang['show_header']                      = "إظهار / إخفاء";
$lang['header_bg_color']                  = "لون الخلفية";
$lang['header_txt_color']                 = "لون النص";
$lang['template']                         = "القالب";
$lang['header_text']                      = "نص رأس الصفحة";
$lang['template_footer_configuration']    = "تحديث إعدادات تذييل الصفحة";
$lang['show_footer']                      = "إظهار / إخفاء";
$lang['footer_bg_color']                  = "لون الخلفية";
$lang['footer_txt_color']                 = "لون النص";
$lang['footer_text']                      = "نص تذييل الصفحة";
$lang['template_signature_configuration'] = "تحديث إعدادات التوقيع";
$lang['signature_txt']                    = "نص التوقيع";
$lang['order_by']                         = "ترتيب حسب";
$lang['title_invoice']                    = "عنوان فاتورة";
$lang['no_zero_required']                 = "الحقل %s إجبراي";
$lang['users']                            = "المستخدمين";
$lang['dashboard']                        = "الرئيسية";
$lang['settings_general_updated']         = "تم تحديث الإعدادات العامة بنجاح";
$lang['settings_company_updated']         = "تم تحديث إعدادات الشركة بنجاح";
$lang['invoice_template_updated']         = "تم تحديث إعدادات قالب الفاتورة بنجاح";
$lang['invoice_add_success']              = "تم إنشاء الفاتورة بنجاح";
$lang['invoice_edit_success']             = "تم تحديث الفاتورة بنجاح";
$lang['invoice_deleted']                  = "تم حذف الفاتورة بنجاح";
$lang['cant_delete_invoice']               = "لا يمكنك حذف هذه الفاتورة! لسبب: <br> <ul><li> هذه الفاتورة مرتبطة بعناصر أخرى </li></ul> يجب حذف جميع العناصر، ثم إعادة المحاولة";
$lang['invoice_duplicate_success']        = "تم نسخ الفاتورة بنجاح";
$lang['access_denied']                    = "غير مسموح بالدخول !";
$lang['language_is_changed']              = "تم تغيير اللغة بنجاح";
$lang['change_password']                  = "تغيير كلمة السر";
$lang['logout']                           = "الخروج";
$lang['here']                             = "هنا";

$lang['paid_invoices']                    = "فواتير مدفوعة";
$lang['unpaid_invoices']                  = "فواتير غير مدفوعة";
$lang['overdue_invoices']                 = "فواتير متأخرة";
$lang['number_of_invoices']               = '<div class="font-weight-bold" style=";text-align:right;direction:rtl">%s</div><div class="text-muted" style=";text-align:right;direction:rtl"> <small>فاتورة</small> </div>';
$lang['last_invoices']                    = "آخر الفواتير";
$lang['last_invoices_subheading']         = "عرض قائمة آخر 5 الفواتير التي تم إنشاؤها";
$lang['overview_chart']                   = "مخطط نظرة عامة";
$lang['overview_chart_subheading']        = "مخطط دائري لحساب الفواتير لكل حالة";
$lang['invoices_per_date']                = "الفواتير حسب التاريخ";
$lang['invoices_per_date_subheading']     = "رسم بياني يوضح مجموع الفواتير حسب التاريخ";

$lang['settings_template']                = "إعدادات القالب";
$lang['defaults']                         = "الإفتراضية";
$lang['default_status']                   = "الحالة الافتراضية";
$lang['manage_configurations']            = "إعدادات الإنشاء  وتحديث";
$lang['printing_configurations']          = "إعدادات الطباعة";
$lang['show_invoice_status']              = "إظهار حالة الفاتورة";
$lang['show_total_due']                   = "عرض إجمالي المستحق";
$lang['show_payments_page']               = "عرض صفحة الدفعات";
$lang['note_terms_on_page']               = "البنود في الصفحة";
$lang['enable_terms']                     = "تمكين البنود والشروط";
$lang['payments_total']                   = "إجمالي الدفعات";
$lang['invoice_total']                    = "إجمالي الفاتورة";
$lang['description_inline']               = "وصف المنتج";
$lang['description_inline_tip']           = "عرض وصف المنتج على نفس السطر مع الاسم";

// Errors
$lang['error_csrf']                       = "لم تجتاز مشاركة النموذج هذه عمليات التحقق من الأمان.";
// Users Roles
$lang['role_superadmin']                  = 'سوبر المشرف';
$lang['role_admin']                       = 'مدير';
$lang['role_members']                     = 'المستخدم (عضو)';
$lang['role_customer']                    = 'زبون';
$lang['role_supplier']                    = 'المورد';

// Login
$lang['login_heading']                    = 'تسجيل الدخول';
$lang['login_subheading']                 = 'الرجاء الدخول بإستخدام بريدك الإلكتروني / اسم المستخدم وكلمة المرور أدناه.';
$lang['login_identity_label']             = 'البريد الالكتروني / اسم المستخدم:';
$lang['login_password_label']             = 'كلمه المرور:';
$lang['login_remember_label']             = 'تذكرنى';
$lang['login_submit_btn']                 = 'تسجيل الدخول';
$lang['login_forgot_password']            = 'نسيت كلمة المرور؟';

// Index
$lang['index_heading']                    = 'الحسابات';
$lang['index_subheading']                 = 'وفيما يلي قائمة من المستخدمين.';
$lang['index_username_th']                = 'إسم العضوية';
$lang['index_name_th']                    = 'الإسم';
$lang['index_fname_th']                   = 'الإسم الأول';
$lang['index_lname_th']                   = 'اللقب';
$lang['index_email_th']                   = 'العنوان الإلكتروني';
$lang['index_groups_th']                  = 'المجموعة';
$lang['index_status_th']                  = 'الحالة';
$lang['index_action_th']                  = 'الأوامر';
$lang['index_active_link']                = 'تفعيل';
$lang['index_inactive_link']              = 'تعطيل';
$lang['index_create_user_link']           = 'إنشاء حساب';
$lang['index_active_status']              = 'مفعلة';
$lang['index_inactive_status']            = 'غير مفعلة';

// Deactivate User
$lang['deactivate_heading']                  = 'تعطيل العضوية';
$lang['deactivate_subheading']               = 'هل أنت متأكد أنك تريد تعطيل المستخدم \'%s\'';
$lang['deactivate_confirm_y_label']          = 'نعم';
$lang['deactivate_confirm_n_label']          = 'لا';
$lang['deactivate_submit_btn']               = 'إرسال';
$lang['deactivate_validation_confirm_label'] = 'تأكيد';
$lang['deactivate_validation_user_id_label'] = 'إيدي العضو';

// Create User
$lang['create_user_heading']                           = 'إنشاء مستخدم ';
$lang['create_user_subheading']                        = 'الرجاء إدخال معلومات المستخدمين أدناه. ';
$lang['create_user_fname_label']                       = 'الاسم الاول';
$lang['create_user_lname_label']                       = 'الكنية';
$lang['create_user_company_label']                     = 'اسم الشركة';
$lang['create_user_identity_label']                    = 'هوية';
$lang['create_user_email_label']                       = 'البريد الإلكتروني';
$lang['create_user_phone_label']                       = 'هاتف';
$lang['create_user_password_label']                    = 'كلمه السر';
$lang['create_user_password_confirm_label']            = 'تأكيد كلمة المرور';
$lang['create_user_submit_btn']                        = 'إنشاء مستخدم ';
$lang['create_user_validation_fname_label']            = 'الاسم الاول';
$lang['create_user_validation_lname_label']            = 'الكنية';
$lang['create_user_validation_identity_label']         = 'هوية';
$lang['create_user_validation_email_label']            = 'عنوان البريد الإلكتروني';
$lang['create_user_validation_phone_label']            = 'هاتف';
$lang['create_user_validation_company_label']          = 'اسم الشركة';
$lang['create_user_validation_password_label']         = 'كلمه السر';
$lang['create_user_validation_password_confirm_label'] = 'تأكيد كلمة المرور';

// Edit User
$lang['edit_user_heading']                           = 'تحرير العضو';
$lang['edit_user_subheading']                        = 'الرجاء إدخال معلومات المستخدمين أدناه. ';
$lang['edit_user_fname_label']                       = 'الاسم الاول';
$lang['edit_user_lname_label']                       = 'الكنية';
$lang['edit_user_company_label']                     = 'اسم الشركة';
$lang['edit_user_email_label']                       = 'البريد الإلكتروني';
$lang['edit_user_phone_label']                       = 'هاتف';
$lang['edit_user_password_label']                    = 'كلمة المرور';
$lang['edit_user_password_confirm_label']            = 'تأكيد كلمة المرور';
$lang['edit_user_password_help']                     = 'إن تغيير كلمة المرور';
$lang['edit_user_groups_heading']                    = 'عضو في مجموعة ';
$lang['edit_user_submit_btn']                        = 'حفظ العضو ';
$lang['edit_user_validation_fname_label']            = 'الاسم الاول';
$lang['edit_user_validation_lname_label']            = 'الكنية';
$lang['edit_user_validation_email_label']            = 'عنوان البريد الإلكتروني';
$lang['edit_user_validation_phone_label']            = 'هاتف';
$lang['edit_user_validation_company_label']          = 'اسم الشركة';
$lang['edit_user_validation_groups_label']           = 'مجموعة ';
$lang['edit_user_validation_password_label']         = 'كلمه السر';
$lang['edit_user_validation_password_confirm_label'] = 'تأكيد كلمة المرور';

// Change Password
$lang['change_password_heading']                               = 'تغيير كلمة المرور';
$lang['change_password_old_password_label']                    = 'كلمة المرور القديمة:';
$lang['change_password_new_password_label']                    = 'كلمة المرور الجديدة (%s حروف على الأقل):';
$lang['change_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['change_password_submit_btn']                            = 'تغيير';
$lang['change_password_validation_old_password_label']         = 'كلمة المرور القديمة';
$lang['change_password_validation_new_password_label']         = 'كلمة المرور الجديدة';
$lang['change_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';

// Forgot Password
$lang['forgot_password_heading']                 = 'نسيت كلمة المرور';
$lang['forgot_password_subheading']              = 'من فضلك أدخل %s حتى يمكننا أن نرسل لك رسالة بالبريد الالكتروني لإعادة تعيين كلمة المرور الخاصة بك.';
$lang['forgot_password_identity_not_found']      = 'لم يتم العثور على الهوية.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'إرسال';
$lang['forgot_password_validation_email_label']  = 'عنوان البريد الإلكتروني';
$lang['forgot_password_identity_label']          = 'اسم المستخدم';
$lang['forgot_password_email_identity_label']    = 'البريد الإلكتروني';
$lang['forgot_password_email_not_found']         = 'لا يوجد سجل من عنوان البريد الإلكتروني.';

// Reset Password
$lang['reset_password_heading']                               = 'تغيير كلمة المرور';
$lang['reset_password_new_password_label']                    = 'كلمة المرور الجديدة (%s حروف على الأقل):';
$lang['reset_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['reset_password_submit_btn']                            = 'تغيير';
$lang['reset_password_validation_new_password_label']         = 'كلمة المرور القديمة';
$lang['reset_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';

// Account Creation
$lang['account_creation_successful']            = 'تم انشاء حسابك بنجاح';
$lang['account_creation_unsuccessful']          = 'حدث خطأ اثناء انشاء حسابك لدينا';
$lang['account_creation_duplicate_email']       = 'هذا البريد الإلكترونى تم استخدامه من قبل او غير صحيح';
$lang['account_creation_duplicate_identity']    = 'اسم المستخدم تم التسجيل به من قبل او غير صحيح';
$lang['account_creation_missing_default_group'] = 'لم يتم تعيين المجموعة الافتراضية';
$lang['account_creation_invalid_default_group'] = 'تم تعيين اسم المجموعة الافتراضية غير صالح';


// Password
$lang['password_change_successful']          = 'تم تغيير كلمة السر';
$lang['password_change_unsuccessful']        = 'لا يمكن تغيير كلمة السر';
$lang['forgot_password_successful']          = 'تم ارسال بريد لإستعادة كلمة السر';
$lang['forgot_password_unsuccessful']        = 'لا يمكن استعادة كلمة السر';

// Activation
$lang['activate_successful']                 = 'تم تفعيل حسابك';
$lang['activate_unsuccessful']               = 'لا يمكن تفعيل حسابك';
$lang['deactivate_successful']               = 'تم إيقاف حسابك';
$lang['deactivate_unsuccessful']             = 'لا يمكن إيقاف حسابك';
$lang['activation_email_successful']         = 'تم إرسال بريد التفعيل';
$lang['activation_email_unsuccessful']       = 'لا يمكن ارسال بريد التفعيل';

// Login / Logout
$lang['login_successful']                    = 'تم تسجيل الدخول بنجاح';
$lang['login_unsuccessful']                  = 'معلومات الدخول غير صحيحة';
$lang['login_unsuccessful_not_active']       = 'الحساب غير مفعل';
$lang['login_timeout']                       = 'تم إقفال العضوية , حاول مرة أخرى بعد حين !';
$lang['logout_successful']                   = 'تم تسجيل خروجك';

// Account Changes
$lang['update_successful']                   = 'تم تعديل معلومات حسابك';
$lang['update_unsuccessful']                 = 'لا يمكن تعديل معلومات الحساب';
$lang['delete_successful']                   = 'تم إلغاء المستخدم';
$lang['delete_unsuccessful']                 = 'لا يمكن إلغاء المستخدم';

// Groups
$lang['group_creation_successful']           = 'تم إنشاء المجموعة بنجاح';
$lang['group_already_exists']                = 'اسم المجموعة مأخوذ من قبل';
$lang['group_update_successful']             = 'تم تحديث تفاصيل المجموعة';
$lang['group_delete_successful']             = 'تم حذف المجموعة';
$lang['group_delete_unsuccessful']           = 'تعذر حذف المجموعة';
$lang['group_delete_notallowed']             = 'لا يمكن حذف مجموعة المشرفين';
$lang['group_name_required']                 = 'اسم المجموعة هو حقل مطلوب';
$lang['group_name_admin_not_alter']          = 'لا يمكن تغيير اسم مجموعة المشرفين';

// Password Strength
$lang['pass_strength_general']               = "يجب أن تحتوي كلمة المرور على:";
$lang['pass_strength_minlength']             = "At leaset {{minlength}} characters";
$lang['pass_strength_number']                = "رقم واحد على الأقل";
$lang['pass_strength_capital']               = "أقلها حرف واحد كبير";
$lang['pass_strength_special']               = "طابع خاص واحد على الأقل";

// Emails
$lang['email_caution']                       = '<b>انتباه</b> الوصلة يمكن استخدامها مرة واحدة فقط. إذا حاولت أن تعيد توجيهها للمرة الثانية، سوف يظهر لك صفحة خطأ. اذا كانت لديك أي أسئلة، يرجى الكتابة للدعم الفني على';
$lang['email_automatic']                     = 'ملاحظة: تم إنشاء هذه الرسالة وإرسالها تلقائيا لا يتطلب أية رد.';
$lang['email_copyright']                     = 'Copyright &copy; %s %s, All rights reserved.';

// Activation Email
$lang['email_activation_subject']            = 'تنشيط الحساب';
$lang['email_activate_heading']              = 'تهنئة !';
$lang['email_activate_subheading']           = 'مرحبا <b>%s</b>, لقد سجلت بنجاح على <i>%s</i>.<br> لتفعيل حسابك، يرجى تأكيد تسجيلك.';
$lang['email_activate_link']                 = 'تأكيد التسجيل';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'التحقق من كلمة المرور المنسية';
$lang['email_forgot_password_heading']       = 'مرحبا %s,';
$lang['email_forgot_password_subheading']    = 'لقد تلقينا طلبا لإعادة تعيين كلمة المرور الخاصة بك.<br> اسم المستخدم الخاص بك هو <b>%s</b>.';
$lang['email_forgot_password_link']          = 'إعادة تعيين كلمة المرور';

// New Password Email
$lang['email_new_password_subject']          = 'كلمة السر الجديدة';
$lang['email_new_password_heading']          = 'كلمة السر الجديدة';
$lang['email_new_password_subheading']       = 'تم إعادة تعيين كلمة المرور الخاصة بك إلى:';

// Invoice Email
$lang['emails']                              = 'عنواين البريد الإلكتروني';
$lang['email_to']                            = "إلى";
$lang['email_subject']                       = "موضوع";
$lang['email_cc']                            = "CC";
$lang['email_bcc']                           = "BCC";
$lang['show_hide_cc_bcc']                    = "إظهار / إخفاء سيسي &amp; بسك";
$lang['send_email']                          = "ارسل بريد الكتروني";
$lang['emails_list']                         = 'عناوين البريد الإلكتروني';
$lang['send']                                = 'إرسال';
$lang['additional_content']                  = 'محتوى إضافي';
$lang['emails_example']                      = 'مثال: contact@sis.com, info@sis.com ...';
$lang['email_invoice_subject']               = 'فاتورة PDF من %s';
$lang['email_invoice_heading']               = 'تحية طيبة !';
$lang['email_invoice_subheading']            = 'لقد تلقيت فاتورة من <b>%s</b>.<br>ملف PDF مرفق..';
$lang['email_successful']                    = 'تم إرسال البريد الإلكتروني. يرجى التحقق من البريد الوارد أو الرسائل غير المرغوب فيها';
$lang['email_unsuccessful']                  = 'تعذر إرسال البريد الإلكتروني، تحقق من إعدادات البريد الإلكتروني الخاص بك!';


$lang['email_dear']                          = 'العزيز %s ،';
$lang['send_payments_reminder']              = 'إرسال تذكير الدفعات';
$lang['no_unpaid_invoies']                   = "هذا العميل لم يكن لديك أي الفواتير غير المدفوعة!";
$lang['email_rinvoice_subject']              = 'فاتورة جديدة من %s ';
$lang['email_rinvoice_subheading']           = 'لقد تلقيت فاتورة جديدة غير مدفوعة من %s .';
$lang['email_unpaid_subject']                = 'لديك فواتير غير مدفوعة م';
$lang['email_unpaid_invoices']               = 'عندك %s فواتير غير مدفوعة.';
$lang['email_overdue_subject']               = 'لديك فاتورة متأخرة من %s ';
$lang['email_overdue_reminder']              = 'قد تكون قد فاتك تاريخ الدفع إلى الفاتورة متأخرة الآن %s أيام.';

$lang['overdue_reminder']                    = "تأخر تذكير";
$lang['once_is']                             = "مرة واحدة الفاتورة";
$lang['days_late']                           = "أيام متأخرة";
$lang['and_every']                           = "وكل";
$lang['days_after']                          = "بعد أيام";

/* --------------------------- DATATABLES --------------------------------------------- */
$lang['loading_data']               =   "تحميل البيانات من الخادم";
$lang['sEmptyTable']                =   "لم يتم العثور على نتائج في الجداول";
$lang['no_data']                    =   "لم يتم العثور على نتائج !";
$lang['sInfo']                      =   "عرض _START_ إلى _END_ من إجمالي _TOTAL_ من الإدخالات";
$lang['sInfoEmpty']                 =   "عرض 0 من 0 من 0 إدخالات";
$lang['sInfoFiltered']              =   "(تمت تصفيتها من إجمالي الإدخالات _MAX_)";
$lang['sInfoPostFix']               =   "";
$lang['sInfoThousands']             =   ",";
$lang['sLengthMenu']                =   "إظهار _MENU_ إدخالات ";
$lang['sLoadingRecords']            =   "جار التحميل...";
$lang['sProcessing']                =   "معالجة...";
$lang['sSearch']                    =   "بحث ";
$lang['advanced_search']            =   "البحث المتقدم";
$lang['sZeroRecords']               =   "لم يتم العثور على نتائج";
$lang['sFirst']                     =   "&gt;&gt;";
$lang['sLast']                      =   "&lt;&lt;";
$lang['sNext']                      =   "&lt;";
$lang['sPrevious']                  =   "&gt;";
$lang['sSortAscending']             =   ": تمكين ترتيب تصاعدي";
$lang['sSortDescending']            =   ": تمكين ترتيب الهابطة";
$lang['colvis_buttonText']          =   "إظهار / إخفاء الأعمدة";
$lang['colvis_sRestore']            =   "استعادة الأصلي";
$lang['colvis_sShowAll']            =   "عرض الكل";
$lang['tabletool_csv']              =   "تنزيل ملف كسف";
$lang['tabletool_xls']              =   "تحميل إكسيل";
$lang['tabletool_copy']             =   "نسخ";
$lang['tabletool_pdf']              =   "تحميل PDF";
$lang['tabletool_text']             =   "تنزيل النص";
$lang['tabletool_print']            =   "طباعة";
$lang['tabletool_print_sInfo']      =   "<H6> معاينة الطباعة </ h6> <p> يرجى استخدام وظيفة الطباعة في المتصفح لطباعة هذا الجدول. اضغط على إيسك عند الانتهاء. </ p>";
$lang['tabletool_print_sToolTip']   =   "عرض طريقة عرض الطباعة";
$lang['tabletool_select']           =   "تحديد";
$lang['tabletool_select_single']    =   "حدد مفرد";
$lang['tabletool_select_all']       =   "اختر الكل";
$lang['tabletool_select_none']      =   "اختر الكل";
$lang['tabletool_ajax']             =   "زر أجاكس";
$lang['tabletool_collection']       =   "تحميل";
$lang['export']                     =   "تصدير";
$lang['export_csv']                 =   "تصدير كسف";
$lang['export_xls']                 =   "تصدير ك إكسيل";
$lang['export_pdf']                 =   "تصدير كملف Pdf";
$lang['export_text']                =   "تصدير كنص";
$lang['all']                        = "الكل";

/* --------------------------- DATERANGE --------------------------------------------- */
$lang['daterange_today']            = "اليوم";
$lang['daterange_yesterday']        = "في الامس";
$lang['daterange_last_7_days']      = "آخر 7 أيام";
$lang['daterange_last_30_days']     = "آخر 30 يوما";
$lang['daterange_this_month']       = "هذا الشهر";
$lang['daterange_last_month']       = "في الشهر الماضي";
$lang['daterange_this_year']        = "هذا العام";
$lang['daterange_custom']           = "مخصص";
$lang['daterange_end_of_last_month']= "نهاية الشهر الماضي";
$lang['daterange_end_of_year']      = "نهاية العام الماضي";

$lang['error']                      = 'خطأ';
$lang['success']                    = 'تم بنجاح';

// Register
$lang['register_heading']           = 'التسجيل';
$lang['register_subheading']        = 'تسجيل حساب جديد';
$lang['register_ask']               = 'ليس لديك حساب';
$lang['register_btn']               = 'سجل الآن';
$lang['register_username']          = 'إسم المستحدم';
$lang['register_email']             = 'البريد الإلكتروني';
$lang['register_password']          = 'كيمة السر';
$lang['register_password_confirm']  = 'تأكيد كلمة السر';
$lang['register_submit_btn']        = 'سجل الحساب';

$lang['default_group']              = 'مجموعة الحسابات الجديدة';
$lang['enable_register']            = 'تفعيل تسجيل الحسابات';
$lang['reference_type']             = 'نوع الرقم المرجعي';
$lang['show_reference']             = 'إظهار الرقم المرجعي';
$lang['reference_type_changed']     = 'تم تغيير نوع الرقم المرجعي !<br>هل تريد إعادة تعيين الرقم المرجعي لكل الفواتير إلى النوع الجديد؟';
$lang['generate']                   = 'توليد';
$lang['no_invoice_items']           = 'مطلوب عناصر الفاتورة. يجب أن يكون عنصر واحد على الأقل في الحد الأدنى';


$lang["loading"]                    = 'جار التحميل...';
$lang["file"]                       = 'ملف';
$lang["shortcut_help"]              = 'دليل الإختصارات';
$lang["shortcut_help_title"]        = 'دليل إختصارات لوحة المفاتيح';
$lang["documentations"]             = 'المساعد';
$lang["about"]                      = 'حول البرنامج';
$lang["shortcut"]                   = 'الإختصار';
$lang["main_menu"]                  = 'القائمة الرئيسية';

$lang["settings_email"]             = 'البريد الإلكتروني';
$lang["configuration_email"]        = 'تحديث إعدادات البريد الإلكتروني';
$lang["protocol"]                   = 'بروتوكول';
$lang["smtp_crypto"]                = 'التشفير';
$lang["smtp_host"]                  = 'مضيف SMTP';
$lang["smtp_port"]                  = 'منفذ SMTP';
$lang["smtp_user"]                  = 'مستخدم SMTP';
$lang["smtp_pass"]                  = 'كلمة مرور SMTP';
$lang["mailpath"]                   = 'مسار البريد (Mail Path)';
$lang["settings_email_updated"]     = "تم تحديث إعدادات البريد الإلكتروني بنجاح";

// importing data
$lang['import_data']                   = "استيراد البيانات";
$lang['idata_title']                   = "استيراد البيانات";
$lang['idata_subheading']              = "ما هي البيانات التي تريد استيرادها؟";
$lang['idata_upload_file']             = "رفع الملف";
$lang['idata_upload_file_subheading']  = 'الرجاء إدخال المعلومات أدناه.';
$lang['idata_match_fields']            = "تطابق الحقول";
$lang['idata_match_fields_subheading'] = "قم بتهيئة الحقول الخاصة بك إلى حقول التطبيق";
$lang['idata_confirm_data']            = "تأكيد البيانات";
$lang['idata_confirm_data_subheading'] = "تأكيد البيانات وحذفها";
$lang['idata_add_to_database']         = "إضافة إلى قاعدة البيانات";
$lang['idata_add_to_db_subheading']    = "إضافة إلى قاعدة البيانات والخطوة النهائية";
$lang['idata_customers']               = "استيراد العملاء";
$lang['idata_customers_description']   = "استيراد العملاء (الأسماء والعناوين وما إلى ذلك)";
$lang['idata_suppliers']               = "استيراد الموردين";
$lang['idata_suppliers_description']   = "استيراد الموردين (الأسماء والعناوين وما إلى ذلك)";
$lang['idata_ex_cats']                 = "استيراد مصروفات الفئات";
$lang['idata_ex_cats_description']     = "استيراد المصروفات الفئات (النوع، التسمية)";
$lang['idata_users']                   = "استيراد المستخدمين";
$lang['idata_users_description']       = "استيراد المستخدمين (اسم المستخدم وكلمة المرور والبريد الإلكتروني وما إلى ذلك)";
$lang['idata_tax_rates']               = "استيراد الضرائب";
$lang['idata_tax_rates_description']   = "استيراد معدلات الضرائب (التسمية والقيمة والنوع)";
$lang['idata_items']                   = "استيراد العناصر";
$lang['idata_items_description']       = "استيراد العناصر (الاسم والوصف والسعر وما إلى ذلك)";
$lang['idata_item_cats']               = "استيراد فئات العناصر";
$lang['idata_item_cats_description']   = "استيراد فئات العناصر (التصنيف)";


$lang['idata_info']                    = "قائمة الحقول التي يمكن أن يحتوي عليها ملف البيانات. الحقول المطلوبة بخط غامق مطلوبة. إذا كنت تقوم باستيراد البيانات ذات الرموز الخاصة (الفواصل والفواصل المنقوطة، وما إلى ذلك)، يرجى التأكد من أن هذه الحقول المشار إليها مع الاقتباس!";
$lang['idata_checklist']               = "تحقق من قائمتك قبل الاستيراد";
$lang['idata_file_format']             = "تنسيق يقبل ملفات CSV (* .csv) أو ملفات إكسيل (* .xls، * .xlsx)";
$lang['idata_download_sample_file']    = "تحميل ملف مثال لمعرفة ما يمكننا استيراد.";
$lang['idata_download_sample']         = "تحميل ملف عينة";
$lang['idata_csv_delimiter']           = "الفاصلة";
$lang['idata_semicolon']               = "فاصلة منقوطة";
$lang['idata_comma']                   = "فاصلة";
$lang['idata_tab']                     = "التبويب";
$lang['idata_file']                    = "الملف";
$lang['idata_max_file_size']           = "2MB أو 1000 سطر أقصى حجم";
$lang['idata_delete_item']             = "أزل هذا العنصر";
$lang['idata_items_are_imported']      = "عناصر تم استيرادها";
$lang['idata_item_is_imported']        = "عنصر تم استيراده";
$lang['idata_imported']                = "اكتمال استيراد البيانات بنجاح";
$lang['idata_failed']                  = "فشل استيراد البيانات تحقق من الإدخالات الخاص بك مرة أخرى!";
$lang['idata_no_data']                 = "لم تقم بإدخال أي بيانات، تحقق من الإدخالات الخاص بك مرة أخرى!";


$lang["settings_db"]                   = 'النسخ الاحتياطي';
$lang["configuration_db"]              = 'النسخ الاحتياطي لقاعدة البيانات';
$lang["create_backup"]                 = 'انشئ نسخة احتياطية';
$lang["date_creation"]                 = "تاريخ الإنشاء";
$lang["filename"]                      = "اسم الملف";
$lang["restore_backup"]                = 'استرجاع النسخة الاحتياطية';
$lang["delete_backup"]                 = 'حذف النسخ الاحتياطي';
$lang["restore_backup_success"]        = "تم استعادة النسخة الاحتياطية لقاعدة البيانات بنجاح";
$lang["restore_backup_failed"]         = "فشل النسخ الاحتياطي لقاعدة البيانات";
$lang["backup_deleted"]                = "تم حذف النسخ الاحتياطي لقاعدة البيانات بنجاح";



$lang['tax_rate']                      = "معدل الضريبة";
$lang['settings_tax_rates']            = "الضرائب";
$lang['configuration_tax_rates']       = "الضرائب";
$lang["no_tax"]                        = "لا ضرائب";
$lang['create_tax_rate']               = "إضافة معدل الضريبة";
$lang['tax_rate_label']                = "قانون الضرائب";
$lang['tax_rate_value']                = "معدل / المبلغ";
$lang['tax_rate_type']                 = "نوع الضريبة";
$lang['tax_rate_default']              = "معدل الضريبة الافتراضي";
$lang['tax_rate_new']                  = "إنشاء معدل ضريبة جديد";
$lang['tax_rate_update']               = "تحديث معدل الضريبة";
$lang['tax_rate_added']                = "تمت إضافة معدل الضريبة بنجاح";
$lang['tax_rate_updated']              = "تم تحديث معدل الضريبة بنجاح";
$lang['tax_rate_deleted']              = "تم حذف معدل الضريبة بنجاح";
$lang['condition']                     = "شرط";
$lang['conditional_taxes']             = "الضرائب المشروطة";
$lang['conditional_taxes_subheading']  = "إضافة معدل ضريبي إلى مشاركاتك (الفاتورة / التقدير) مع شرط على الإجمالي الفرعي";
$lang['conditional_taxes_tip']         = "على سبيل المثال: إضافة ضريبة قدرها 7 $ على جميع الفواتير لديها المجموع الفرعي أكبر أو يساوي 150 $";
$lang['is_default']                    = "هو الافتراضي";
$lang['default']                       = "افتراضي";
$lang['add_tax']                       = "إضافة ضريبة";
$lang['shipping']                      = "الشحن";
$lang['condition_terms']               = "البنود و الظروف";
$lang['invoice_note']                  = "ملاحظة الفاتورة";
$lang['note']                          = "ملاحظة الفاتورة";
$lang['set_status']                    = "تغيير الحالة";
$lang['set_status_subheading']         = "اختر الحالة الجديدة لهذه الفاتورة";
$lang['old_status']                    = "الحالة القديمة";
$lang['clear_filter']                  = "إلغاء";
$lang['shown_columns']                 = "الأعمدة النشطة";
$lang['number_format']                 = "تنسيق الأرقام";
$lang['round_number']                  = "أرقام مستديرة";
$lang['decimal_place']                 = "منزلة عشرية";
$lang['disabled']                      = "تعطيل";
$lang['enabled']                       = "تمكين";
$lang['apply_to_subtotal']             = "تطبيق على المجموع الفرعي البيان";
$lang['apply_to_line']                 = "تطبيق على البنود";

$lang['estimate']                      = "تقدير";
$lang['estimates']                     = "التقديرات";
$lang['estimates_subheading']          = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['estimate_no']                   = "رقم التقدير ";
$lang['estimate_items']                = "تقدير العناصر";
$lang['estimate_title']                = "عنوان التقدير";
$lang['estimate_note']                 = "الملاحظة";
$lang['create_estimate']               = "إنشاء تقدير";
$lang['create_estimate_subheading']    = "لإنشاء تقدير جديد يرجى إدخال المعلومات أدناه.";
$lang['estimate_add_success']          = "تم إنشاء التقدير بنجاح";
$lang['edit_estimate']                 = "تعديل التقدير";
$lang['edit_estimate_subheading']      = "لتعديل هذا التقدير يرجى إدخال المعلومات أدناه.";
$lang['estimate_edit_success']         = "تم تحديث التقدير بنجاح";
$lang['estimate_deleted']              = "تم حذف التقدير بنجاح";
$lang['cant_delete_estimate']          = "لا يمكنك حذف هذا التقدير!، حاول مرة أخرى";
$lang['estimate_duplicate_success']    = "تم تكرار التقدير بنجاح";
$lang['email_estimate_subject']        = "ملف تقدير PDF من  %s";
$lang['no_estimate_items']             = "مطلوب عناصر تقدير. يجب أن يكون عنصر واحد على الأقل في الحد الأدنى";
$lang['preview_estimate_error']        = "لمعاينة هذا التقدير يرجى إدخال جميع المعلومات المطلوبة.";
$lang['email_estimate_heading']        = 'تحية طيبة !';
$lang['email_estimate_subheading']     = 'لقد تلقيت تقديرا من <b>%s</b> . <br> يتم إرفاق ملف PDF .';
$lang['convert_to_invoice']            = "تحويل إلى الفاتورة";
$lang['sent']                          = "أرسلت";
$lang['accepted']                      = "قبلت";
$lang['invoiced']                      = "فواتير";
$lang['approve']                       = "يوافق";
$lang['reject']                        = "رفض";

$lang['cash']                          = "السيولة النقدية";
$lang['check']                         = "شيك";
$lang['bank_transfer']                 = "التحويل المصرفي";
$lang['online']                        = "عبر الانترنت";
$lang['other']                         = "آخر";

$lang['payment']                       = "دفع";
$lang['payments']                      = "المدفوعات";
$lang['payments_subheading']           = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['payments_create']               = "إنشاء دفعة";
$lang['payments_create_subheading']    = "لإنشاء دفعة جديدة، يرجى إدخال المعلومات أدناه.";
$lang['payments_create_success']       = "تم إنشاء الدفع بنجاح";
$lang['payments_edit']                 = "تعديل الدفع";
$lang['payments_edit_subheading']      = "لتعديل هذه الدفعة، يرجى إدخال المعلومات أدناه.";
$lang['payments_edit_success']         = "تم تحديث الدفع بنجاح";
$lang['payments_deleted']              = "تم حذف الدفعة بنجاح";
$lang['payment_number']                = "رقم الدفعة";
$lang['payment_details']               = "بيانات الدفع";
$lang['amount']                        = "المبلغ";
$lang['payment_method']                = "طريقة الدفع او السداد";
$lang['method']                        = "طريقة";
$lang['total_paid']                    = "مجموع المبالغ المدفوعة";
$lang['email_payment_subject']         = "ملف PDF من %s";
$lang['no_payment_items']              = "بنود الدفع مطلوبة. يجب أن يكون عنصر واحد على الأقل في الحد الأدنى";
$lang['preview_payment_error']         = "لمعاينة هذه الدفعة يرجى إدخال جميع المعلومات المطلوبة.";
$lang['email_payment_heading']         = 'تحية طيبة !';
$lang['email_payment_subheading']      = 'لقد تلقيت دفعة من <b>%s</b> . <br> يتم إرفاق ملف PDF .';
$lang['payment_for']                   = "الدفع لـ";
$lang['set_status_payment_subheading'] = "اختر الحالة الجديدة لإيصال الدفع هذا";

$lang['receipt']                       = "إيصال الدفع";
$lang['receipts']                      = "إيصالات الدفع";
$lang['receipt_no']                    = "إيصال الدفع رقم";
$lang['receipt_for']                   = "استلام ل";
$lang['create_receipt']                = "إنشاء إيصال";
$lang['receipts_create']               = "إنشاء إيصال";
$lang['receipts_create_subheading']    = "لإجراء إيصال جديد، يرجى إدخال المعلومات أدناه.";
$lang['receipts_edit']                 = "تحرير إيصال";
$lang['receipts_edit_subheading']      = "لتعديل هذا الإيصال، يرجى إدخال المعلومات أدناه.";
$lang['receipts_create_success']       = "تم إنشاء الإيصال بنجاح";
$lang['receipts_edit_success']         = "تم تحديث الإيصال بنجاح";
$lang['receipts_deleted']              = "تم حذف الإيصال بنجاح";


// PAYMENTS ONLINE
$lang['payments_online']               = "الدفع عبر الإنترنت";
$lang['general']                       = "العامة";
$lang['paypal']                        = "Paypal";
$lang['stripe']                        = "Stripe";
$lang['twocheckout']                   = "2Checkout";
$lang['mobilpay']                      = "MobilPay";
$lang['payments_online_requirements']  = "لا يحتوي هذا الخادم على الحد الأدنى من المتطلبات لتمكين الدفعات عبر الإنترنت!";
$lang['payments_online_enable']        = "مكن";
$lang['biller_accounts']               = "حساب بيلر";
$lang['enable']                        = "مكن";
$lang['username']                      = "اسم المستخدم";
$lang['password']                      = "كلمه السر";
$lang['sandbox']                       = "Sandbox";
$lang['enable']                        = "مكن";
$lang['api_key']                       = "Api key";
$lang['enable']                        = "مكن";
$lang['account_number']                = "رقم حساب";
$lang['secretWord']                    = "كلمة سرية";
$lang['merchant_id']                   = "معرف التاجر";
$lang['public_key']                    = "المفتاح العمومي";
$lang['test_mode']                     = "وضع الاختبار";
$lang['panding']                       = "قيد الانتظار";
$lang['released']                      = "أصدرت";
$lang['active']                        = "نشيط";
$lang['expired']                       = "منتهية الصلاحية";
$lang['finished']                      = "تم الانتهاء من";
$lang['payment_released']              = "تم إصدار الدفعة بنجاح";
$lang['payment_canceled']              = "تم إلغاء الدفع";



$lang['credit_card']                   = "بطاقة ائتمان";
$lang['credit_card_firstName']         = "الاسم الاول";
$lang['credit_card_lastName']          = "الكنية";
$lang['credit_card_number']            = "رقم بطاقة الائتمان";
$lang['credit_card_expiryMonth']       = "شهر انتهاء الصلاحية";
$lang['credit_card_expiryYear']        = "تاريخ انتهاء الصلاحية";
$lang['credit_card_cvv']               = "CVV / CVC";

$lang["settings_po_updated"]           = "تم تحديث إعدادات الدفع عبر الإنترنت بنجاح";

$lang['custom_field']                  = "حقل مخصص";
$lang['custom_fields']                 = "الحقول المخصصة";
$lang['custom_field_label']            = "تسمية الحقل المخصص";
$lang['custom_field_value']            = "قيمة الحقل المخصص";
$lang['customer_cf']                   = "الحقول المخصصة للعميل";
$lang['custom_field_1']                = "حقل مخصص 1";
$lang['custom_field_2']                = "حقل مخصص 2";
$lang['custom_field_3']                = "حقل مخصص 3";
$lang['custom_field_4']                = "حقل مخصص 4";
$lang['vat_number']                    = "ظريبه الشراء";
$lang['vat_number_placeholder']        = "رقم تعريف ضريبة القيمة المضافة";



// CUSTOMERS
$lang['customer_bill_to']             = 'فاتورة الى';
$lang['customer']                     = 'العميل';
$lang['customers']                    = 'العملاء';
$lang['customer_add_success']         = "تمت إضافة العميل بنجاح";
$lang['customer_edit_success']        = "تم تحديث العميل بنجاح";
$lang['customer_deleted']             = "تم حذف العميل بنجاح";
$lang['cant_delete_customer']         = "لا يمكنك حذف هذا العميل!، يجب عليك حذف جميع فواتيره، ثم إعادة المحاولة";
$lang['customers_subheading']         = 'يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.';
$lang['create_customer']              = 'إضافة عميل';
$lang['edit_customer']                = "تحرير العميل";
$lang['details_customer']             = "تفاصيل العميل";
$lang['create_customer_subheading']   = "لإضافة عميل جديد، يرجى إدخال المعلومات أدناه.";
$lang['edit_customer_subheading']     = "لتعديل هذا العميل، يرجى إدخال المعلومات أدناه.";
$lang['profile_customer']             = "صفحة الزبون الشخصية";
$lang['profile']                      = "الملف الشخصي";
$lang['edit_customer_account']        = "تعديل الحساب";
$lang['create_customer_account']      = "إصنع حساب";
$lang['account_created']              = "تم إنشاء حساب العميل بنجاح";
$lang['account_username']             = "اسم صاحب الحساب";
$lang['account_status']               = "حالة الحساب";


// SUPPLIERS
$lang['supplier_bill_to']             = 'فاتورة من';
$lang['supplier']                     = 'المورد';
$lang['suppliers']                    = 'الموردين';
$lang['supplier_add_success']         = "تمت إضافة المورد بنجاح";
$lang['supplier_edit_success']        = "تم تحديث المورد بنجاح";
$lang['supplier_deleted']             = "تم حذف المورد بنجاح";
$lang['cant_delete_supplier']         = "لا يمكنك حذف هذا المورد!، يجب عليك حذف جميع فواتيره، ثم إعادة المحاولة";
$lang['suppliers_subheading']         = 'يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.';
$lang['create_supplier']              = 'إضافة المورد';
$lang['edit_supplier']                = "تحرير المورد";
$lang['details_supplier']             = "تفاصيل المورد";
$lang['create_supplier_subheading']   = "لإضافة مورد جديد، يرجى إدخال المعلومات أدناه.";
$lang['edit_supplier_subheading']     = "لتعديل هذا المورد يرجى إدخال المعلومات أدناه.";

// ITEMS
$lang['item']                     = 'بند';
$lang['items']                    = "العناصر";
$lang['price']                    = 'السعر';
$lang['default_tax']              = 'الضرائب الافتراضية';
$lang['default_discount']         = 'الخصم الافتراضي';
$lang['item_add_success']         = "تمت إضافة العنصر بنجاح";
$lang['item_edit_success']        = "تم تحديث العنصر بنجاح";
$lang['item_deleted']             = "تم حذف العنصر بنجاح";
$lang['cant_delete_item']         = "لا يمكنك حذف هذا العنصر !، السبب: <br><ul><li> هذا العنصر مرتبط بفاتورة أخرى </li></ul> يجب عليك حذف جميع فواتيره، ثم إعادة المحاولة";
$lang['items_subheading']         = 'يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.';
$lang['create_item']              = 'اضافة عنصر';
$lang['edit_item']                = "تعديل عنصر";
$lang['details_item']             = "تفاصيل العنصر";
$lang['create_item_subheading']   = "عنصر عنصر جديد، يرجى إدخال المعلومات أدناه.";
$lang['edit_item_subheading']     = "لتعديل هذا العنصر الرجاء إدخال المعلومات أدناه.";
$lang['prices']                   = "الأسعار";
$lang['unit']                     = "وحدة";
$lang['add_new_price']            = "إضافة سعر جديد";
$lang['no_item_prices']           = "أسعار البند مطلوب. يجب أن يكون على الأقل 1 سعر لهذا البند في الحد الأدنى";
$lang['category']                 = "الفئة";
$lang['categories']               = "الاقسام";
$lang['items_categories']         = "الاقسام";
$lang['category_create']          = "إنشاء فئة جديدة";
$lang['category_update']          = "تحديث الفئة";
$lang['category_added']           = "تمت إضافة الفئة بنجاح";
$lang['category_updated']         = "تم تحديث الفئة بنجاح";
$lang['category_deleted']         = "تم حذف الفئة بنجاح";


$lang['invoices_activities']      = "أنشطة الفواتير";
$lang['estimates_activities']     = "تقديرات الأنشطة";
$lang['activities']               = "أنشطة";


$lang['files']                    = "ملفات";
$lang['files_subheading']         = "Files_subheading";
$lang['file_rename']              = "إعادة تسمية ملف / مجلد";
$lang['create_folder']            = "مجلد مجلد";
$lang['file_move_to']             = "نقل";
$lang['files_view']               = "معاينة";
$lang['files_share']              = "شارك";
$lang['file_deleted']             = "تم حذف الملف بنجاح";
$lang['file_moved_trash']         = "تم نقل الملف بنجاح إلى المهملات";
$lang['file_restored']            = "تمت استعادة الملف بنجاح";
$lang['cant_delete_file']         = "لا يمكنك حذف هذا الملف!";
$lang['file_rename_success']      = "تمت إعادة تسمية الملف / المجلد بنجاح";
$lang['file_moved_success']       = "تم نقل الملف / المجلد بنجاح";
$lang['create_folder_success']    = "تم إنشاء المجلد بنجاح";
$lang['filename']                 = "اسم الملف";
$lang['size']                     = "بحجم";
$lang['file_type']                = "نوع الملف";
$lang['upload_date']              = "تاريخ الرفع";
$lang['gohome']                   = "اذهب للمنزل";
$lang['goback']                   = "عد";
$lang['open_trash']               = "فتح المهملات";
$lang['delete_definitive']        = "حذف نهائي";
$lang['restore_file']             = "استعادة الملف";
$lang['grid']                     = "عرض الشبكة";
$lang['list']                     = "عرض القائمة";
$lang['sort']                     = "فرز";
$lang['upload']                   = "تحميل";
$lang['share']                    = "شارك";
$lang['copylink']                 = "انسخ الرابط";
$lang['copy']                     = "نسخ";
$lang['move_to']                  = "الانتقال إلى";
$lang['move']                     = "نقل";
$lang['rename']                   = "إعادة تسمية";
$lang['foldername']               = "إسم الملف";
$lang['folder']                   = "مجلد";
$lang['text_is_copied']           = "يتم نسخ النص إلى الحافظة";
$lang['no_file_selected']         = "لم يتم تحديد أي ملف لتحميله!";
$lang['browse_files']             = "تصفح ملفات";
$lang['confirm']                  = "تؤكد";
$lang['dimensions']               = "الأبعاد";
$lang['duration']                 = "المدة الزمنية";
$lang['crop']                     = "ا &amp; قتصاص";
$lang['rotate']                   = "استدارة";
$lang['choose']                   = "أختر";
$lang['to_upload']                = "لتحميل";
$lang['files_were']               = "كانت الملفات";
$lang['file_was']                 = "كان الملف";
$lang['chosen']                   = "اختيار";
$lang['drag_drop_file']           = "اسحب الملفات وأفلتها هنا";
$lang['or']                       = "أو";
$lang['drop_file']                = "إسقاط الملفات هنا لتحميل";
$lang['paste_file']               = "لصق ملف، انقر هنا للإلغاء.";
$lang['remove_confirmation']      = "هل تريد بالتأكيد إزالة هذا الملف؟";
$lang['folder']                   = "مجلد";
$lang['filesLimit']               = "فقط %s يسمح بتحميل الملفات.";
$lang['filesType']                = "فقط %s يسمح بتحميل الملفات.";
$lang['fileSize']                 = "كبير جدا! الرجاء اختيار ملف يصل إلى %s MB.";
$lang['filesSizeAll']             = "الملفات التي اخترتها كبيرة جدا! يرجى تحميل ملفات تصل إلى %s MB.";
$lang['fileName']                 = "ملف مع الاسم %s تم تحديده بالفعل &quot;.";
$lang['folderUpload']             = "لا يسمح لك بتحميل المجلدات.";
$lang['no_more_space']            = "لا مزيد من المساحة لتحميل هذه الملفات!";
$lang['add_attached_file']        = "أرفق ملف";
$lang['uploader']                 = "مستندات";
$lang['settings_files']           = "إعدادات رافع";
$lang['configuration_files']      = "تهيئة تحميل الملفات";
$lang['file_upload_enable']       = "تمكين تحميل الملفات";
$lang['user_disc_space']          = "مساحة قرص المستخدم";
$lang['user_disc_space_tip']      = "&lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt; &lt;/s&gt;؟";
$lang['max_upload_size']          = "الحد الأقصى لحجم التحميل";
$lang['max_upload_size_tip']      = "الحد الأقصى لحجم الملف الذي يمكن للمستخدمين تحميله (بالميغابايت).";
$lang['max_simult_uploads']       = "الحد الأقصى للتحميلات المتزامنة.";
$lang['max_simult_uploads_tip']   = "عدد الملفات التي يمكن تحميلها في نفس الوقت.";
$lang['white_list']               = "قائمة بيضاء";
$lang['white_list_tip']           = "I&#39;m نوت ثات يو نو. مثال: mp4, jpg, mp3, pdf.";
$lang["settings_files_updated"]   = "يتم تحديث إعدادات الملفات بنجاح";

$lang['send_link_via_email']      = "أرسل هذا الرابط عبر البريد الإلكتروني";
$lang['links']                    = "الروابط";
$lang['view_link']                = "عرض الرابط";
$lang['direct_link']              = "رابط مباشر";
$lang['download_link']            = "رابط التحميل";
$lang['html_embed_code']          = "شفرة تضمين Html";
$lang['forum_embed_code']         = "رمز تضمين المنتدى";
$lang['email_file_subject']       = "ملف من %s ";

$lang['folder']                   = "مجلد";
$lang['folder']                   = "مجلد";
$lang['folder']                   = "مجلد";
$lang['folder']                   = "مجلد";
$lang['folder']                   = "مجلد";


// RECURRING INVOICES
$lang['rinvoice']                      = "الفاتورة المتكررة";
$lang['rinvoices']                     = "الفواتير المتكررة";
$lang['rinvoices_subheading']          = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['recu_invoice_schedule']         = "جدول الفوترة المتكررة";
$lang['frequency']                     = "تكرر";
$lang['every']                         = "كل";
$lang['occurences']                    = "أحداثا";
$lang['daily']                         = "اليومي";
$lang['weekly']                        = "أسبوعي";
$lang['monthly']                       = "شهريا";
$lang['yearly']                        = "سنوي";
$lang['day']                           = "يوم";
$lang['days']                          = "أيام";
$lang['week']                          = "أسبوع";
$lang['weeks']                         = "أسابيع";
$lang['month']                         = "شهر";
$lang['months']                        = "الشهور";
$lang['year']                          = "عام";
$lang['years']                         = "سنوات";
$lang['recu_when_start']               = "متى يبدأ الجدول التلقائي؟";
$lang['recu_when_create']              = "متى سيتم إنشاء الفواتير؟";
$lang['invoice_will_every']            = "سيتم إنشاء الفاتورة كل";
$lang['on']                            = "في";
$lang['on_the']                        = "في";
$lang['forever']                       = "إلى الأبد";
$lang['for']                           = "بـ";
$lang['occurence_time']                = "1 مرة";
$lang['occurence_times']               = "مرات";
$lang['recurring_effective']           = "تكرار فعال ابتدأ من";
$lang['package_name']                  = "اسم الحزمة";
$lang['create_rinvoice']               = "إنشاء فاتورة متكررة";
$lang['create_rinvoice_subheading']    = "إنشاء فاتورة متكررة جديدة، يرجى إدخال المعلومات أدناه.";
$lang['rinvoice_is_canceled']          = "تم إلغاء هذه الفاتورة المتكررة لا يمكنك تحريرها!";
$lang['edit_rinvoice']                 = "تحرير الفاتورة المتكررة";
$lang['edit_rinvoice_subheading']      = "لتعديل هذه الفاتورة يرجى يرجى إدخال المعلومات أدناه.";
$lang['rinvoices_activities']          = "أنشطة الفواتير المتكررة";
$lang['rinvoice_add_success']          = "تم إنشاء الفاتورة المتكررة بنجاح";
$lang['rinvoice_edit_success']         = "تم تحديث الفاتورة المتكررة بنجاح";
$lang['rinvoice_deleted']              = "تم حذف الفاتورة المتكررة بنجاح";
$lang['cant_delete_rinvoice']          = "لا يمكنك حذف هذه الفاتورة المتكررة! السبب: <br><ul><li> ترتبط هذه الفاتورة المتكررة مع عناصر أخرى </li></ul> لديك لحذف كافة العناصر، ثم حاول مرة أخرى";
$lang['rinvoice_duplicate_success']    = "تم تكرار الفاتورة المتكررة بنجاح";
$lang['rinvoice_started']              = "بدأ الملف الشخصي للفاتورة المتكررة بنجاح";
$lang['rinvoice_canceled']             = "يتم إلغاء الملف الشخصي للفاتورة المتكررة";
$lang['rinvoice_skipped']              = "تم تخطي الفاتورة بنجاح بنجاح الفاتورة التالية بنجاح";
$lang['start_profile']                 = "ابدأ الملف الشخصي";
$lang['cancel_profile']                = "إلغاء الملف الشخصي";
$lang['skip_next_invoice']             = "تخطي الفاتورة التالية";
$lang['scheduled']                     = "المقرر";
$lang['skipped']                       = "تخطي";
$lang['this_invoice_skipped']          = "تم تخطي هذه الفاتورة";
$lang['next_billing_date']             = "تاريخ الفوترة التالي";
$lang['today']                         = "اليوم";
$lang['cronjob_desactivated']          = "لتمكين الفواتير المتكررة لديك لإضافة هذا الأمر %s على بك";
$lang['rinvoice_draft']                = "احفظ الفاتورة كمسودة لكل تكرار";
$lang['rinvoice_sent']                 = "إرسال الفواتير عبر البريد الإلكتروني مباشرة إلى العميل في كل تكرار";


// contracts
$lang['contract']                      = "عقد";
$lang['contracts']                     = "العقود";
$lang['contracts_subheading']          = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['create_contract']               = "إنشاء عقد جديد";
$lang['create_contract_subheading']    = "إنشاء عقد جديد يرجى إدخال المعلومات أدناه.";
$lang['edit_contract']                 = "تعديل العقد";
$lang['edit_contract_subheading']      = "هذا العقد يرجى إدخال المعلومات أدناه.";
$lang['contract_add_success']          = "تم إنشاء فاتورة العقد بنجاح";
$lang['contract_edit_success']         = "تم تحديث فاتورة العقد بنجاح";
$lang['contract_deleted']              = "تم حذف فاتورة العقد بنجاح";
$lang['cant_delete_contract']          = "لا يمكنك حذف هذا العقد! السبب: <br><ul><li> ترتبط هذه الفاتورة المتكررة مع عناصر أخرى </li></ul> لديك لحذف كافة العناصر، ثم حاول مرة أخرى";
$lang['subject']                       = "موضوع";
$lang['contract_type']                 = "نوع العقد";
$lang['contract_value']                = "قيمة العقد";
$lang['contract_description']          = "وصف العقد الافتراضي";
$lang['email_contract_subject']        = "Pdf العقد من %s ";
$lang['email_contract_heading']        = 'تحية طيبة !';
$lang['email_contract_subheading']     = 'لقد تلقيت عقدا من %s . <br> يتم إرفاق ملف بدف.';


// Expenses
$lang['expense']                       = "مصروف";
$lang['expenses']                      = "نفقات";
$lang['expenses_subheading']           = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['expenses_create']               = "إنشاء مصاريف جديدة";
$lang['expenses_create_subheading']    = "لإنشاء مصاريف جديدة، يرجى إدخال المعلومات أدناه.";
$lang['expenses_edit']                 = "تحرير النفقات";
$lang['expenses_edit_subheading']      = "لتعديل هذه النفقات، يرجى إدخال المعلومات أدناه.";
$lang['expenses_create_success']       = "تم إنشاء النفقات بنجاح";
$lang['expenses_edit_success']         = "تم تحديث النفقات بنجاح";
$lang['expenses_deleted']              = "تم حذف النفقات بنجاح";
$lang['category']                      = "الفئة";
$lang['attachments']                   = "مرفقات";
$lang['download_attachments']          = "تحميل المرفقات";
$lang['invoice_number']                = "رقم الفاتورة";
$lang['expense_number']                = "رقم المصروفات";
$lang['expenses_category']             = "الفئة";
$lang['expenses_categories']           = "الاقسام";
$lang['expenses_subheading']           = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['expenses_category_create']      = "إنشاء فئة جديدة";
$lang['expenses_category_update']      = "تحرير الفئة";
$lang['expenses_category_added']       = "تم إنشاء الفئة بنجاح";
$lang['expenses_category_updated']     = "تم تحديث الفئة بنجاح";
$lang['expenses_category_deleted']     = "تم حذف الفئة بنجاح";
$lang['expenses_category_type']        = "النوع";
$lang['expenses_category_label']       = "التسمية";
$lang['expense_no']                    = "رقم النفقة";



$lang['amount_in_words']         = 'المبلغ بالكلمات';
$lang['nbr_conjunction']         = 'و';
$lang['nbr_negative']            = 'ناقص';
$lang['nbr_decimal']             = 'فاصلة';
$lang['nbr_separator']           = 'و ';
$lang['nbr_inversed']            = true;
$lang['nbr_0']                   = 'صفر';
$lang['nbr_1']                   = 'واحد';
$lang['nbr_2']                   = 'اثنان';
$lang['nbr_3']                   = 'ثلاثة';
$lang['nbr_4']                   = 'أربعة';
$lang['nbr_5']                   = 'خمسة';
$lang['nbr_6']                   = 'ستة';
$lang['nbr_7']                   = 'سبعة';
$lang['nbr_8']                   = 'ثمانية';
$lang['nbr_9']                   = 'تسعة';
$lang['nbr_10']                  = 'عشرة';
$lang['nbr_11']                  = 'أحد عشر';
$lang['nbr_12']                  = 'اثنا عشر';
$lang['nbr_13']                  = 'ثلاثة عشر';
$lang['nbr_14']                  = 'أربعة عشر';
$lang['nbr_15']                  = 'خمسة عشر';
$lang['nbr_16']                  = 'ستة عشر';
$lang['nbr_17']                  = 'سبعة عشر';
$lang['nbr_18']                  = 'ثمانية عشر';
$lang['nbr_19']                  = 'تسعة عشر';
$lang['nbr_20']                  = 'عشرون';
$lang['nbr_30']                  = 'ثلاثون';
$lang['nbr_40']                  = 'أربعون';
$lang['nbr_50']                  = 'خمسون';
$lang['nbr_60']                  = 'ستون';
$lang['nbr_70']                  = 'سبعون';
$lang['nbr_80']                  = 'ثمانون';
$lang['nbr_90']                  = 'تسعون';
$lang['nbr_100']                 = 'مئة';
$lang['nbr_200']                 = 'مئتان';
$lang['nbr_300']                 = 'ثلاثمئة';
$lang['nbr_400']                 = 'أربعمئة';
$lang['nbr_500']                 = 'خمسمئة';
$lang['nbr_600']                 = 'ستمئة';
$lang['nbr_700']                 = 'سبعمئة';
$lang['nbr_800']                 = 'ثمانمئة';
$lang['nbr_900']                 = 'تسعمئة';
$lang['nbr_1000']                = 'ألف';
$lang['nbr_1000000']             = 'مليون';
$lang['nbr_1000000000']          = 'بليون';
$lang['nbr_1000000000000']       = 'ترليون';
$lang['nbr_1000000000000000']    = 'كوادرليون';
$lang['nbr_1000000000000000000'] = 'كوينتليون';


$lang['report']                    = "تقرير";
$lang['reports']                   = "تقارير";
$lang['report_no_data']            = "ليس لديك أي بيانات لهذه الفترة. يرجى ضبط التاريخ";
$lang['profit']                    = "الفائدة (الربح)";
$lang['income']                    = "الإيرادات";
$lang['spending']                  = "الإنفاق";
$lang['total_spending']            = "إجمالي الإنفاق";
$lang['outstanding_revenue']       = "الإيرادات المعلقة";
$lang['total_outstanding']         = "المجموع غير المسدد";
$lang['total_profit']              = "اجمالي الربح";
$lang['total_profit']              = "اجمالي الربح";
$lang['accounts_aging']            = "حسابات الشيخوخة";
$lang['accounts_aging_subheading'] = "معرفة العملاء الذين يأخذون وقتا طويلا لدفع";
$lang['no_aging_accounts']         = "لم يتم العثور على عملاء متأخرين. يرجى ضبط التاريخ.";
$lang['as_of']                     = "اعتبارا من";
$lang['aging_age1']                = "00 - 30 يوم";
$lang['aging_age2']                = "31 - 60 يوما";
$lang['aging_age3']                = "61 - 90 يوما";
$lang['aging_age4']                = "أكثر من 90 يوما";
$lang['from']                      = "من عند";
$lang['to']                        = "إلى";
$lang['revenue_by_customer']       = "الأرباح من قبل العميل";
$lang['invoice_details']           = "تفاصيل الفاتورة";
$lang['total_revenue']             = "إجمالي الإيرادات";
$lang['total_invoiced']            = "إجمالي الفاتورة";
$lang['total_due']                 = "الاجمالي المستحق";
$lang['total_paid']                = "مجموع المبالغ المدفوعة";
$lang['summary']                   = "ملخص";
$lang['tax_summary']               = "ملخص الضرائب";
$lang['tax_name']                  = "اسم الضريبة";
$lang['taxable_amount']            = "المبلغ الخاضع للضريبة";
$lang['net']                       = "شبكة";
$lang['profit_loss']               = "الربح والخسارة (الرسوم البيانية)";
$lang['profit_loss_subheading']    = "يساعد على تحديد ما مدين لك في الضرائب وإذا كنت تبذل أكثر مما كنت تنفق";
$lang['tax_summary_subheading']    = "يساعد على تحديد مقدار مدينون للحكومة في ضريبة المبيعات";
$lang['invoice_det_subheading']    = "ملخص تفصيلي لجميع الفواتير التي أرسلتها على مدار فترة زمنية";
$lang['revenue_cust_subheading']   = "الإيرادات مصنفة حسب العميل خلال فترة زمنية محددة";


$lang['chat']                      = "الدعم";
$lang['chat_new_message_from']     = "رسالة جديدة";
$lang['online']                    = "عبر الانترنت";
$lang['offline']                   = "غير متصل";
$lang['delete_conversation']       = "مسح المحادثة";
$lang['type_your_message']         = "اكتب رسالتك ...";
$lang['support']                   = "الدعم";
$lang['chat_support_label']        = "اسم الدعم";
$lang['chat_support_id']           = "مشرف الدعم";

$lang['tools']                     = "أدوات";
$lang['low']                       = "منخفض";
$lang['medium']                    = "متوسط";
$lang['high']                      = "متوسط";
$lang['todo_task']                 = "المهام الواجبة";
$lang['todo_list']                 = "قائمة المهام";
$lang['priority']                  = "الأولوية";
$lang['mark_as_complete']          = "وضع علامة كاملة";
$lang['create_todo']               = "إنشاء مهمة جديدة";
$lang['edit_todo']                 = "تعديل المهمة";
$lang['todo_add_success']          = "تم إنشاء المهمة بنجاح";
$lang['todo_edit_success']         = "تم تحديث المهمة بنجاح";
$lang['todo_complete_success']     = "اكتملت المهمة بنجاح";
$lang['todo_delete_success']       = "تم حذف المهمة بنجاح";

$lang['calculator']                = "آلة حاسبة";

$lang['calendar']                  = "تذكير التقويم";
$lang['calendar_subheading']       = "يرجى النقر على التاريخ لإضافة / تعديل تذكير.";
$lang['create_reminder']           = "إنشاء تذكير بالبريد الإلكتروني";
$lang['create_reminder_subheading']= "لإضافة تذكير جديد، يرجى إدخال المعلومات أدناه.";
$lang['edit_reminder']             = "تحديث تذكير البريد الإلكتروني";
$lang['edit_reminder_subheading']  = "لتعديل هذا التذكير، يرجى إدخال المعلومات أدناه.";
$lang['reminder_add_success']      = "تم إنشاء التذكير بنجاح";
$lang['reminder_edit_success']     = "تم تحديث التذكير بنجاح";
$lang['reminder_delete_success']   = "تم حذف التذكير بنجاح";
$lang['reminder_for']              = "تذكير لـ ";
$lang['repeat']                    = "كرر";
$lang['repeat_every']              = "تكرار كل";
$lang['end_date']                  = "تاريخ الانتهاء";
$lang['no_end']                    = "لا نهاية";
$lang['no_repeat']                 = "لا تكرار";
$lang['reminder_subject']          = "موضوع البريد الإلكتروني";
$lang['reminder_content']          = "محتوى البريد الإلكتروني";
$lang['untitled_reminder']         = "تذكير بلا عنوان";

$lang['notifications']             = "إخطارات";
$lang['no_notifications']          = "0 الإخطارات";

$lang['exchange']                  = "تحويل العملات";
$lang['exchange_subheading']       = "التغيير بين أسعار العملات";
$lang['result']                    = "نتيجة";
$lang['change']                    = "يتغيرون";
$lang['not_supported']             = "غير معتمد";


$lang['permission']                = "الإذن";
$lang['permissions']               = "أذونات";
$lang['members_permission']        = "الأعضاء الأذونات";
$lang['posts_level_permission']    = "أذونات مستوى المشاركات";
$lang['posts_level_permission_p']  = "حدد الوظائف التي يستطيع الأعضاء قراءتها وتعديلها";
$lang['posts_tip']                 = "المشاركات هي الفواتير، ريكورينغ الفواتير، التقديرات، والمصروفات، والعقود";
$lang['read_his_posts']            = "قراءة وتعديل المشاركات التي تم إنشاؤها بواسطة العضو";
$lang['read_all_posts']            = "قراءة جميع المشاركات وتعديلها";

$lang['customer_permission']       = "أذونات العملاء";
$lang['customer_pay_methods']      = "طرق الدفع";
$lang['customer_pay_methods_p']    = "حدد طرق الدفع التي يمكن للعملاء دفعها";
$lang['customer_pay_methods_tip']  = "طرق غير متصل (النقدية، والتحقق، والتحويل المصرفي، وغيرها)، والأساليب على الانترنت: (Paypal، Stripe، 2Checkout ...)";
$lang['use_all_pay_methods']       = "استخدام جميع طرق الدفع (عبر الإنترنت وغير متصل)";
$lang['use_offline_pay_methods']   = "استخدام طرق الدفع بلا اتصال";


$lang['link']                           = "حلقة الوصل";
$lang['overdue_days']                   = "أيام المتأخرة";
$lang['update_email_template']          = "تحديث نموذج البريد الإلكتروني";
$lang['email_template_updated']         = "تم تحديث نموذج البريد الإلكتروني بنجاح";
$lang['template_name']                  = "اسم القالب";
$lang['template']                       = "القالب";
$lang['templates']                      = "قوالب";
$lang['activation_code']                = "رمز التفعيل";
$lang['forgotten_password_code']        = "نسيت كلمة المرور";
$lang['send_invoices_to_customer']  = "إرسال الفواتير إلى العميل";
$lang['send_receipts_to_customer']  = "إرسال إيصالات للعميل";
$lang['send_rinvoices_to_customer'] = "إرسال الفواتير المتكررة للعميل";
$lang['send_estimates_to_customer'] = "إرسال التقديرات إلى العميل";
$lang['send_contracts_to_customer'] = "إرسال العقود للعملاء";
$lang['send_customer_reminder']     = "إرسال تذكير العملاء";
$lang['send_overdue_reminder']      = "إرسال تذكير المتأخرة";
$lang['send_forgotten_password']    = "إرسال كلمة المرور المنسية";
$lang['send_activate']              = "إرسال رمز تنشيط الحساب";
$lang['send_activate_customer']     = "إرسال رمز تفعيل حساب العميل";
$lang['send_file']                  = "إرسال ملف";


$lang['customize_template']           = "تخصيص القالب";
$lang['blank']                        = "فراغ";
$lang['customize']                    = "تعديل";
$lang['font_size']                    = "حجم الخط";
$lang['margin']                       = "الحواف";
$lang['tables']                       = "الجداول";
$lang['bordered']                     = "مخطط";
$lang['striped']                      = "سطر بسطر";
$lang['line_th_height']               = "ارتفاع العنوان";
$lang['line_td_height']               = "ارتفاع الصفوف";
$lang['line_th_bg']                   = "خلفية العنوان";
$lang['line_th_color']                = "لون نص العنوان";
$lang['monocolor']                    = "أحادية اللون";
$lang['grayscale']                    = "الرمادي اللون";
$lang['background']                   = "خلفية";
$lang['color']                        = "اللون";
$lang['image']                        = "صورة";
$lang['position']                     = "موضع";
$lang['fit']                          = "لائق بدنيا";
$lang['opacity']                      = "غموض";
$lang['bg_color']                     = "لون الخلفية";
$lang['txt_color']                    = "لون الخط";
$lang['stamp']                        = "ختم";
$lang['select_color']                 = "إختر لون";



// projects
$lang['project']                      = "مشروع";
$lang['projects']                     = "مشاريع";
$lang['projects_subheading']          = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['create_project']               = "إنشاء مشروع جديد";
$lang['create_project_subheading']    = "لإنشاء مشروع جديد يرجى إدخال المعلومات أدناه.";
$lang['edit_project']                 = "تحرير المشروع";
$lang['edit_project_subheading']      = "لتعديل هذا المشروع يرجى إدخال المعلومات أدناه.";
$lang['project_add_success']          = "تم إنشاء المشروع بنجاح";
$lang['project_edit_success']         = "تم تحديث المشروع بنجاح";
$lang['project_deleted']              = "تم حذف المشروع بنجاح";
$lang['cant_delete_project']          = "لا يمكنك حذف هذا المشروع!";
$lang['project_name']                 = "اسم المشروع";
$lang['billing_type']                 = "نوع الفوترة";
$lang['total_rate']                   = "إجمالي معدل";
$lang['rate_per_hour']                = "معدل كل ساعة";
$lang['estimated_hours']              = "الساعات المقدرة";
$lang['not_started']                  = "لم يبدأ";
$lang['in_progress']                  = "في تَقَدم";
$lang['on_hold']                      = "في الانتظار";
$lang['fixed_rate']                   = "سعر الصرف الثابت";
$lang['project_hours']                = "ساعات المشروع";
$lang['task_hours']                   = "ساعات العمل";
$lang['deadline']                     = "الموعد النهائي";
$lang['members']                      = "أفراد";
$lang['progress']                     = "تقدم";
$lang['task']                         = "مهمة";
$lang['tasks']                        = "مهام";
$lang['tasks_list']                   = "قائمة المهام";
$lang['testing']                      = "اختبارات";
$lang['complete']                     = "اكتمال";
$lang['create_task']                  = "إنشاء مهمة جديدة";
$lang['edit_task']                    = "تعديل المهمة";
$lang['task_add_success']             = "تم إنشاء المهمة بنجاح";
$lang['task_edit_success']            = "تم تحديث المهمة بنجاح";
$lang['task_complete_success']        = "اكتملت المهمة بنجاح";
$lang['task_delete_success']          = "تم حذف المهمة بنجاح";
$lang['project_progress']             = "تقدم المشروع";
$lang['project_informations']         = "معلومات المشروع";
$lang['not_completed_tasks']          = "المهام غير المكتملة";
$lang['days_left']                    = "أيام متبقية";
$lang['overview']                     = "نظرة عامة";
$lang['hour_rate']                    = "معدل ساعة";
$lang['hour']                         = "ساعة";


$lang['partial_invoices']                = "فواتير جزئية";
$lang['partial_invoices_subheading']     = "يرجى استخدام الجدول أدناه للتنقل أو تصفية النتائج.";
$lang['paid_amount']                     = "المبلغ المدفوع";
$lang['amount_due']                      = "مبلغ مستحق";
$lang['payment_date']                    = "تاريخ الدفع";
$lang['rate']                            = "معدل";
$lang['activate_double_currency']        = "قم بتفعيل خيار العملة المزدوجة";
$lang['filter_customer']                 = "تصفية حسب العميل";
$lang['customer_suggestion_placeholder'] = "اقتراح العميل";
$lang['daterange']                       = "نطاق الموعد";
$lang['filtering']                       = "تصفية";
$lang['partial_invoice_details']         = "تفاصيل الفاتورة الجزئية";
$lang['partial_invoice_det_subheading']  = "ملخص تفصيلي للفواتير الجزئية التي أرسلتها على مدار فترة زمنية";
$lang['cost_per_supplier']               = "التكاليف لكل مورد";
$lang['cost_per_supplier_subheading']    = "الإيرادات مصنفة حسب العميل خلال فترة زمنية محددة";
$lang['tasks_progress']                  = "تقدم المهام";
$lang['filter_supplier']                 = "تصفية لكل مورد";
$lang['supplier_suggestion_placeholder'] = "اقتراح المورد";
$lang['exchange_api']                    = "API الصرف";
$lang['create_an_account']               = "انشئ حساب";
$lang['generates_an_api_key']            = "وإنشاء مفتاح API";


?>
