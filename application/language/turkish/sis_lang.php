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
$lang['lang']                             = "tr";
$lang['site_title_head']                  = 'Akıllı Fatura Sistemi';
$lang['site_title']                       = 'Akıllı <span class="bold">Fatura</span> Sistemi';
$lang['is_demo']                          = "Bu bir demo versiyonudur, tüm seçenekleri çalıştıramazsınız";
$lang['remove_install_file']              = "Programın güvenliği için lütfen ana klasörden \ &quot;install.php \&quot; kurulum dosyasını silin";

$lang['invoice']                          = 'Fatura';
$lang['invoices']                         = 'Faturalar';
$lang['invoices_subheading']              = 'Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.';
$lang['reference']                        = 'Referans';
$lang['date']                             = 'tarih';
$lang['date_due']                         = 'Bitiş tarihi';
$lang['valid_till']                       = 'Kadar geçerli';
$lang['status']                           = 'durum';
$lang['invoice_note']                     = "Fatura Notu";
$lang['invoice_terms']                    = "Fatura Şartları";
$lang['total']                            = 'Genel Toplam';
$lang['actions']                          = 'Eylemler';
$lang['details']                          = 'ayrıntılar';
$lang['delete']                           = 'silmek';
$lang['edit']                             = 'Düzenleme';
$lang['duplicate']                        = 'Çift';
$lang['refresh']                          = 'Yenile';
$lang['filter']                           = 'filtre';
$lang['yes']                              = 'Evet';
$lang['no']                               = 'Yok hayır';
$lang['ok']                               = 'Tamam';
$lang['cancel']                           = "İptal etmek";
$lang['clear']                            = "Açık";
$lang['save']                             = "Kayıt etmek";
$lang['next']                             = "Sonraki";
$lang['previous']                         = "Önceki";
$lang['confirmation']                     = 'Onayla';
$lang['alert_confirmation']               = 'Bu eylemi onaylamak istiyorsun. Devam etmek için YES tuşuna basarak geri dönün.';
$lang['name']                             = 'isim';
$lang['description']                      = 'Açıklama';
$lang['show_description']                 = 'Açıklamayı göster';

$lang["system"]                           = 'sistem';
$lang['create_invoice']                   = 'Fatura yarat';
$lang['edit_invoice']                     = "Faturayı düzenle";
$lang['create_invoice_subheading']        = "Yeni bir Fatura oluşturmak için lütfen aşağıdaki bilgileri giriniz.";
$lang['edit_invoice_subheading']          = "Bu Faturayı düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['preview_invoice_error']            = "Bu faturayı önizlemek için lütfen gerekli tüm bilgileri giriniz.";
$lang['invoice_title']                    = "Fatura başlığı";
$lang['invoice_description']              = "Fatura özeti yazın ...";
$lang['basic_informations']               = "Temel Bilgiler";
$lang['contact_informations']             = "İletişim Bilgileri";
$lang['account_informations']             = "Hesap Bilgileri";
$lang['additional_informations']          = "Ek bilgiler";
$lang['attn']                             = "Attn";
$lang['company']                          = "şirket";
$lang['company_name']                     = "Şirketin adı";
$lang['fullname']                         = "Ad Soyad";
$lang['contact_name']                     = "İrtibat adı";
$lang['phone']                            = "Telefon";
$lang['email']                            = "E-posta";
$lang['address']                          = "Adres";
$lang['percent']                          = "Yüzde (%)";
$lang['flat']                             = "Düz ($)";
$lang['off']                              = "kapalı";
$lang['invoice_setting']                  = "Fatura Ayarları";
$lang['currency']                         = "Para birimi";
$lang['tax_type']                         = "Vergi tipi";
$lang['discount_type']                    = "İndirim türü";
$lang['tax']                              = "Vergi";
$lang['taxes']                            = "Vergiler";
$lang['discount']                         = "İndirim";
$lang['discounts']                        = "İndirimler";
$lang['total_due']                        = "Vadesi gereken toplam";
$lang['issued_on']                        = "Üzerinde yayınlanan";
$lang['issued_date']                      = "Veriliş tarihi";

$lang['all_invoices']                     = "Tüm faturalar";
$lang['unpaid']                           = "ödenmemiş";
$lang['paid']                             = "ödenmiş";
$lang['partial']                          = "Kısmi";
$lang['due']                              = "Due";
$lang['overdue']                          = "vadesi geçmiş";
$lang['canceled']                         = "iptal edildi";
$lang['draft']                            = "taslak";

$lang['due_receipt']                      = "-";
$lang['after_7_days']                     = "7 gün sonra";
$lang['after_15_days']                    = "15 gün sonra";
$lang['after_30_days']                    = "30 gün sonra";
$lang['after_45_days']                    = "45 gün sonra";
$lang['after_60_days']                    = "60 gün sonra";
$lang['custom']                           = "Özel tarih";

$lang['more']                             = "Daha ...";
$lang['add']                              = "Eklemek";
$lang['quantity']                         = "miktar";
$lang['unit_price']                       = "Birim fiyat";
$lang['add_row']                          = "Satır ekle";
$lang['subtotal']                         = "ara toplam";
$lang['global_tax']                       = "Küresel vergi";
$lang['global_discount']                  = "Genel indirim";
$lang['preview']                          = "Önizleme";
$lang['create']                           = "yaratmak";
$lang['open']                             = "Açık";
$lang['invoice_no']                       = "N ° Fatura";
$lang['invoice_items']                    = "Fatura kalemleri";
$lang['n°']                               = "N °";
$lang['code']                             = "kod";
$lang['print']                            = "baskı";
$lang['close']                            = "Kapat";
$lang['title']                            = "Başlık";
$lang['system_setting']                   = "Sistem ayarı";
$lang['system_setting_subheading']        = "Sistem ayarlarını güncellemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['settings_general']                 = "Genel Ayarlar";
$lang['settings_company']                 = "Ayarlar Şirketi";
$lang['settings_invoice']                 = "Fatura Ayarları";
$lang['configuration_general']            = "Genel";
$lang['update_settings']                  = "Ayarları güncelle";
$lang['language']                         = "Dil";
$lang['select']                           = "seçmek";
$lang['selected']                         = "seçilmiş";
$lang['date_format']                      = "Tarih formatı";
$lang['currency_format']                  = "Para birimi biçimi";
$lang['currency_format']                  = "Para birimi biçimi";
$lang['default_currency']                 = "Varsayılan para birimi";
$lang['currency_place']                   = "Para sembole yeri";
$lang['prefix_invoice']                   = "Faturayı öneki";
$lang['estimate_prefix']                  = "Önek tahmin et";
$lang['receipt_prefix']                   = "Ödeme öneki";
$lang['contract_prefix']                  = "Sözleşme öneki";
$lang['expense_prefix']                   = "Gider öneki";
$lang['invoice_next']                     = "Sonraki Fatura";
$lang['estimate_next']                    = "Sonraki Tahmin";
$lang['receipt_next']                     = "Sonraki Makbuz";
$lang['contract_next']                    = "Sonraki Sözleşme";
$lang['expense_next']                     = "Sonraki Gider";
$lang['biller_type']                      = "Biller Tipi";
$lang['item_tax']                         = "Öğe vergisi";
$lang['item_discount']                    = "Öğe indirimi";
$lang['is_required']                      = "gerekli";
$lang['email_address']                    = "E";
$lang['city']                             = "Şehir";
$lang['state']                            = "Belirtmek, bildirmek";
$lang['postal_code']                      = "Posta kodu";
$lang['country']                          = "ülke";
$lang['website']                          = "Web Sitesi URL&#39;si";
$lang['configuration_company']            = "şirket";
$lang['update']                           = "Güncelleştirme";
$lang['logo']                             = "Logo";
$lang['perview']                          = "Önizleme";
$lang['configuration_invoice_template']   = "Fatura şablonu";
$lang['update_template']                  = "Şablonu güncelle";
$lang['settings']                         = "Ayarlar";
$lang['style']                            = "stil";
$lang['header']                           = "Başlık";
$lang['footer']                           = "Alt Bilgi";
$lang['signature']                        = "İmza";
$lang['template_configuration']           = "Şablon Yapılandırması";
$lang['default_layout']                   = "Varsayılan düzen";
$lang['default_size']                     = "Varsayılan boyut";
$lang['auto_print']                       = "Otomatik baskı";
$lang['template_style_configuration']     = "Şablon stili";
$lang['font']                             = "Yazı tipi";
$lang['table_bordered']                   = "Tablo sınırlandırılmıştır";
$lang['table_striped']                    = "Çizgili çizgili";
$lang['primary_color']                    = "Ana renk";
$lang['second_color']                     = "Sekonder renk";
$lang['template_header_configuration']    = "Şablon başlığı";
$lang['appearance']                       = "Görünüm";
$lang['show_header']                      = "Göster / gizle";
$lang['header_bg_color']                  = "Başlık arka plan rengi";
$lang['header_txt_color']                 = "Başlık metin rengi";
$lang['template']                         = "şablon";
$lang['header_text']                      = "Başlık metni";
$lang['template_footer_configuration']    = "Şablon altbilgisi";
$lang['show_footer']                      = "Göster / gizle";
$lang['footer_bg_color']                  = "Altbilgi arka plan rengi";
$lang['footer_txt_color']                 = "Altbilgi metin rengi";
$lang['footer_text']                      = "Altbilgi metni";
$lang['template_signature_configuration'] = "Şablon İmzası";
$lang['signature_txt']                    = "İmza metni";
$lang['order_by']                         = "Tarafından sipariş";
$lang['title_invoice']                    = "Fatura başlığı";
$lang['no_zero_required']                 = "Alan% s gerekiyor";
$lang['users']                            = 'Kullanıcılar';
$lang['dashboard']                        = 'gösterge paneli';
$lang['settings_general_updated']         = "Genel ayarlar başarıyla güncellendi";
$lang['settings_company_updated']         = "Şirket ayarları başarıyla güncellendi";
$lang['invoice_template_updated']         = "Fatura şablonu ayarları başarıyla güncellendi";
$lang['invoice_add_success']              = "Fatura başarıyla oluşturuldu";
$lang['invoice_edit_success']             = "Fatura başarıyla güncellendi";
$lang['invoice_deleted']                  = "Fatura başarıyla silindi";
$lang['cant_delete_invoice']               = "Bu faturayı silemezsin !, nedeni: <br><ul><li> Bu Fatura başka bir öğeyle ilgilidir </li></ul> Tüm öğeleri silmeniz, daha sonra tekrar denemeniz gerekir";
$lang['invoice_duplicate_success']        = "Fatura başarıyla çoğaltıldı";
$lang['access_denied']                    = "Erişim reddedildi!";
$lang['language_is_changed']              = "Dil başarıyla değiştirildi";
$lang['change_password']                  = "Şifre değiştir";
$lang['logout']                           = "Çıkış Yap";
$lang['here']                             = "İşte";

$lang['paid_invoices']                    = "Ödenen fatura (lar)";
$lang['unpaid_invoices']                  = "Ödenmemiş fatura (lar)";
$lang['overdue_invoices']                 = "Gecikmiş faturalar)";
$lang['number_of_invoices']               = '<div class="font-weight-bold">%s</div><div class="text-muted"> <small>faturalar</small> </div>';
$lang['last_invoices']                    = "Son faturalar";
$lang['last_invoices_subheading']         = "Oluşturulan son 5 faturanın listesini göster";
$lang['overview_chart']                   = "Genel bakış grafiği";
$lang['overview_chart_subheading']        = "Durum başına düşen faturaları sayan pasta grafiği";
$lang['invoices_per_date']                = "Tarihe göre faturalar";
$lang['invoices_per_date_subheading']     = "Tarih başına toplam fatura gösteren çizgi çizelgesi";

$lang['settings_template']                = "şablon";
$lang['defaults']                         = "Varsayılan";
$lang['default_status']                   = "Varsayılan durum";
$lang['manage_configurations']            = "Yapılandırmaları Oluşturma / Güncelleme";
$lang['printing_configurations']          = "Yapılandırmaları yazdırma";
$lang['show_invoice_status']              = "Fatura durumunu göster";
$lang['show_total_due']                   = "Vadesi gereken toplamı göster";
$lang['show_payments_page']               = "Ödemeleri göster sayfası";
$lang['note_terms_on_page']               = "Şartlar sayfa";
$lang['enable_terms']                     = "Şartlar ve Koşulları Etkinleştir";
$lang['payments_total']                   = "Ödemeler toplamı";
$lang['invoice_total']                    = "Fatura toplamı";
$lang['description_inline']               = "Ürün Açıklaması";
$lang['description_inline_tip']           = "Ürün açıklamasını aynı satırda adla göster";

// Errors
$lang['error_csrf']                       = 'Bu form postası güvenlik kontrolümüzü geçemedi.';
// Users Roles
$lang['role_superadmin']                  = 'Süper Yönetici';
$lang['role_admin']                       = 'yönetici';
$lang['role_members']                     = 'Kullanıcı (Üye)';
$lang['role_customer']                    = 'Müşteri';
$lang['role_supplier']                    = 'satıcı';

// Login
$lang['login_heading']                    = 'Oturum aç';
$lang['login_subheading']                 = 'Lütfen aşağıdaki e-posta / kullanıcı adı ve şifrenizle giriş yapın.';
$lang['login_identity_label']             = 'E-posta / Kullanıcı Adı';
$lang['login_password_label']             = 'Parola';
$lang['login_remember_label']             = 'Beni hatırla';
$lang['login_submit_btn']                 = 'Oturum aç';
$lang['login_forgot_password']            = 'Parolanızı mı unuttunuz?';

// Index
$lang['index_heading']                    = 'Kullanıcılar';
$lang['index_subheading']                 = 'Aşağıda kullanıcıların bir listesi bulunmaktadır.';
$lang['index_username_th']                = 'Kullanıcı adı';
$lang['index_name_th']                    = 'isim';
$lang['index_fname_th']                   = 'İsim';
$lang['index_lname_th']                   = 'Soyadı';
$lang['index_email_th']                   = 'E-posta';
$lang['index_groups_th']                  = 'Gruplar';
$lang['index_status_th']                  = 'durum';
$lang['index_action_th']                  = 'Aksiyon';
$lang['index_active_link']                = 'etkinleştirmek';
$lang['index_inactive_link']              = 'Inactivate';
$lang['index_create_user_link']           = 'Yeni bir kullanıcı oluştur';
$lang['index_active_status']              = 'Aktif';
$lang['index_inactive_status']            = 'etkisiz';

// Deactivate User
$lang['deactivate_heading']                  = 'Kullanıcıyı Devre Dışı Bırak';
$lang['deactivate_subheading']               = '\ &#39;% S \&#39; kullanıcısını devre dışı bırakmak istediğinizden emin misiniz?';
$lang['deactivate_confirm_y_label']          = 'Evet';
$lang['deactivate_confirm_n_label']          = 'Yok hayır';
$lang['deactivate_submit_btn']               = 'Gönder';
$lang['deactivate_validation_confirm_label'] = 'Onayla';
$lang['deactivate_validation_user_id_label'] = 'kullanıcı adı';

// Create User
$lang['create_user_heading']                           = 'Kullanıcı oluştur';
$lang['create_user_subheading']                        = 'Lütfen kullanıcının bilgilerini aşağıda giriniz.';
$lang['create_user_fname_label']                       = 'İsim';
$lang['create_user_lname_label']                       = 'Soyadı';
$lang['create_user_company_label']                     = 'Şirket Adı';
$lang['create_user_identity_label']                    = 'Kimlik';
$lang['create_user_email_label']                       = 'E-posta';
$lang['create_user_phone_label']                       = 'Telefon';
$lang['create_user_password_label']                    = 'Parola';
$lang['create_user_password_confirm_label']            = 'Şifreyi Onayla';
$lang['create_user_submit_btn']                        = 'Kullanıcı oluştur';
$lang['create_user_validation_fname_label']            = 'İsim';
$lang['create_user_validation_lname_label']            = 'Soyadı';
$lang['create_user_validation_identity_label']         = 'Kimlik';
$lang['create_user_validation_email_label']            = 'E';
$lang['create_user_validation_phone_label']            = 'Telefon';
$lang['create_user_validation_company_label']          = 'Şirket Adı';
$lang['create_user_validation_password_label']         = 'Parola';
$lang['create_user_validation_password_confirm_label'] = 'Şifre onayı';

// Edit User
$lang['edit_user_heading']                           = 'Kullanıcıyı Düzenle';
$lang['edit_user_subheading']                        = 'Lütfen kullanıcının bilgilerini aşağıda giriniz.';
$lang['edit_user_fname_label']                       = 'İsim';
$lang['edit_user_lname_label']                       = 'Soyadı';
$lang['edit_user_company_label']                     = 'Şirket Adı';
$lang['edit_user_email_label']                       = 'E-posta';
$lang['edit_user_phone_label']                       = 'Telefon';
$lang['edit_user_password_label']                    = 'Parola';
$lang['edit_user_password_confirm_label']            = 'Şifreyi Onayla';
$lang['edit_user_password_help']                     = 'Şifre değiştiriliyorsa';
$lang['edit_user_groups_heading']                    = 'Grup üyesi';
$lang['edit_user_submit_btn']                        = 'Kullanıcıyı Kaydet';
$lang['edit_user_validation_fname_label']            = 'İsim';
$lang['edit_user_validation_lname_label']            = 'Soyadı';
$lang['edit_user_validation_email_label']            = 'E';
$lang['edit_user_validation_phone_label']            = 'Telefon';
$lang['edit_user_validation_company_label']          = 'Şirket Adı';
$lang['edit_user_validation_groups_label']           = 'Gruplar';
$lang['edit_user_validation_password_label']         = 'Parola';
$lang['edit_user_validation_password_confirm_label'] = 'Şifre onayı';

// Change Password
$lang['change_password_heading']                               = 'Şifre değiştir';
$lang['change_password_old_password_label']                    = 'eski şifre';
$lang['change_password_new_password_label']                    = 'Yeni Parola (en az% s karakter uzunluğunda)';
$lang['change_password_new_password_confirm_label']            = 'Yeni şifreyi onayla';
$lang['change_password_submit_btn']                            = 'Değişiklik';
$lang['change_password_validation_old_password_label']         = 'eski şifre';
$lang['change_password_validation_new_password_label']         = 'Yeni Şifre';
$lang['change_password_validation_new_password_confirm_label'] = 'Yeni şifreyi onayla';

// Forgot Password
$lang['forgot_password_heading']                 = 'Parolanızı mı unuttunuz';
$lang['forgot_password_subheading']              = 'Şifrenizi sıfırlamak için size bir e-posta gönderebilmemiz için lütfen% s adresini girin.';
$lang['forgot_password_identity_not_found']      = 'Kimlik bulunamadı.';
$lang['forgot_password_email_label']             = '% S:';
$lang['forgot_password_submit_btn']              = 'Gönder';
$lang['forgot_password_validation_email_label']  = 'E';
$lang['forgot_password_identity_label']          = 'Kullanıcı adı';
$lang['forgot_password_email_identity_label']    = 'E-posta';
$lang['forgot_password_email_not_found']         = 'Bu e-posta adresinin kaydı yok.';

// Reset Password
$lang['reset_password_heading']                               = 'Şifre değiştir';
$lang['reset_password_new_password_label']                    = 'Yeni Parola (en az% s karakter uzunluğunda):';
$lang['reset_password_new_password_confirm_label']            = 'Yeni şifreyi onayla:';
$lang['reset_password_submit_btn']                            = 'Değişiklik';
$lang['reset_password_validation_new_password_label']         = 'Yeni Şifre';
$lang['reset_password_validation_new_password_confirm_label'] = 'Yeni şifreyi onayla';

// Account Creation
$lang['account_creation_successful']            = 'Hesap başarıyla oluşturuldu';
$lang['account_creation_unsuccessful']          = 'Hesap Oluşturulamadı';
$lang['account_creation_duplicate_email']       = 'E-posta Zaten Kullanılmış veya Geçersiz';
$lang['account_creation_duplicate_identity']    = 'Kimlik Zaten Kullanılmış veya Geçersiz';
$lang['account_creation_missing_default_group'] = 'Varsayılan grup ayarlanmadı';
$lang['account_creation_invalid_default_group'] = 'Geçersiz varsayılan grup adı seti';


// Password
$lang['password_change_successful']          = 'Şifre başarıyla değiştirildi';
$lang['password_change_unsuccessful']        = 'Parola Değiştirilemiyor';
$lang['forgot_password_successful']          = 'Parola Sıfırla Gönderilen E-posta';
$lang['forgot_password_unsuccessful']        = 'Parola Sıfırlanamadı';

// Activation
$lang['activate_successful']                 = 'Hesap Etkinleştirildi';
$lang['activate_unsuccessful']               = 'Hesap etkinleştirilemiyor';
$lang['deactivate_successful']               = 'Hesap De-Activated';
$lang['deactivate_unsuccessful']             = 'Hesabın Etkinliğini Kaldıramıyor';
$lang['activation_email_successful']         = 'Etkinleştirme E-postası Gönderildi. Lütfen gelen kutunuzu veya spam&#39;inizi kontrol edin';
$lang['activation_email_unsuccessful']       = 'Etkinleştirme E-postası Gönderilemiyor';

// Login / Logout
$lang['login_successful']                    = 'Başarıyla Giriş Yapıldı';
$lang['login_unsuccessful']                  = 'Yanlış giriş';
$lang['login_unsuccessful_not_active']       = 'Hesap devre dışı';
$lang['login_timeout']                       = 'Geçici olarak kilitlendi. Daha sonra tekrar deneyin.';
$lang['logout_successful']                   = 'Başarıyla Çıkış Yapıldı';

// Account Changes
$lang['update_successful']                   = 'Hesap Bilgileri Başarıyla Güncellendi';
$lang['update_unsuccessful']                 = 'Hesap Bilgileri Güncelleştirilemiyor';
$lang['delete_successful']                   = 'Kullanıcı Silindi';
$lang['delete_unsuccessful']                 = 'Kullanıcı Silinemiyor';

// Groups
$lang['group_creation_successful']           = 'Grup başarıyla oluşturuldu';
$lang['group_already_exists']                = 'Grup adı zaten alındı';
$lang['group_update_successful']             = 'Grup ayrıntıları güncellendi';
$lang['group_delete_successful']             = 'Grup silindi';
$lang['group_delete_unsuccessful']           = 'Grup silinemiyor';
$lang['group_delete_notallowed']             = 'Yönetici \ &#39;grubu silinemez';
$lang['group_name_required']                 = 'Grup adı zorunlu bir alandır';
$lang['group_name_admin_not_alter']          = 'Yönetici grubu adı değiştirilemez';

// Password Strength
$lang['pass_strength_general']               = "Parolanın aşağıdaki özelliklere sahip olması gerekir:";
$lang['pass_strength_minlength']             = "At leaset {{minlength}} characters";
$lang['pass_strength_number']                = "En az bir numara";
$lang['pass_strength_capital']               = "En az bir büyük harf";
$lang['pass_strength_special']               = "En az bir özel karakter";

// Emails
$lang['email_caution']                       = '<b>Dikkat</b> Bağlantı sadece bir kez kullanılabilir. İkinci kez yönlendirmeye çalışırsanız bir hata görünecektir. Herhangi bir sorunuz varsa lütfen şu adresteki desteğimize e-posta atın:';
$lang['email_automatic']                     = 'Not: Bu mektup otomatik olarak oluşturuldu ve gönderildi ve herhangi bir yanıt gerektirmedi.';
$lang['email_copyright']                     = 'Telif hakkı ©% s% s, Tüm hakları mahfuzdur.';

// Activation Email
$lang['email_activation_subject']            = 'Hesap Aktivasyonu';
$lang['email_activate_heading']              = 'Tebrikler!';
$lang['email_activate_subheading']           = 'Merhaba, <b>% s</b> , başarıyla <i>% s</i> kayıt yaptın. <br> Hesabınızı etkinleştirmek için lütfen kayıt işleminizi onaylayın.';
$lang['email_activate_link']                 = 'Kaydı onayla';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Unutulan Parola Doğrulaması';
$lang['email_forgot_password_heading']       = 'Merhaba% s,';
$lang['email_forgot_password_subheading']    = 'Şifrenizi sıfırlama talebi aldık. <br> Kullanıcı adınız <b>% s</b> .';
$lang['email_forgot_password_link']          = 'Şifreyi yenile';

// New Password Email
$lang['email_new_password_subject']          = 'Yeni Şifre';
$lang['email_new_password_heading']          = 'Yeni Şifre';
$lang['email_new_password_subheading']       = 'Şifreniz şu tarihlere sıfırlandı:';

// Invoice Email
$lang['emails']                              = 'E-postalar';
$lang['email_to']                            = "için";
$lang['email_subject']                       = "konu";
$lang['email_cc']                            = "CC";
$lang['email_bcc']                           = "BCC";
$lang['show_hide_cc_bcc']                    = "CC ve BCC&#39;yi Göster / Gizle";
$lang['send_email']                          = "Eposta gönder";
$lang['emails_list']                         = 'E-postalar';
$lang['send']                                = 'göndermek';
$lang['additional_content']                  = 'Ek İçerik';
$lang['emails_example']                      = 'Ör: contact@sis.com, info@sis.com ...';
$lang['email_invoice_subject']               = '% S&#39;dan fatura paketi';
$lang['email_invoice_heading']               = 'Selamlar !';
$lang['email_invoice_subheading']            = '<b>% S</b> adresinden bir fatura aldınız. <br> Bir PDF dosyası eklenmiştir.';
$lang['email_successful']                    = 'E-posta gönderildi. Lütfen gelen kutunuzu veya spam&#39;inizi kontrol edin';
$lang['email_unsuccessful']                  = 'E-posta Gönderilemiyor, e-posta yapılandırmanızı kontrol edin!';


$lang['email_dear']                          = 'Sayın %s ,';
$lang['send_payments_reminder']              = 'Ödemeleri gönder hatırlatıcı gönder';
$lang['no_unpaid_invoies']                   = "bu müşterinin ödenmemiş faturaları yok!";
$lang['email_rinvoice_subject']              = 'Şuradan yeni fatura %s ';
$lang['email_rinvoice_subheading']           = 'Şuradan yeni bir ödenmemiş fatura aldınız: %s .';
$lang['email_unpaid_subject']                = 'Gönderdiğiniz ödenmemiş faturanız var %s ';
$lang['email_unpaid_invoices']               = 'Var %s ödenmemiş faturalar.';
$lang['email_overdue_subject']               = 'Faturanızın gecikmiş olması %s ';
$lang['email_overdue_reminder']              = 'Ödeme tarihini kaçırmış olabilirsiniz ve fatura şimdi tarafından gecikmiştir. %s günler.';

$lang['overdue_reminder']                    = "Gecikmiş hatırlatıcı";
$lang['once_is']                             = "Fatura bittikten sonra";
$lang['days_late']                           = "günler geç";
$lang['and_every']                           = "ve her";
$lang['days_after']                          = "günler sonra";

/* --------------------------- DATATABLES --------------------------------------------- */
$lang['loading_data']               =   "Sunucudan veri yükleme";
$lang['sEmptyTable']                =   "Tablolarda sonuç bulunamadı";
$lang['no_data']                    =   "Sonuç bulunamadı !";
$lang['sInfo']                      =   "_TOTAL_ satıra _START_ ile _END_ arası görüntüleme";
$lang['sInfoEmpty']                 =   "0 satırdan 0 dan 0 gösteriliyor";
$lang['sInfoFiltered']              =   "(_MAX_ toplam girişten filtrelendi)";
$lang['sInfoPostFix']               =   "";
$lang['sInfoThousands']             =   ",";
$lang['sLengthMenu']                =   "_MENU_ satırı göster";
$lang['sLoadingRecords']            =   "Yükleniyor...";
$lang['sProcessing']                =   "İşleme...";
$lang['sSearch']                    =   "Arama";
$lang['advanced_search']            =   "gelişmiş Arama";
$lang['sZeroRecords']               =   "sonuç bulunamadı";
$lang['sFirst']                     =   "&lt;&lt;";
$lang['sLast']                      =   "&gt;&gt;";
$lang['sNext']                      =   "&gt;";
$lang['sPrevious']                  =   "&lt;";
$lang['sSortAscending']             =   ": Artan Düzenlemeyi Etkinleştir";
$lang['sSortDescending']            =   ": Aşağı Bağlantı Düzenlemeyi Etkinleştir";
$lang['colvis_buttonText']          =   "Sütunları göster / gizle";
$lang['colvis_sRestore']            =   "Orijinali geri yükle";
$lang['colvis_sShowAll']            =   "Tümünü göster";
$lang['tabletool_csv']              =   "CSV&#39;yi indirin";
$lang['tabletool_xls']              =   "Excel&#39;i indirin";
$lang['tabletool_copy']             =   "kopya";
$lang['tabletool_pdf']              =   "PDF İndir";
$lang['tabletool_text']             =   "Metin Yükle";
$lang['tabletool_print']            =   "baskı";
$lang['tabletool_print_sInfo']      =   "<H6> Baskı Önizleme </ h6><p> Lütfen bu tabloyu yazdırmak için tarayıcınızın yazdırma işlevini kullanın. İşiniz bittiğinde Esc tuşuna basın. </p>";
$lang['tabletool_print_sToolTip']   =   "Baskı görünümünü görüntüleme";
$lang['tabletool_select']           =   "seçmek";
$lang['tabletool_select_single']    =   "Tek Seç";
$lang['tabletool_select_all']       =   "Hepsini seç";
$lang['tabletool_select_none']      =   "Hepsini seç";
$lang['tabletool_ajax']             =   "Ajax Düğmesi";
$lang['tabletool_collection']       =   "İndir";
$lang['export']                     =   "İhracat";
$lang['export_csv']                 =   "CSV olarak dışa aktar";
$lang['export_xls']                 =   "Excel gibi dışa aktar";
$lang['export_pdf']                 =   "Pdf olarak dışa aktar";
$lang['export_text']                =   "Metin Olarak Dışa Aktar";
$lang['all']                        = "Herşey";

/* --------------------------- DATERANGE --------------------------------------------- */
$lang['daterange_today']            = "Bugün";
$lang['daterange_yesterday']        = "Dün";
$lang['daterange_last_7_days']      = "Son 7 gün";
$lang['daterange_last_30_days']     = "Son 30 gün";
$lang['daterange_this_month']       = "Bu ay";
$lang['daterange_last_month']       = "Geçen ay";
$lang['daterange_this_year']        = "Bu yıl";
$lang['daterange_custom']           = "Özel Menzil";
$lang['daterange_end_of_last_month']= "Geçen ayın sonu";
$lang['daterange_end_of_year']      = "Geçen yılın sonu";

$lang['error']                      = 'Hata';
$lang['success']                    = 'başarı';

// Register
$lang['register_heading']           = 'Kayıt olmak';
$lang['register_subheading']        = 'hesabını oluştur';
$lang['register_ask']               = 'Hesabın yok mu?';
$lang['register_btn']               = 'Şimdi üye Ol!';
$lang['register_username']          = 'Kullanıcı adı';
$lang['register_email']             = 'E';
$lang['register_password']          = 'Parola';
$lang['register_password_confirm']  = 'Şifreyi Onayla';
$lang['register_submit_btn']        = 'Hesap açmak';

$lang['default_group']              = 'Yeni Hesap Grubu';
$lang['enable_register']            = 'Kaydı Etkinleştir';
$lang['reference_type']             = 'Referans türü';
$lang['show_reference']             = 'Referansı Göster';
$lang['reference_type_changed']     = 'Referans türü değiştirildi! <br> Tüm faturaların referansını yeni türe sıfırlamak ister misiniz?';
$lang['generate']                   = 'üretmek';
$lang['no_invoice_items']           = 'Fatura Kalemleri gereklidir. En az 1 öğe olmalı';


$lang["loading"]                    = 'Yükleniyor...';
$lang["file"]                       = 'Dosya';
$lang["shortcut_help"]              = 'Kısayol yardımı';
$lang["shortcut_help_title"]        = 'Klavye kısayolları Yardım';
$lang["documentations"]             = 'Dokümantasyon';
$lang["about"]                      = 'hakkında';
$lang["shortcut"]                   = 'Kısayol';
$lang["main_menu"]                  = 'Ana menü';

$lang["settings_email"]             = 'E-posta Kurulumu';
$lang["configuration_email"]        = 'E-posta Ayarları';
$lang["protocol"]                   = 'Protokol';
$lang["smtp_crypto"]                = 'encription';
$lang["smtp_host"]                  = 'SMTP Sunucusu';
$lang["smtp_port"]                  = 'SMTP Bağlantı Noktası';
$lang["smtp_user"]                  = 'SMTP Kullanıcısı';
$lang["smtp_pass"]                  = 'SMTP Parolası';
$lang["mailpath"]                   = 'Posta Yolu';
$lang["settings_email_updated"]     = "E-posta ayarları başarıyla güncellendi";

// importing data
$lang['import_data']                   = "Verileri İçe Aktarma";
$lang['idata_title']                   = "Verileri İçe Aktarma";
$lang['idata_subheading']              = "Hangi verileri almak istiyorsunuz?";
$lang['idata_upload_file']             = "Dosya yükleme";
$lang['idata_upload_file_subheading']  = 'Lütfen aşağıdaki bilgileri giriniz.';
$lang['idata_match_fields']            = "Maç Alanları";
$lang['idata_match_fields_subheading'] = "Alanlarınızı uygulama alanlarına uyarlayın";
$lang['idata_confirm_data']            = "Veri onayı";
$lang['idata_confirm_data_subheading'] = "Verilerinizi onaylayın ve silin";
$lang['idata_add_to_database']         = "DataBase&#39;e Ekle";
$lang['idata_add_to_db_subheading']    = "Veritabanına ekleme ve son adım";
$lang['idata_customers']               = "Müşterileri İçe Aktarma";
$lang['idata_customers_description']   = "Müşterileri İçe Aktarma (adlar, adresler, vb.)";
$lang['idata_suppliers']               = "İthalat Tedarikçileri";
$lang['idata_suppliers_description']   = "İthalat Tedarikçileri (isimler, adresler, vb.)";
$lang['idata_ex_cats']                 = "Giderleri İçe Aktarma Kategorileri";
$lang['idata_ex_cats_description']     = "Giderleri İçe Aktarma Kategoriler (tür, etiket)";
$lang['idata_users']                   = "Kullanıcıları İçe Aktarma";
$lang['idata_users_description']       = "Kullanıcıları İçe Aktarma (kullanıcı adı, şifre, e-posta vb.)";
$lang['idata_tax_rates']               = "Vergi Oranlarının İthal Edilmesi";
$lang['idata_tax_rates_description']   = "Vergi Oranlarının İthal Edilmesi (etiket, değer ve tip)";
$lang['idata_items']                   = "Öğeleri İçe Aktarma";
$lang['idata_items_description']       = "İçe Aktarma Öğeleri (ad, açıklama, fiyat vb.)";
$lang['idata_item_cats']               = "Öğe Kategorilerini İçe Aktarma";
$lang['idata_item_cats_description']   = "Öğe Kategorilerlerini Alma (etiket)";


$lang['idata_info']                    = "Veri dosyanızın içerebileceği alanların listesi. Kalın olarak işaretli alanların doldurulması zorunludur. Özel semboller (virgül, noktalı virgül vb.) Içeren verileri içe aktarıyorsanız, lütfen bu alanların teklifle gösterildiğinden emin olun!";
$lang['idata_checklist']               = "İçe aktarmadan önce listenizi kontrol edin";
$lang['idata_file_format']             = "Kabul edilen CSV dosyalarını (* .csv) veya Excel dosyalarını (* .xls, * .xlsx) biçimlendirin";
$lang['idata_download_sample_file']    = "Nelerin içe aktarabileceğini görmek için bir örnek dosyayı indirin.";
$lang['idata_download_sample']         = "Örnek dosyayı indir";
$lang['idata_csv_delimiter']           = "CSV ayırıcı";
$lang['idata_semicolon']               = "Noktalı virgül";
$lang['idata_comma']                   = "Virgül";
$lang['idata_tab']                     = "çıkıntı";
$lang['idata_file']                    = "Dosya";
$lang['idata_max_file_size']           = "2MB veya 1000 satır maksimum boyut";
$lang['idata_delete_item']             = "Bu Ürünü Kaldır";
$lang['idata_items_are_imported']      = "Öğeler ithal edildi";
$lang['idata_item_is_imported']        = "Öğe ithal edildi";
$lang['idata_imported']                = "Verilerin aktarımı başarı ile tamamlandı";
$lang['idata_failed']                  = "Veri içe aktarma başarısız oldu Kayıtlarınızı tekrar kontrol edin!";
$lang['idata_no_data']                 = "Hiçbir veri eklemeyin, girişlerinizi tekrar kontrol edin!";


$lang["settings_db"]                   = 'Yedekler';
$lang["configuration_db"]              = 'Veri Tabanı Yedeklemeleri';
$lang["create_backup"]                 = 'Yedekleme Oluştur';
$lang["date_creation"]                 = "Oluşturulma tarihi";
$lang["filename"]                      = "Dosya adı";
$lang["restore_backup"]                = 'Yedeklemeyi Geri Yükle';
$lang["delete_backup"]                 = 'Yedeklemeyi Sil';
$lang["restore_backup_success"]        = "Veritabanı yedeklemesi başarıyla geri yüklendi";
$lang["restore_backup_failed"]         = "Veritabanı yedekleme başarısız oldu geri yükleme";
$lang["backup_deleted"]                = "Veritabanı yedeklemesi başarıyla silindi";



$lang['tax_rate']                      = "Vergi oranı";
$lang['settings_tax_rates']            = "Vergi oranları";
$lang['configuration_tax_rates']       = "Vergi oranları";
$lang["no_tax"]                        = "Vergisiz";
$lang['create_tax_rate']               = "Vergi Oranı Ekle";
$lang['tax_rate_label']                = "Vergi kodu";
$lang['tax_rate_value']                = "Oran / Tutar";
$lang['tax_rate_type']                 = "Vergi Oranı Türü";
$lang['tax_rate_default']              = "Varsayılan Vergi Oranı";
$lang['tax_rate_new']                  = "Yeni Vergi Oranı Oluştur";
$lang['tax_rate_update']               = "Vergi Oranını Güncelle";
$lang['tax_rate_added']                = "Vergi Oranı Başarıyla Eklendi";
$lang['tax_rate_updated']              = "Vergi Oranı Başarıyla Güncellendi";
$lang['tax_rate_deleted']              = "Vergi Oranı Başarıyla Silindi";
$lang['condition']                     = "Şart";
$lang['conditional_taxes']             = "Şartlı Vergiler";
$lang['conditional_taxes_subheading']  = "Postalarınıza bir vergi oranı ekleyin (fatura / tahmini), ara toplam üzerine bir şartla";
$lang['conditional_taxes_tip']         = "ex: tüm faturalara 7 TL vergi ekleme toplamı 150&#39;den büyük veya eşittir";
$lang['is_default']                    = "Varsayılan mı";
$lang['default']                       = "Varsayılan";
$lang['add_tax']                       = "Vergi ekle";
$lang['shipping']                      = "Nakliye";
$lang['condition_terms']               = "şartlar ve koşullar";
$lang['invoice_note']                  = "Fatura Notu";
$lang['note']                          = "Fatura Notu";
$lang['set_status']                    = "Durumu değiştir";
$lang['set_status_subheading']         = "Bu faturanın yeni durumunu seçin";
$lang['old_status']                    = "Eski durum";
$lang['clear_filter']                  = "Temiz filtre";
$lang['shown_columns']                 = "Etkin sütunlar";
$lang['number_format']                 = "Sayı biçimi";
$lang['round_number']                  = "Yuvarlak sayılar";
$lang['decimal_place']                 = "Ondalık basamak";
$lang['disabled']                      = "engelli";
$lang['enabled']                       = "Etkin";
$lang['apply_to_subtotal']             = "Alt toplam beyanına başvurun";
$lang['apply_to_line']                 = "Satır öğelerine uygula";

$lang['estimate']                      = "Tahmin";
$lang['estimates']                     = "Tahminler";
$lang['estimates_subheading']          = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['estimate_no']                   = "N ° tahmin edin";
$lang['estimate_items']                = "Öğe tahmin etme";
$lang['estimate_title']                = "Başlığı tahmin et";
$lang['estimate_note']                 = "Not Tahmini";
$lang['create_estimate']               = "Tahmini oluştur";
$lang['create_estimate_subheading']    = "Yeni bir tahmin oluşturmak için lütfen aşağıdaki bilgileri girin.";
$lang['estimate_add_success']          = "Tahmini başarıyla oluşturuldu";
$lang['edit_estimate']                 = "Tahmini değiştir";
$lang['edit_estimate_subheading']      = "Bu Takdiri düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['estimate_edit_success']         = "Tahmini başarıyla güncellendi";
$lang['estimate_deleted']              = "Tahmini başarıyla silindi";
$lang['cant_delete_estimate']          = "Bu tahmini silemezsiniz !, nedeni: <br><ul><li> Bu Tahmin başka bir öğeyle ilgilidir </li></ul> Tüm öğeleri silmeniz, daha sonra tekrar denemeniz gerekir";
$lang['estimate_duplicate_success']    = "Başarıyla çoğaltılan tahmin edin";
$lang['email_estimate_subject']        = "% S&#39;den PDF tahmin edin";
$lang['no_estimate_items']             = "Tahmini Öğeler gereklidir. En az 1 öğe olmalı";
$lang['preview_estimate_error']        = "Bu tahmininizi önizlemek için lütfen gerekli tüm bilgileri giriniz.";
$lang['email_estimate_heading']        = 'Selamlar !';
$lang['email_estimate_subheading']     = '<b>% S</b> tarafından bir tahmin aldınız. <br> Bir PDF dosyası eklenmiştir.';
$lang['convert_to_invoice']            = "Fatura Dönüştür";
$lang['sent']                          = "Gönderilen";
$lang['accepted']                      = "Kabul edilmiş";
$lang['invoiced']                      = "Faturalandı";
$lang['approve']                       = "onaylamak";
$lang['reject']                        = "reddetmek";

$lang['cash']                          = "Nakit";
$lang['check']                         = "Kontrol";
$lang['bank_transfer']                 = "banka transferi";
$lang['online']                        = "İnternet üzerinden";
$lang['other']                         = "Diğer";

$lang['payment']                       = "Ödeme";
$lang['payments']                      = "Ödemeler";
$lang['payments_subheading']           = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['payments_create']               = "Ödeme oluştur";
$lang['payments_create_subheading']    = "Yeni bir Ödeme oluşturmak için lütfen aşağıdaki bilgileri girin.";
$lang['payments_create_success']       = "Ödeme başarıyla oluşturuldu";
$lang['payments_edit']                 = "Ödemeyi düzenle";
$lang['payments_edit_subheading']      = "Bu ödemeyi düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['payments_edit_success']         = "Ödeme başarıyla güncellendi";
$lang['payments_deleted']              = "Ödeme başarıyla silindi";
$lang['payment_number']                = "Ödeme numarası";
$lang['payment_details']               = "ödeme detayları";
$lang['amount']                        = "Tutar";
$lang['payment_method']                = "Ödeme şekli";
$lang['method']                        = "Yöntem";
$lang['total_paid']                    = "Toplam ödenen";
$lang['email_payment_subject']         = "Ödeme% s&#39;den PDF";
$lang['no_payment_items']              = "Ödeme Öğeleri gerekiyor. En az 1 öğe olmalı";
$lang['preview_payment_error']         = "Bu ödemeyi önizlemek için lütfen gerekli tüm bilgileri giriniz.";
$lang['email_payment_heading']         = 'Selamlar !';
$lang['email_payment_subheading']      = '<b>%</b> S&#39;dan bir ödeme aldınız. <br> Bir PDF dosyası eklenmiştir.';
$lang['payment_for']                   = "İçin ödeme";
$lang['set_status_payment_subheading'] = "Bu ödeme makbuzunun yeni durumunu seçin";

$lang['receipt']                       = "Ödeme makbuzu";
$lang['receipts']                      = "Ödeme makbuzları";
$lang['receipt_no']                    = "Ödeme makbuzu N °";
$lang['receipt_for']                   = "Için makbuz";
$lang['create_receipt']                = "makbuz yarat";
$lang['receipts_create']               = "Makbuz oluştur";
$lang['receipts_create_subheading']    = "Yeni bir makbuz yapmak için lütfen aşağıdaki bilgileri giriniz.";
$lang['receipts_edit']                 = "Makbuzu düzenle";
$lang['receipts_edit_subheading']      = "Bu makbuzu düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['receipts_create_success']       = "Makbuz başarıyla oluşturuldu";
$lang['receipts_edit_success']         = "Makbuz başarıyla güncellendi";
$lang['receipts_deleted']              = "Makbuz başarıyla silindi";


// PAYMENTS ONLINE
$lang['payments_online']               = "Çevrimiçi ödemeler";
$lang['general']                       = "Genel";
$lang['paypal']                        = "Paypal";
$lang['stripe']                        = "Stripe";
$lang['twocheckout']                   = "2Checkout";
$lang['mobilpay']                      = "MobilPay";
$lang['payments_online_requirements']  = "Bu sunucunun çevrimiçi ödemeleri etkinleştirmek için minimum şartları yok!";
$lang['payments_online_enable']        = "etkinleştirme";
$lang['biller_accounts']               = "Biller hesabı";
$lang['enable']                        = "etkinleştirme";
$lang['username']                      = "Kullanıcı adı";
$lang['password']                      = "Parola";
$lang['sandbox']                       = "kum havuzu";
$lang['enable']                        = "etkinleştirme";
$lang['api_key']                       = "Api anahtarı";
$lang['enable']                        = "etkinleştirme";
$lang['account_number']                = "Hesap numarası";
$lang['secretWord']                    = "Gizli kelime";
$lang['merchant_id']                   = "Tüccar kimliği";
$lang['public_key']                    = "Genel anahtar";
$lang['test_mode']                     = "Test modu";
$lang['panding']                       = "kadar";
$lang['released']                      = "Yayınlandı";
$lang['active']                        = "Aktif";
$lang['expired']                       = "Süresi doldu";
$lang['finished']                      = "bitirdi";
$lang['payment_released']              = "Ödeme başarıyla yayınlandı";
$lang['payment_canceled']              = "Ödeme iptal edildi";



$lang['credit_card']                   = "Kredi kartı";
$lang['credit_card_firstName']         = "İsim";
$lang['credit_card_lastName']          = "Soyadı";
$lang['credit_card_number']            = "Kredi Kartı Numarası";
$lang['credit_card_expiryMonth']       = "Son Kullanma Ayı";
$lang['credit_card_expiryYear']        = "Son Kullanma Yılı";
$lang['credit_card_cvv']               = "CVV / CVC";

$lang["settings_po_updated"]           = "Çevrimiçi ödeme ayarları başarıyla güncellendi";

$lang['custom_field']                  = "Özel alan";
$lang['custom_fields']                 = "Özel Alanlar";
$lang['custom_field_label']            = "Özel alan etiketi";
$lang['custom_field_value']            = "Özel alan değeri";
$lang['customer_cf']                   = "Müşteri özel alanları";
$lang['custom_field_1']                = "Özel alan1";
$lang['custom_field_2']                = "Özel alan2";
$lang['custom_field_3']                = "Özel alan3";
$lang['custom_field_4']                = "Özel alan4";
$lang['vat_number']                    = "KDV Numarası";
$lang['vat_number_placeholder']        = "KDV tanımlama numarası";



// CUSTOMERS
$lang['customer_bill_to']             = 'ya fatura edilecek';
$lang['customer']                     = 'müşteri';
$lang['customers']                    = 'Müşteriler';
$lang['customer_add_success']         = "Müşteri başarıyla eklendi";
$lang['customer_edit_success']        = "Müşteri başarıyla güncellendi";
$lang['customer_deleted']             = "Müşteri başarıyla silindi";
$lang['cant_delete_customer']         = "Bu müşteriyi silemezsin !, nedeni: <br><ul><li> Bu müşteri başka bir faturayla ilişkili </li></ul> Tüm faturalarını silmeniz, ardından tekrar deneyin.";
$lang['customers_subheading']         = 'Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.';
$lang['create_customer']              = 'Müşteri ekle';
$lang['edit_customer']                = "Müşteriyi düzenle";
$lang['details_customer']             = "Müşteri Ayrıntıları";
$lang['create_customer_subheading']   = "Yeni bir müşteri eklemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['edit_customer_subheading']     = "Bu müşteriyi düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['profile_customer']             = "Müşteri Profili";
$lang['profile']                      = "Profil";
$lang['edit_customer_account']        = "Hesabı düzenlemek";
$lang['create_customer_account']      = "Hesap açmak";
$lang['account_created']              = "Müşteri hesabı başarıyla oluşturuldu";
$lang['account_username']             = "Hesap kullanıcı adı";
$lang['account_status']               = "hesap durumu";


// SUPPLIERS
$lang['supplier_bill_to']             = 'Faturası';
$lang['supplier']                     = 'satıcı';
$lang['suppliers']                    = 'Tedarikçiler';
$lang['supplier_add_success']         = "Tedarikçi başarıyla eklendi";
$lang['supplier_edit_success']        = "Tedarikçi başarıyla güncellendi";
$lang['supplier_deleted']             = "Tedarikçi başarıyla silindi";
$lang['cant_delete_supplier']         = "Bu tedarikçiyi silemezsiniz !, neden: <br><ul><li> Bu Tedarikçi başka bir faturayla ilişkili </li></ul> Tüm faturalarını silmeniz, ardından tekrar deneyin.";
$lang['suppliers_subheading']         = 'Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.';
$lang['create_supplier']              = 'Tedarikçi ekle';
$lang['edit_supplier']                = "Tedarikçiyi düzenle";
$lang['details_supplier']             = "Tedarikçi Ayrıntıları";
$lang['create_supplier_subheading']   = "Yeni bir tedarikçi eklemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['edit_supplier_subheading']     = "Bu tedarikçiyi düzenlemek için aşağıdaki bilgileri giriniz.";

// ITEMS
$lang['item']                     = 'madde';
$lang['items']                    = "Öğeler";
$lang['price']                    = 'Fiyat';
$lang['default_tax']              = 'Varsayılan Vergisi';
$lang['default_discount']         = 'Varsayılan İndirim';
$lang['item_add_success']         = "Öğe başarıyla eklendi";
$lang['item_edit_success']        = "Öğe başarıyla güncellendi";
$lang['item_deleted']             = "Öğe başarıyla silindi";
$lang['cant_delete_item']         = "Bu öğeyi silemezsiniz !, nedeni: <br><ul><li> Bu öğe başka bir faturayla alâkalı </li></ul> Tüm faturalarını silmeniz, ardından tekrar deneyin.";
$lang['items_subheading']         = 'Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.';
$lang['create_item']              = 'Öğe eklemek';
$lang['edit_item']                = "Ögeyi düzenle";
$lang['details_item']             = "Ürün Ayrıntıları";
$lang['create_item_subheading']   = "Yeni bir öğe eklemek için lütfen aşağıdaki bilgileri girin.";
$lang['edit_item_subheading']     = "Bu maddeyi düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['prices']                   = "Fiyatlar";
$lang['unit']                     = "birim";
$lang['add_new_price']            = "Yeni fiyat ekle";
$lang['no_item_prices']           = "Ürün fiyatları gereklidir. Bu öğe için en az 1 fiyat olmalıdır";
$lang['category']                 = "Kategori";
$lang['categories']               = "Kategoriler";
$lang['items_categories']         = "Kategoriler";
$lang['category_create']          = "Yeni Kategori Oluştur";
$lang['category_update']          = "Kategoriyi Güncelle";
$lang['category_added']           = "Kategori başarıyla eklendi";
$lang['category_updated']         = "Kategori başarıyla güncellendi";
$lang['category_deleted']         = "Kategori başarıyla silindi";


$lang['invoices_activities']      = "Fatura Aktiviteleri";
$lang['estimates_activities']     = "Etkinlikler Tahmini";
$lang['activities']               = "faaliyetler";


$lang['files']                    = "Dosyalar";
$lang['files_subheading']         = "Files_subheading";
$lang['file_rename']              = "Dosya / klasörü yeniden adlandırma";
$lang['create_folder']            = "Klasör oluşturun";
$lang['file_move_to']             = "Hareket";
$lang['files_view']               = "Önizleme";
$lang['files_share']              = "Pay";
$lang['file_deleted']             = "Dosya başarıyla silindi";
$lang['file_moved_trash']         = "Dosya başarıyla çöp kutusuna taşındı";
$lang['file_restored']            = "Dosya başarıyla geri yüklendi";
$lang['cant_delete_file']         = "Bu dosyayı silemezsiniz!";
$lang['file_rename_success']      = "Dosya / klasör başarıyla yeniden adlandırıldı";
$lang['file_moved_success']       = "Dosya / klasör başarıyla taşındı";
$lang['create_folder_success']    = "Klasör başarıyla oluşturuldu";
$lang['filename']                 = "Dosya adı";
$lang['size']                     = "Boyut";
$lang['file_type']                = "Dosya tipi";
$lang['upload_date']              = "yükleme tarihi";
$lang['gohome']                   = "Eve git";
$lang['goback']                   = "Geri dön";
$lang['open_trash']               = "Çöp Kutusu&#39;nu aç";
$lang['delete_definitive']        = "Kesin olanı sil";
$lang['restore_file']             = "Dosyayı geri yükle";
$lang['grid']                     = "Izgara görünümü";
$lang['list']                     = "Liste görünümü";
$lang['sort']                     = "Çeşit";
$lang['upload']                   = "Yükleme";
$lang['share']                    = "Pay";
$lang['copylink']                 = "Linki kopyala";
$lang['copy']                     = "kopya";
$lang['move_to']                  = "Taşınmak";
$lang['move']                     = "Hareket";
$lang['rename']                   = "Adını değiştirmek";
$lang['foldername']               = "Klasör adı";
$lang['folder']                   = "Klasör";
$lang['text_is_copied']           = "Metin panoya kopyalanır";
$lang['no_file_selected']         = "Yüklenecek dosya seçilmedi!";
$lang['browse_files']             = "Dosyalara Gözat";
$lang['confirm']                  = "Onaylamak";
$lang['dimensions']               = "boyutlar";
$lang['duration']                 = "süre";
$lang['crop']                     = "ekin";
$lang['rotate']                   = "Döndürme";
$lang['choose']                   = "Seçmek";
$lang['to_upload']                = "yüklemek";
$lang['files_were']               = "dosyalar vardı";
$lang['file_was']                 = "dosya yapıldı";
$lang['chosen']                   = "seçilmiş";
$lang['drag_drop_file']           = "Dosyaları buraya sürükle ve bırak";
$lang['or']                       = "veya";
$lang['drop_file']                = "Dosyaları buraya bırakıp yükle";
$lang['paste_file']               = "Bir dosyayı yapıştırarak iptal etmek için burayı tıklayın.";
$lang['remove_confirmation']      = "Bu dosyayı kaldırmak istediğinizden emin misiniz?";
$lang['folder']                   = "Klasör";
$lang['filesLimit']               = "Bir tek %s dosyaların yüklenmesine izin verilir.";
$lang['filesType']                = "Bir tek %s dosyaların yüklenmesine izin verilir.";
$lang['fileSize']                 = "çok büyük! Lütfen en fazla bir dosya seçin %s MB.";
$lang['filesSizeAll']             = "Seçtiğiniz dosyalar çok büyük! Lütfen dosyaları yükleyin %s MB.";
$lang['fileName']                 = "Ada sahip dosya %s zaten seçilmiş. &#39;";
$lang['folderUpload']             = "Klasör yüklemenize izin verilmiyor.";
$lang['no_more_space']            = "Bu dosyaları yüklemek için daha fazla yer yok!";
$lang['add_attached_file']        = "Dosya eki";
$lang['uploader']                 = "evraklar";
$lang['settings_files']           = "Ayarlar yükleyici";
$lang['configuration_files']      = "Yapılandırma dosyası yükleniyor";
$lang['file_upload_enable']       = "dosya yüklemeyi etkinleştir";
$lang['user_disc_space']          = "Kullanıcı disk alanı";
$lang['user_disc_space_tip']      = "Her kullanıcının dosyaları ne kadar alana sunucunuza almasına izin verilir (megabayt olarak).";
$lang['max_upload_size']          = "Maksimum yükleme boyutu";
$lang['max_upload_size_tip']      = "Kullanıcıların yükleyebilecekleri maksimum dosya boyutu (megabayt olarak).";
$lang['max_simult_uploads']       = "Maksimum eş zamanlı yüklemeler.";
$lang['max_simult_uploads_tip']   = "Kullanıcının kaç tane dosyayı aynı anda yükleyebileceğini.";
$lang['white_list']               = "Beyaz liste";
$lang['white_list_tip']           = "Kullanıcılar yalnızca bu biçimlerdeki dosyaları yükleyebilecek. Örnek: mp4, jpg, mp3, pdf.";
$lang["settings_files_updated"]   = "Dosya ayarları başarıyla güncellendi";

$lang['send_link_via_email']      = "Bu bağlantıyı e-postayla gönder";
$lang['links']                    = "Bağlantılar";
$lang['view_link']                = "Bağlantıyı görüntüle";
$lang['direct_link']              = "Doğrudan bağlantı";
$lang['download_link']            = "İndirme linki";
$lang['html_embed_code']          = "Html embed kodu";
$lang['forum_embed_code']         = "Forum embed kodu";
$lang['email_file_subject']       = "Dosyasından %s ";

$lang['folder']                   = "Klasör";
$lang['folder']                   = "Klasör";
$lang['folder']                   = "Klasör";
$lang['folder']                   = "Klasör";
$lang['folder']                   = "Klasör";


// RECURRING INVOICES
$lang['rinvoice']                      = "Tekrarlayan Fatura";
$lang['rinvoices']                     = "Tekrarlayan Faturalar";
$lang['rinvoices_subheading']          = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['recu_invoice_schedule']         = "Tekrarlayan faturalandırma çizelgesi";
$lang['frequency']                     = "Sıklık";
$lang['every']                         = "Her";
$lang['occurences']                    = "tekrar sonrasında";
$lang['daily']                         = "Günlük";
$lang['weekly']                        = "Haftalık";
$lang['monthly']                       = "Aylık";
$lang['yearly']                        = "Yıllık";
$lang['day']                           = "Gün";
$lang['days']                          = "günler";
$lang['week']                          = "Hafta";
$lang['weeks']                         = "Haftalar";
$lang['month']                         = "Ay";
$lang['months']                        = "aylar";
$lang['year']                          = "Yıl";
$lang['years']                         = "yıl";
$lang['recu_when_start']               = "Otomatik Zamanlama ne zaman başlayacak?";
$lang['recu_when_create']              = "Faturalar ne zaman yaratılır?";
$lang['invoice_will_every']            = "Her fatura oluşturulacak";
$lang['on']                            = "üzerinde";
$lang['on_the']                        = "üzerinde";
$lang['forever']                       = "Sonsuza dek";
$lang['for']                           = "için";
$lang['occurence_time']                = "1 kez";
$lang['occurence_times']               = "zamanlar";
$lang['recurring_effective']           = "Tekrarlayan etkili";
$lang['package_name']                  = "Paket ismi";
$lang['create_rinvoice']               = "Tekrarlayan fatura yarat";
$lang['create_rinvoice_subheading']    = "Yeni bir Yinelenen Fatura oluşturmak için lütfen aşağıdaki bilgileri giriniz.";
$lang['rinvoice_is_canceled']          = "Bu tekrarlanan fatura iptal edildi, düzenleyemezsiniz!";
$lang['edit_rinvoice']                 = "Tekrarlayan faturayı düzenle";
$lang['edit_rinvoice_subheading']      = "Bu Yinelenen Fatura düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['rinvoices_activities']          = "Yinelenen fatura etkinlikleri";
$lang['rinvoice_add_success']          = "Tekrarlayan fatura başarıyla oluşturuldu";
$lang['rinvoice_edit_success']         = "Yinelenen fatura başarıyla güncellendi";
$lang['rinvoice_deleted']              = "Yinelenen fatura başarıyla silindi";
$lang['cant_delete_rinvoice']          = "Bu Yinelenen faturayı silemezsiniz !, nedeni: <br><ul><li> Bu Yinelenen fatura başka bir öğeyle alâkalı </li></ul> Tüm öğeleri silmeniz, ardından tekrar deneyin.";
$lang['rinvoice_duplicate_success']    = "Tekrarlayan fatura başarıyla çoğaltıldı";
$lang['rinvoice_started']              = "Tekrarlayan fatura profili başarıyla başlatıldı";
$lang['rinvoice_canceled']             = "Tekrarlayan fatura profili iptal edildi";
$lang['rinvoice_skipped']              = "Tekrarlayan fatura sonraki faturayı başarıyla atladı";
$lang['start_profile']                 = "Profili başlat";
$lang['cancel_profile']                = "Profili iptal et";
$lang['skip_next_invoice']             = "Sonraki faturayı atla";
$lang['scheduled']                     = "tarifeli";
$lang['skipped']                       = "atlandı";
$lang['this_invoice_skipped']          = "Bu fatura atlandı";
$lang['next_billing_date']             = "Sonraki faturalandırma tarihi";
$lang['today']                         = "Bugün";
$lang['cronjob_desactivated']          = "tekrarlayan faturaları etkinleştirmek için bu komutu eklemelisiniz %s CPanel&#39;deki cron işinde";
$lang['rinvoice_draft']                = "Her bir olayda faturayı taslak olarak kaydedin";
$lang['rinvoice_sent']                 = "Her bir olayda faturayı müşteriye doğrudan e-postayla gönderin";


// contracts
$lang['contract']                      = "sözleşme";
$lang['contracts']                     = "Sözleşmeler";
$lang['contracts_subheading']          = "Please use the table below to navigate or filter the results. ";
$lang['create_contract']               = "Yeni Sözleşme Yarat";
$lang['create_contract_subheading']    = "Yeni bir Sözleşme oluşturmak için lütfen aşağıdaki bilgileri girin.";
$lang['edit_contract']                 = "Sözleşmeyi Düzenle";
$lang['edit_contract_subheading']      = "Bu Sözleşmeyi düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['contract_add_success']          = "Sözleşme faturası başarıyla oluşturuldu";
$lang['contract_edit_success']         = "Sözleşme faturası başarıyla güncellendi";
$lang['contract_deleted']              = "Sözleşme faturası başarıyla silindi";
$lang['cant_delete_contract']          = "Bu Sözleşmeyi silemezsiniz!, Nedeni: <br><ul><li> Bu Yinelenen fatura başka bir öğeyle alâkalı </li></ul> Tüm öğeleri silmeniz, ardından tekrar deneyin.";
$lang['subject']                       = "konu";
$lang['contract_type']                 = "sözleşme tipi";
$lang['contract_value']                = "Sözleşme Bedeli";
$lang['contract_description']          = "Varsayılan Sözleşme açıklaması";
$lang['email_contract_subject']        = "Şuradan sözleşme PDF&#39;si %s ";
$lang['email_contract_heading']        = 'Selamlar !';
$lang['email_contract_subheading']     = 'Şuradan bir sözleşme aldınız: %s . <br> Bir PDF dosyası eklenmiştir.';


// Expenses
$lang['expense']                       = "gider";
$lang['expenses']                      = "giderler";
$lang['expenses_subheading']           = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['expenses_create']               = "Yeni Masraf Yarat";
$lang['expenses_create_subheading']    = "Yeni bir Gider oluşturmak için lütfen aşağıdaki bilgileri girin.";
$lang['expenses_edit']                 = "Masrafı Düzenle";
$lang['expenses_edit_subheading']      = "Bu masrafı düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['expenses_create_success']       = "Gider başarıyla oluşturuldu";
$lang['expenses_edit_success']         = "Gider başarıyla güncellendi";
$lang['expenses_deleted']              = "Masraf başarıyla silindi";
$lang['category']                      = "Kategori";
$lang['attachments']                   = "Ekler";
$lang['download_attachments']          = "Ekleri İndir";
$lang['invoice_number']                = "Fatura numarası";
$lang['expense_number']                = "Gider Numarası";
$lang['expenses_category']             = "Kategori";
$lang['expenses_categories']           = "Kategoriler";
$lang['expenses_subheading']           = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['expenses_category_create']      = "Yeni Kategori Oluştur";
$lang['expenses_category_update']      = "Kategoriyi Düzenle";
$lang['expenses_category_added']       = "Kategori başarıyla oluşturuldu";
$lang['expenses_category_updated']     = "Kategori başarıyla güncellendi";
$lang['expenses_category_deleted']     = "Kategori başarıyla silindi";
$lang['expenses_category_type']        = "tip";
$lang['expenses_category_label']       = "Etiket";
$lang['expense_no']                    = "N ° Gideri";



$lang['amount_in_words']         = 'Kelime miktarı';
$lang['nbr_conjunction']         = 've';
$lang['nbr_negative']            = 'negatif';
$lang['nbr_decimal']             = 'puan';
$lang['nbr_separator']           = ',';
$lang['nbr_inversed']            = false;
$lang['nbr_0']                   = 'sıfır';
$lang['nbr_1']                   = 'bir';
$lang['nbr_2']                   = 'iki';
$lang['nbr_3']                   = 'üç';
$lang['nbr_4']                   = 'dört';
$lang['nbr_5']                   = 'beş';
$lang['nbr_6']                   = 'altı';
$lang['nbr_7']                   = 'Yedi';
$lang['nbr_8']                   = 'sekiz';
$lang['nbr_9']                   = 'dokuz';
$lang['nbr_10']                  = 'on';
$lang['nbr_11']                  = 'on bir';
$lang['nbr_12']                  = 'on iki';
$lang['nbr_13']                  = 'on üç';
$lang['nbr_14']                  = 'on dört';
$lang['nbr_15']                  = 'onbeş';
$lang['nbr_16']                  = 'on altı';
$lang['nbr_17']                  = 'on yedi';
$lang['nbr_18']                  = 'onsekiz';
$lang['nbr_19']                  = 'on dokuz';
$lang['nbr_20']                  = 'yirmi';
$lang['nbr_30']                  = 'otuz';
$lang['nbr_40']                  = 'kırk';
$lang['nbr_50']                  = 'elli';
$lang['nbr_60']                  = 'altmış';
$lang['nbr_70']                  = 'yetmiş';
$lang['nbr_80']                  = 'seksen';
$lang['nbr_90']                  = 'doksan';
$lang['nbr_100']                 = 'yüz';
$lang['nbr_200']                 = 'iki yüz';
$lang['nbr_300']                 = 'üç yüz';
$lang['nbr_400']                 = 'dort yuz';
$lang['nbr_500']                 = 'beş yüz';
$lang['nbr_600']                 = 'altı yüz';
$lang['nbr_700']                 = 'yedi yüz';
$lang['nbr_800']                 = 'sekiz yüz';
$lang['nbr_900']                 = 'dokuz yüz';
$lang['nbr_1000']                = 'bin';
$lang['nbr_1000000']             = 'milyon';
$lang['nbr_1000000000']          = 'milyar';
$lang['nbr_1000000000000']       = 'trilyon';
$lang['nbr_1000000000000000']    = 'katrilyon';
$lang['nbr_1000000000000000000'] = 'kentilyon';


$lang['report']                    = "Report";
$lang['reports']                   = "Raporlar";
$lang['report_no_data']            = "Bu dönem için hiç veri yok. Lütfen tarihi ayarla";
$lang['profit']                    = "kâr";
$lang['income']                    = "Gelir";
$lang['spending']                  = "harcama";
$lang['total_spending']            = "Toplam harcama";
$lang['outstanding_revenue']       = "Üstün gelir";
$lang['total_outstanding']         = "Olağanüstü toplam";
$lang['total_profit']              = "Toplam kar";
$lang['total_profit']              = "Toplam kar";
$lang['accounts_aging']            = "Yaşlanma Hesapları";
$lang['accounts_aging_subheading'] = "Müşterilerin ödemeleri uzun sürdüğünü öğrenin.";
$lang['no_aging_accounts']         = "Geçici müşteri bulunamadı. Lütfen tarihi ayarla.";
$lang['as_of']                     = "Itibarıyla";
$lang['aging_age1']                = "00 - 30 Günler";
$lang['aging_age2']                = "31 - 60 Günler";
$lang['aging_age3']                = "61 - 90 Gün";
$lang['aging_age4']                = "90 günden fazla";
$lang['from']                      = "itibaren";
$lang['to']                        = "için";
$lang['revenue_by_customer']       = "Müşteri Tarafından Gelir";
$lang['invoice_details']           = "Fatura detayları";
$lang['total_revenue']             = "Toplam gelir";
$lang['total_invoiced']            = "Faturalandırılan Toplam";
$lang['total_due']                 = "Vadesi gereken toplam";
$lang['total_paid']                = "Toplam ödenen";
$lang['summary']                   = "özet";
$lang['tax_summary']               = "Vergi Özeti";
$lang['tax_name']                  = "Vergi Adı";
$lang['taxable_amount']            = "Vergilendirilebilir Tutar";
$lang['net']                       = "Ağ";
$lang['profit_loss']               = "Kâr ve Zarar (grafikler)";
$lang['profit_loss_subheading']    = "Vergilerinizde nelere borçlu olduğunuzu belirlerken ve harcadığınızdan daha fazla para kazanıyorsanız yardımcı olur.";
$lang['tax_summary_subheading']    = "Satış Vergilerinde hükümete ne kadar borcu olduğunuzu belirlemenize yardımcı olur";
$lang['invoice_det_subheading']    = "Bir süre boyunca gönderdiğiniz tüm faturaların ayrıntılı bir özeti";
$lang['revenue_cust_subheading']   = "Müşteri tarafından belirli bir dönem boyunca kategorilere ayrılan gelir";


$lang['chat']                      = "Sohbet";
$lang['chat_new_message_from']     = "Yeni Mesaj";
$lang['online']                    = "İnternet üzerinden";
$lang['offline']                   = "Çevrimdışı";
$lang['delete_conversation']       = "Konuşmayı sil";
$lang['type_your_message']         = "Mesajını yaz ...";
$lang['support']                   = "Destek";
$lang['chat_support_label']        = "Destek ismi";
$lang['chat_support_id']           = "Destek yöneticisi";

$lang['tools']                     = "Araçlar";
$lang['low']                       = "Düşük";
$lang['medium']                    = "Orta";
$lang['high']                      = "Yüksek";
$lang['todo_task']                 = "Yapılacak iş";
$lang['todo_list']                 = "Yapılacaklar listesi";
$lang['priority']                  = "öncelik";
$lang['mark_as_complete']          = "Tamamlandı olarak işaretle";
$lang['create_todo']               = "Yeni Görev Yarat";
$lang['edit_todo']                 = "Görevi Düzenle";
$lang['todo_add_success']          = "Görev başarıyla oluşturuldu";
$lang['todo_edit_success']         = "Görev başarıyla güncellendi";
$lang['todo_complete_success']     = "Görev başarıyla tamamlandı";
$lang['todo_delete_success']       = "Görev başarıyla silindi";

$lang['calculator']                = "Hesap makinesi";

$lang['calendar']                  = "Hatırlatmalar Takvim";
$lang['calendar_subheading']       = "Bir hatırlatıcı eklemek / değiştirmek için lütfen tarihini tıklayın.";
$lang['create_reminder']           = "E-posta hatırlatıcısı oluştur";
$lang['create_reminder_subheading']= "Yeni bir hatırlatma eklemek için lütfen aşağıdaki bilgileri girin.";
$lang['edit_reminder']             = "E-posta hatırlatıcıyı güncelle";
$lang['edit_reminder_subheading']  = "Bu hatırlatıcıyı düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['reminder_add_success']      = "Hatırlatıcı başarıyla oluşturuldu";
$lang['reminder_edit_success']     = "Hatırlatıcı başarıyla güncellendi";
$lang['reminder_delete_success']   = "Hatırlatma başarılı bir şekilde silindi";
$lang['reminder_for']              = "Için hatırlatıcı ";
$lang['repeat']                    = "Tekrar et";
$lang['repeat_every']              = "Her defayı tekrarla";
$lang['end_date']                  = "Bitiş tarihi";
$lang['no_end']                    = "Sonsuz";
$lang['no_repeat']                 = "Tekrar yok";
$lang['reminder_subject']          = "E-posta konu";
$lang['reminder_content']          = "E-posta içeriği";
$lang['untitled_reminder']         = "İsimsiz hatırlatıcı";

$lang['notifications']             = "Bildirimler";
$lang['no_notifications']          = "0 Bildirim";

$lang['exchange']                  = "Döviz değişimi";
$lang['exchange_subheading']       = "Para birimleri oranları arasında değişiklik yapma";
$lang['result']                    = "Sonuç";
$lang['change']                    = "Değişiklik";
$lang['not_supported']             = "Desteklenmiyor";


$lang['permission']                = "izin";
$lang['permissions']               = "İzinler";
$lang['members_permission']        = "Üyeler İzinleri";
$lang['posts_level_permission']    = "Seviye izinleri yazıları";
$lang['posts_level_permission_p']  = "üyelerin hangi yazıları okuyup düzenleyebileceğini belirtin";
$lang['posts_tip']                 = "Mesajlar Faturalar, Kabul eden faturalar, Tahminler, Giderler, Sözleşmelerdir";
$lang['read_his_posts']            = "Üye tarafından oluşturulan yayınları okuma ve düzenleme";
$lang['read_all_posts']            = "Tüm yayınları okuma ve düzenleme";

$lang['customer_permission']       = "Müşterilerin İzinleri";
$lang['customer_pay_methods']      = "Ödeme yöntemleri";
$lang['customer_pay_methods_p']    = "müşterilerin hangi ödeme yöntemlerini ödeyebileceğini belirtin";
$lang['customer_pay_methods_tip']  = "Çevrimdışı yöntemler (Nakit, Çek, Banka havalesi, diğer), Çevrimiçi yöntemler: (Paypal, Stripe, 2Checkout ...)";
$lang['use_all_pay_methods']       = "Tüm ödeme yöntemlerini kullan (Çevrimiçi ve Çevrimdışı)";
$lang['use_offline_pay_methods']   = "Çevrimdışı ödeme yöntemlerini kullanma";


$lang['link']                           = "bağlantı";
$lang['overdue_days']                   = "Gecikmeli günler";
$lang['update_email_template']          = "E-posta şablonunu güncelle";
$lang['email_template_updated']         = "E-posta şablonu başarıyla güncellendi";
$lang['template_name']                  = "Şablon adı";
$lang['template']                       = "şablon";
$lang['templates']                      = "Şablonlar";
$lang['activation_code']                = "Aktivasyon kodu";
$lang['forgotten_password_code']        = "Unutulan şifre kodu";
$lang['send_invoices_to_customer']  = "Müşteriye fatura gönderme";
$lang['send_receipts_to_customer']  = "Müşteriye makbuz gönderme";
$lang['send_rinvoices_to_customer'] = "Müşteriye tekrarlayan faturalar gönderin";
$lang['send_estimates_to_customer'] = "Müşteriye tahminler gönderin";
$lang['send_contracts_to_customer'] = "Müşteriye sözleşme gönder";
$lang['send_customer_reminder']     = "Müşteri uyarısını gönder";
$lang['send_overdue_reminder']      = "Vaktindeki hatırlatıcıyı gönder";
$lang['send_forgotten_password']    = "Unutulan şifre gönder";
$lang['send_activate']              = "Hesap etkinleştirme kodu gönder";
$lang['send_activate_customer']     = "Müşteri hesabı aktivasyon kodunu gönder";
$lang['send_file']                  = "Dosya Gönder";


$lang['customize_template']           = "Şablonu özelleştir";
$lang['blank']                        = "Boş";
$lang['customize']                    = "Özelleştirmek";
$lang['font_size']                    = "Yazı Boyutu";
$lang['margin']                       = "kenar";
$lang['tables']                       = "Tablolar";
$lang['bordered']                     = "bordered";
$lang['striped']                      = "Çizgili";
$lang['line_th_height']               = "Başlık yüksekliği";
$lang['line_td_height']               = "Satır yüksekliği";
$lang['line_th_bg']                   = "Başlık arka planı";
$lang['line_th_color']                = "Başlık metin rengi";
$lang['monocolor']                    = "Mono-color";
$lang['grayscale']                    = "Gri tonlama";
$lang['background']                   = "Arka fon";
$lang['color']                        = "Renk";
$lang['image']                        = "görüntü";
$lang['position']                     = "pozisyon";
$lang['fit']                          = "Fit";
$lang['opacity']                      = "opaklık";
$lang['bg_color']                     = "Arka plan rengi";
$lang['txt_color']                    = "Metin rengi";
$lang['stamp']                        = "Kaşe";
$lang['select_color']                 = "Renk seçin";



// projects
$lang['project']                      = "proje";
$lang['projects']                     = "Projeler";
$lang['projects_subheading']          = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['create_project']               = "Yeni Proje Yarat";
$lang['create_project_subheading']    = "Yeni bir Proje oluşturmak için lütfen aşağıdaki bilgileri giriniz.";
$lang['edit_project']                 = "Projeyi Düzenle";
$lang['edit_project_subheading']      = "Bu Projeyi düzenlemek için lütfen aşağıdaki bilgileri giriniz.";
$lang['project_add_success']          = "Proje başarıyla oluşturuldu";
$lang['project_edit_success']         = "Proje başarıyla güncellendi";
$lang['project_deleted']              = "Proje başarıyla silindi";
$lang['cant_delete_project']          = "Bu Projeyi silemezsiniz!";
$lang['project_name']                 = "Proje Adı";
$lang['billing_type']                 = "Faturalandırma türü";
$lang['total_rate']                   = "Toplam ücret";
$lang['rate_per_hour']                = "Saat başı oran";
$lang['estimated_hours']              = "Tahmini saatler";
$lang['not_started']                  = "Başlatılmadı";
$lang['in_progress']                  = "Devam etmekte";
$lang['on_hold']                      = "Beklemede";
$lang['fixed_rate']                   = "Sabit oran";
$lang['project_hours']                = "Çalışma saatleri";
$lang['task_hours']                   = "Görev saatleri";
$lang['deadline']                     = "Son tarih";
$lang['members']                      = "Üyeler";
$lang['progress']                     = "İlerleme";
$lang['task']                         = "Görev";
$lang['tasks']                        = "Görevler";
$lang['tasks_list']                   = "Görevler listesi";
$lang['testing']                      = "Test yapmak";
$lang['complete']                     = "Tamamlayınız";
$lang['create_task']                  = "Yeni Görev Yarat";
$lang['edit_task']                    = "Görevi Düzenle";
$lang['task_add_success']             = "Görev başarıyla oluşturuldu";
$lang['task_edit_success']            = "Görev başarıyla güncellendi";
$lang['task_complete_success']        = "Görev başarıyla tamamlandı";
$lang['task_delete_success']          = "Görev başarıyla silindi";
$lang['project_progress']             = "Proje ilerleme durumu";
$lang['project_informations']         = "Proje bilgileri";
$lang['not_completed_tasks']          = "Tamamlanmamış görevler";
$lang['days_left']                    = "Kalan günler";
$lang['overview']                     = "genel bakış";
$lang['hour_rate']                    = "Saat ücreti";
$lang['hour']                         = "Saat";


$lang['partial_invoices']                = "Kısmi Faturalar";
$lang['partial_invoices_subheading']     = "Sonuçları gezinmek veya filtrelemek için lütfen aşağıdaki tabloyu kullanın.";
$lang['paid_amount']                     = "Ödenen miktar";
$lang['amount_due']                      = "Ödenecek meblağ";
$lang['payment_date']                    = "Ödeme tarihi";
$lang['rate']                            = "oran";
$lang['activate_double_currency']        = "Çift para seçeneği etkinleştirin";
$lang['filter_customer']                 = "İstemciye göre filtrele";
$lang['customer_suggestion_placeholder'] = "Müşteri önerisi";
$lang['daterange']                       = "Tarih aralığı";
$lang['filtering']                       = "süzme";
$lang['partial_invoice_details']         = "Kısmi Fatura Ayrıntıları";
$lang['partial_invoice_det_subheading']  = "Zaman içinde gönderdiğiniz kısmi faturaların ayrıntılı bir özeti";
$lang['cost_per_supplier']               = "Tedarikçi başına maliyet";
$lang['cost_per_supplier_subheading']    = "Belirli bir dönemde perakendeciye göre sınıflandırılan maliyetler";
$lang['tasks_progress']                  = "Görevler ilerleme";
$lang['filter_supplier']                 = "Tedarikçiler filtre";
$lang['supplier_suggestion_placeholder'] = "Tedarikçi önerisi";
$lang['exchange_api']                    = "Exchange API&#39;sı";
$lang['create_an_account']               = "Hesap oluştur";
$lang['generates_an_api_key']            = "ve bir API anahtarı üretir";


?>
