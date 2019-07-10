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
$lang['lang']                             = "fr";
$lang['site_title_head']                  = "Système de facture intelligente";
$lang['site_title']                       = 'Système de <span class="bold">facture</span> intelligente';
$lang['is_demo']                          = "C'est une version démo, vous ne pouvez pas exécuter toutes les options";
$lang['remove_install_file']              = "Pour la sécurité du programme, supprimez le fichier d\'installation \"install.php\" du dossier principal";

$lang['invoice']                          = "Facture";
$lang['invoices']                         = "Factures";
$lang['invoices_subheading']              = 'Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.';
$lang['reference']                        = "Référence";
$lang['date']                             = "Date";
$lang['date_due']                         = "Date d&#39;échéance";
$lang['valid_till']                       = 'Valable jusqu&#39;au';
$lang['status']                           = "État";
$lang['invoice_note']                     = "Invoice Note";
$lang['invoice_terms']                    = "Conditions de facturation";
$lang['total']                            = "Total";
$lang['actions']                          = "Actions";
$lang['details']                          = "Détails";
$lang['delete']                           = "Effacer";
$lang['edit']                             = "Modifier";
$lang['duplicate']                        = "Dupliquer";
$lang['refresh']                          = "Rafraîchir";
$lang['filter']                           = "Filtre";
$lang['yes']                              = "Oui";
$lang['no']                               = "Non";
$lang['ok']                               = 'Ok';
$lang['cancel']                           = "Annuler";
$lang['clear']                            = "Clair";
$lang['save']                             = "sauvegarder";
$lang['next']                             = "Prochain";
$lang['previous']                         = "précédent";
$lang['confirmation']                     = "Confirmation";
$lang['alert_confirmation']               = 'Vous souhaitez confirmer cette action. Appuyez sur OUI pour continuer ou NON pour revenir en arrière';
$lang['name']                             = "Nom";
$lang['description']                      = "La description";
$lang['show_description']                 = "Afficher la description";

$lang["system"]                           = 'Système';
$lang['create_invoice']                   = "Créer une facture";
$lang['edit_invoice']                     = "Modifier la facture";
$lang['create_invoice_subheading']        = "Pour créer une nouvelle facture, veuillez entrer les informations ci-dessous.";
$lang['edit_invoice_subheading']          = "Pour modifier cette facture, veuillez entrer les informations ci-dessous.";
$lang['preview_invoice_error']            = "Pour un aperçu de cette facture s\'il vous plaît saisir toutes les informations nécessaires.";
$lang['invoice_title']                    = "Titre de la facture";
$lang['invoice_description']              = "Rédigez le résumé de la facture ...";
$lang['basic_informations']               = "Basic Informations";
$lang['contact_informations']             = "Contact Informations";
$lang['account_informations']             = "Account Informations";
$lang['additional_informations']          = "Informations supplémentaires";
$lang['attn']                             = "Attn";
$lang['company']                          = "Company";
$lang['company_name']                     = "Name of Company";
$lang['fullname']                         = "Nom complet";
$lang['contact_name']                     = "Contact name";
$lang['phone']                            = "Téléphone";
$lang['email']                            = "Email";
$lang['address']                          = "Adresse";
$lang['percent']                          = "Pourcentage (%)";
$lang['flat']                             = "Nombre Fix (€)";
$lang['off']                              = "Off";
$lang['invoice_setting']                  = "Paramètres de la facture";
$lang['currency']                         = "Devise";
$lang['tax_type']                         = "Type de taxe";
$lang['discount_type']                    = "Type de remise";
$lang['tax']                              = "Taxe";
$lang['taxes']                            = "Taxes";
$lang['discount']                         = "Remise";
$lang['discounts']                        = "Réductions";
$lang['total_due']                        = "Total dû";
$lang['issued_on']                        = "Publié le";
$lang['issued_date']                      = "Date d&#39;émission";

$lang['all_invoices']                     = "Toutes les factures";
$lang['unpaid']                           = "Non payé";
$lang['paid']                             = "Payé";
$lang['partial']                          = "Partiel";
$lang['due']                              = "Due";
$lang['overdue']                          = "En retard";
$lang['canceled']                         = "Annulé";
$lang['draft']                            = "Brouillon";

$lang['due_receipt']                      = "-";
$lang['after_7_days']                     = "Après 7 jours";
$lang['after_15_days']                    = "Après 15 jours";
$lang['after_30_days']                    = "Après 30 jours";
$lang['after_45_days']                    = "Après 45 jours";
$lang['after_60_days']                    = "Après 60 jours";
$lang['custom']                           = "Date personnalisée";

$lang['more']                             = "Plus ...";
$lang['add']                              = "Ajouter";
$lang['quantity']                         = "Quantité";
$lang['unit_price']                       = "Prix ​​unitaire";
$lang['add_row']                          = "Ajouter une rangée";
$lang['subtotal']                         = "Sous-Total";
$lang['global_tax']                       = "Taxe globale";
$lang['global_discount']                  = "Réduction globale";
$lang['preview']                          = "Aperçu";
$lang['create']                           = "Créer";
$lang['open']                             = "Ouvrir";
$lang['invoice_no']                       = "Facture N °";
$lang['invoice_items']                    = "Éléments de la facture";
$lang['n°']                               = "N°";
$lang['code']                             = "Code";
$lang['print']                            = "Impression";
$lang['close']                            = "Fermer";
$lang['title']                            = "Titre";
$lang['system_setting']                   = "Paramétrage du système";
$lang['system_setting_subheading']        = "Pour mettre à jour les paramètres du système, entrez les informations ci-dessous.";
$lang['settings_general']                 = "Générale";
$lang['settings_company']                 = "Société";
$lang['settings_invoice']                 = "Modèle de facture";
$lang['configuration_general']            = "Paramètres Générale";
$lang['update_settings']                  = "Mettre à jour";
$lang['language']                         = "La langue";
$lang['select']                           = "Sélectionner";
$lang['selected']                         = "Choisi";
$lang['date_format']                      = "Format de date";
$lang['currency_format']                  = "Format de Devise";
$lang['currency_format']                  = "Format de Devise";
$lang['default_currency']                 = "Devise par défaut";
$lang['currency_place']                   = "Lieu symbole de devise";
$lang['prefix_invoice']                   = "Préfixe de facture";
$lang['estimate_prefix']                  = "Préfixe de Estimation";
$lang['receipt_prefix']                   = "Préfixe de paiement";
$lang['contract_prefix']                  = "Préfixe de contrat";
$lang['expense_prefix']                   = "Préfixe de dépenses";
$lang['invoice_next']                     = "Facture suivante";
$lang['estimate_next']                    = "Estimation suivante";
$lang['receipt_next']                     = "Prochaine réception";
$lang['contract_next']                    = "Contrat suivant";
$lang['expense_next']                     = "Prochaine dépense";
$lang['biller_type']                      = "Type de biller";
$lang['item_tax']                         = "Impôt sur les éléments";
$lang['item_discount']                    = "Réduction sur les éléments";
$lang['is_required']                      = "est requis";
$lang['email_address']                    = "E-mail";
$lang['city']                             = "Ville";
$lang['state']                            = "Etat";
$lang['postal_code']                      = "Code postal";
$lang['country']                          = "Pays";
$lang['website']                          = "URL de site web";
$lang['configuration_company']            = "Paramètres de Société";
$lang['update']                           = "Mettre à jour";
$lang['logo']                             = "Logo";
$lang['perview']                          = "Aperçu";
$lang['configuration_invoice_template']   = "Paramètres de Modèle de facture";
$lang['update_template']                  = "Mettre à jour";
$lang['settings']                         = "Paramètres";
$lang['style']                            = "Style";
$lang['header']                           = "Entête de page";
$lang['footer']                           = "Pied de page";
$lang['signature']                        = "Signature";
$lang['template_configuration']           = "Configuration du modèle";
$lang['default_layout']                   = "Mise en page par défaut";
$lang['default_size']                     = "Taille par défaut";
$lang['auto_print']                       = "Impression automatique";
$lang['template_style_configuration']     = "Modifier les paramètres de style";
$lang['font']                             = "Police";
$lang['table_bordered']                   = "Tableau bordée";
$lang['table_striped']                    = "Tableau rayé";
$lang['primary_color']                    = "Couleur primaire";
$lang['second_color']                     = "Couleur secondaire";
$lang['template_header_configuration']    = "Modifier les paramètres de l'en-tête de page";
$lang['appearance']                       = "Apparence";
$lang['show_header']                      = "Afficher / Masquer";
$lang['header_bg_color']                  = "Couleur de fond";
$lang['header_txt_color']                 = "Couleur du texte";
$lang['template']                         = "Modèle";
$lang['header_text']                      = "Texte de l'en-tête";
$lang['template_footer_configuration']    = "Modifier les paramètres de pied de page";
$lang['show_footer']                      = "Afficher / Masquer";
$lang['footer_bg_color']                  = "Couleur de fond";
$lang['footer_txt_color']                 = "Couleur du texte";
$lang['footer_text']                      = "Texte de pied de page";
$lang['template_signature_configuration'] = "Modifier les paramètres de signature";
$lang['signature_txt']                    = "Texte de signature";
$lang['order_by']                         = "Commandé par";
$lang['title_invoice']                    = "Titre du Facture";
$lang['no_zero_required']                 = "Le champ %s est requis";
$lang['users']                            = "Utilisateurs";
$lang['dashboard']                        = "Tableau de bord";
$lang['settings_general_updated']         = "Les paramètres généraux sont mis à jour avec succès";
$lang['settings_company_updated']         = "Les paramètres de l&#39;entreprise sont mis à jour avec succès";
$lang['invoice_template_updated']         = "Les paramètres du modèle de facture sont mis à jour avec succès";
$lang['invoice_add_success']              = "Facture créée avec succès";
$lang['invoice_edit_success']             = "Facture mise à jour avec succès";
$lang['invoice_deleted']                  = "La facture a été supprimée avec succès";
$lang['cant_delete_invoice']               = "Vous ne pouvez pas supprimer cette facture!, Cause: <br> <ul><li> Cette facture est liée à d'autres éléments </li></ul> Vous devez supprimer tous les éléments, puis réessayer";
$lang['invoice_duplicate_success']        = "La facture a été reproduite avec succès";
$lang['access_denied']                    = "Accès refusé!";
$lang['language_is_changed']              = "La langue est modifiée avec succès";
$lang['change_password']                  = "Changer le mot de passe";
$lang['logout']                           = "Déconnectez";
$lang['here']                             = "Ici";

$lang['paid_invoices']                    = "Facture (s) payée (s)";
$lang['unpaid_invoices']                  = "Factures non payées";
$lang['overdue_invoices']                 = "Factures en retard";
$lang['number_of_invoices']               = '<div class="font-weight-bold">%s</div><div class="text-muted"> <small>Factures</small> </div>';
$lang['last_invoices']                    = "Dernières factures";
$lang['last_invoices_subheading']         = "Afficher la liste des 5 dernières factures créées";
$lang['overview_chart']                   = "Graphique de synthèse";
$lang['overview_chart_subheading']        = "Graphique de comptage des factures par état";
$lang['invoices_per_date']                = "Factures par date";
$lang['invoices_per_date_subheading']     = "Graphique affiche les totales des factures par date";

$lang['settings_template']                = "Modèle";
$lang['defaults']                         = "Par défaut";
$lang['default_status']                   = "Statut par défaut";
$lang['manage_configurations']            = "Créer / mettre à jour des configurations";
$lang['printing_configurations']          = "Configurations d&#39;impression";
$lang['show_invoice_status']              = "Afficher l&#39;état de la facture";
$lang['show_total_due']                   = "Afficher le total dû";
$lang['show_payments_page']               = "Afficher la page de paiement";
$lang['note_terms_on_page']               = "Conditions sur la page";
$lang['enable_terms']                     = "Activer les termes et conditions";
$lang['payments_total']                   = "Total des paiements";
$lang['invoice_total']                    = "Total de la facture";
$lang['description_inline']               = "Description du produit";
$lang['description_inline_tip']           = "Afficher la description du produit sur la même ligne avec le nom";

// Errors
$lang['error_csrf']                       = 'La validation de ce formulaire a échoué.';
// Users Roles
$lang['role_superadmin']                  = 'Super Admin';
$lang['role_admin']                       = 'Administrateur';
$lang['role_members']                     = 'Utilisateur (Membre)';
$lang['role_customer']                    = 'Client';
$lang['role_supplier']                    = 'Fournisseur';

// Login
$lang['login_heading']                    = 'Se connecter';
$lang['login_subheading']                 = 'Veuillez vous connecter avec votre nom d\'utilisateur et votre mot de passe.';
$lang['login_identity_label']             = 'E-mail/Nom d\'utilisateur :';
$lang['login_password_label']             = 'Mot de passe :';
$lang['login_remember_label']             = 'Rester connecté :';
$lang['login_submit_btn']                 = 'Se connecter';
$lang['login_forgot_password']            = 'Mot de passe oublié ?';

// Index
$lang['index_heading']                    = 'Utilisateurs';
$lang['index_subheading']                 = 'Ci-dessous se trouve la liste des utilisateurs.';
$lang['index_username_th']                = 'Nom d\'utilisateur';
$lang['index_name_th']                    = 'Nom';
$lang['index_fname_th']                   = 'Prénom';
$lang['index_lname_th']                   = 'Nom';
$lang['index_email_th']                   = 'Email';
$lang['index_groups_th']                  = 'Groupes';
$lang['index_status_th']                  = 'Statut';
$lang['index_action_th']                  = 'Action';
$lang['index_active_link']                = 'Activer';
$lang['index_inactive_link']              = 'Désactiver';
$lang['index_create_user_link']           = 'Créer un nouvel utilisateur';
$lang['index_active_status']              = 'Actif';
$lang['index_inactive_status']            = 'Inactif';

// Deactivate User
$lang['deactivate_heading']                  = 'Désactiver un utilisateur';
$lang['deactivate_subheading']               = 'Êtes-vous certain de vouloir désactiver l\'utilisateur : %s';
$lang['deactivate_confirm_y_label']          = 'Oui :';
$lang['deactivate_confirm_n_label']          = 'Non :';
$lang['deactivate_submit_btn']               = 'Envoyer';
$lang['deactivate_validation_confirm_label'] = 'Confirmation';
$lang['deactivate_validation_user_id_label'] = 'Identifiant';

// Create User
$lang['create_user_heading']                           = 'Créer un utilisateur';
$lang['create_user_subheading']                        = 'Veuillez entrer les informations ci-dessous.';
$lang['create_user_fname_label']                       = 'Prénom :';
$lang['create_user_lname_label']                       = 'Nom :';
$lang['create_user_company_label']                     = 'Société :';
$lang['create_user_identity_label']                    = 'Identité :';
$lang['create_user_email_label']                       = 'Email :';
$lang['create_user_phone_label']                       = 'Téléphone :';
$lang['create_user_password_label']                    = 'Mot de passe :';
$lang['create_user_password_confirm_label']            = 'Confirmer le mot de passe :';
$lang['create_user_submit_btn']                        = 'Créer l\'utilisateur';
$lang['create_user_validation_fname_label']            = 'Prénom';
$lang['create_user_validation_lname_label']            = 'Nom';
$lang['create_user_validation_identity_label']         = 'Identité :';
$lang['create_user_validation_email_label']            = 'Adresse Email';
$lang['create_user_validation_phone_label']            = 'Téléphone';
$lang['create_user_validation_company_label']          = 'Société';
$lang['create_user_validation_password_label']         = 'Mot de passe';
$lang['create_user_validation_password_confirm_label'] = 'Confirmation du mot de passe';

// Edit User
$lang['edit_user_heading']                           = 'Éditer l\'utilisateur';
$lang['edit_user_subheading']                        = 'Veuillez entrer les données de l\'utilisateur ci-dessous.';
$lang['edit_user_fname_label']                       = 'Prénom :';
$lang['edit_user_lname_label']                       = 'Nom :';
$lang['edit_user_company_label']                     = 'Société :';
$lang['edit_user_email_label']                       = 'E-mail :';
$lang['edit_user_phone_label']                       = 'Téléphone :';
$lang['edit_user_password_label']                    = 'Mot de passe (si modifié) :';
$lang['edit_user_password_confirm_label']            = 'Confirmer le mot de passe :';
$lang['edit_user_password_help']                     = 'Si vous modifiez le mot de passe';
$lang['edit_user_groups_heading']                    = 'Membre du groupe';
$lang['edit_user_submit_btn']                        = 'Enregistrer les mofifications';
$lang['edit_user_validation_fname_label']            = 'Prénom';
$lang['edit_user_validation_lname_label']            = 'Nom';
$lang['edit_user_validation_email_label']            = 'Adresse email';
$lang['edit_user_validation_phone_label']            = 'Téléphone';
$lang['edit_user_validation_company_label']          = 'Société';
$lang['edit_user_validation_groups_label']           = 'Groupes';
$lang['edit_user_validation_password_label']         = 'Mot de passe';
$lang['edit_user_validation_password_confirm_label'] = 'Confirmation du Mot de passe';

// Change Password
$lang['change_password_heading']                               = 'Changer le mot de passe';
$lang['change_password_old_password_label']                    = 'Ancien mot de passe :';
$lang['change_password_new_password_label']                    = 'Le nouveau mot de passe (doit contenir %s caractères minimum) :';
$lang['change_password_new_password_confirm_label']            = 'Confirmer le nouveau mot de passe :';
$lang['change_password_submit_btn']                            = 'Enregistrer';
$lang['change_password_validation_old_password_label']         = 'Ancien mot de passe';
$lang['change_password_validation_new_password_label']         = 'Nouveau mot de passe';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe';

// Forgot Password
$lang['forgot_password_heading']                 = 'Mot de passe oublié';
$lang['forgot_password_subheading']              = 'Veuillez entrer votre %s pour que nous puissions vous envoyer votre nouveau mot de passe.';
$lang['forgot_password_identity_not_found']      = 'Identité introuvable.';
$lang['forgot_password_email_label']             = '%s :';
$lang['forgot_password_submit_btn']              = 'Envoyer';
$lang['forgot_password_validation_email_label']  = 'Adresse Email';
$lang['forgot_password_identity_label']          = 'Nom d\'utilisateur';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'Cette adresse email n\'est pas enregistrée chez nous.';

// Reset Password
$lang['reset_password_heading']                               = 'Modifier le mot de passe';
$lang['reset_password_new_password_label']                    = 'Nouveau mot de passe (doit contenir %s caractères minimum) :';
$lang['reset_password_new_password_confirm_label']            = 'Confirmez le nouveau mot de passe :';
$lang['reset_password_submit_btn']                            = 'Enregistrer';
$lang['reset_password_validation_new_password_label']         = 'Nouveau mot de passe';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe';

// Account Creation
$lang['account_creation_successful']            = 'Compte créé avec succès';
$lang['account_creation_unsuccessful']          = 'Impossible de créer le compte';
$lang['account_creation_duplicate_email']       = 'Email déjà utilisé ou invalide';
$lang['account_creation_duplicate_identity']    = 'Nom d\'utilisateur déjà utilisé ou invalide';
$lang['account_creation_missing_default_group'] = 'Le groupe par défaut n\'est pas configuré';
$lang['account_creation_invalid_default_group'] = 'Le nom du groupe par défaut n\'est pas valide';


// Password
$lang['password_change_successful']          = 'Le mot de passe a été changé avec succès';
$lang['password_change_unsuccessful']        = 'Impossible de changer le mot de passe';
$lang['forgot_password_successful']          = 'Mail de réinitialisation du mot de passe envoyé';
$lang['forgot_password_unsuccessful']        = 'Impossible de réinitialiser le mot de passe';

// Activation
$lang['activate_successful']                 = 'Compte activé';
$lang['activate_unsuccessful']               = 'Impossible d\'activer le compte';
$lang['deactivate_successful']               = 'Compte désactivé';
$lang['deactivate_unsuccessful']             = 'Impossible de désactiver le compte';
$lang['activation_email_successful']         = 'Email d\'activation envoyé avec succès';
$lang['activation_email_unsuccessful']       = 'Impossible d\'envoyer l\'email d\'activation';

// Login / Logout
$lang['login_successful']                    = 'Connecté avec succès';
$lang['login_unsuccessful']                  = 'Erreur lors de la connexion';
$lang['login_unsuccessful_not_active']       = 'Ce compte est inactif';
$lang['login_timeout']                       = 'Compte temporairement bloqué suite à de trop nombreuse tentative.  Veuillez réessayer plus tard.';
$lang['logout_successful']                   = 'Déconnexion effectuée avec succès';

// Account Changes
$lang['update_successful']                   = 'Compte utilisateur mis à jour avec succès';
$lang['update_unsuccessful']                 = 'Impossible de mettre à jour le compte utilisateur';
$lang['delete_successful']                   = 'Utilisateur supprimé';
$lang['delete_unsuccessful']                 = 'Impossible de supprimer l\'utilisateur';

// Groups
$lang['group_creation_successful']           = 'Groupe créé avec succès';
$lang['group_already_exists']                = 'Nom du groupe déjà pris';
$lang['group_update_successful']             = 'Informations sur le groupe mis à jour';
$lang['group_delete_successful']             = 'Groupe supprimé';
$lang['group_delete_unsuccessful']           = 'Impossible de supprimer le groupe';
$lang['group_delete_notallowed']             = 'Le groupe Administrateur ne peut pas être supprimé';
$lang['group_name_required']                 = 'Le nom du groupe est un champ obligatoire';
$lang['group_name_admin_not_alter']          = 'Le nom du groupe Admin ne peut pas être modifié';

// Password Strength
$lang['pass_strength_general']               = "Le mot de passe doit avoir:";
$lang['pass_strength_minlength']             = "At leaset {{minlength}} characters";
$lang['pass_strength_number']                = "Au moins un chiffre";
$lang['pass_strength_capital']               = "Au moins une lettre majuscule";
$lang['pass_strength_special']               = "Au moins un caractère spécial";

// Emails
$lang['email_caution']                       = '<b>Attention</b> Le lien ne peut être utilisé qu\'une seule fois. Si vous essayez de rediriger une deuxième fois, une erreur apparaît. Si vous avez des questions, s\'il vous plaît contacter notre support à';
$lang['email_automatic']                     = 'Remarque: cette lettre a été générée et envoyée automatiquement et ne nécessite aucune réponse.';
$lang['email_copyright']                     = 'Copyright ©% s% s, Tous droits réservés.';

// Activation Email
$lang['email_activation_subject']            = 'Activation du compte';
$lang['email_activate_heading']              = 'Félicitation !';
$lang['email_activate_subheading']           = 'Salut <b>%s</b>, Vous avez enregistré avec succès sur le <i>%s</i>.<br>Pour activer votre compte, veuillez confirmer votre inscription.';
$lang['email_activate_link']                 = 'Confirmer l\'inscription';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Vérification du mot de passe oublié';
$lang['email_forgot_password_heading']       = 'Salut %s,';
$lang['email_forgot_password_subheading']    = 'Nous avons reçu une demande pour réinitialiser votre mot de passe..<br>Votre nom d\'utilisateur est <b>%s</b>.';
$lang['email_forgot_password_link']          = 'Réinitialiser le mot de passe';

// New Password Email
$lang['email_new_password_subject']          = 'Nouveau mot de passe';
$lang['email_new_password_heading']          = 'Nouveau mot de passe';
$lang['email_new_password_subheading']       = 'Votre mot de passe a été changé pour : %s';

// Invoice Email
$lang['emails']                              = 'Emails';
$lang['email_to']                            = "À";
$lang['email_subject']                       = "Assujettir";
$lang['email_cc']                            = "CC";
$lang['email_bcc']                           = "BCC";
$lang['show_hide_cc_bcc']                    = "Afficher / Masquer CC &amp; BCC";
$lang['send_email']                          = "Envoyer un courriel";
$lang['emails_list']                         = 'Adresse email (s)';
$lang['send']                                = 'Envoyer';
$lang['additional_content']                  = 'Contenu additionnel';
$lang['emails_example']                      = 'ex: contact@sis.com, info@sis.com ...';
$lang['email_invoice_subject']               = 'Facture PDF de %s';
$lang['email_invoice_heading']               = 'Salutations !';
$lang['email_invoice_subheading']            = 'Vous avez reçu une facture de <b>%s</b>.<br>Un fichier PDF est attaché.';
$lang['email_successful']                    = 'Le courrier électronique est envoyé. Vérifiez votre boîte de réception ou votre spam';
$lang['email_unsuccessful']                  = 'Impossible d\'envoyer un courrier électronique, Vérifiez votre configuration d\'email !';


$lang['email_dear']                          = 'cher %s ,';
$lang['send_payments_reminder']              = 'Envoyer un rappel de paiement';
$lang['no_unpaid_invoies']                   = "ce client n&#39;a pas de factures impayées!";
$lang['email_rinvoice_subject']              = 'Nouvelle facture de %s ';
$lang['email_rinvoice_subheading']           = 'Vous avez reçu une nouvelle facture impayée de %s .';
$lang['email_unpaid_subject']                = 'Vous avez des factures impayées de %s ';
$lang['email_unpaid_invoices']               = 'Tu as %s factures impayées.';
$lang['email_overdue_subject']               = 'Vous avez une facture en retard de %s ';
$lang['email_overdue_reminder']              = 'Vous avez peut-être manqué la date de paiement et la facture est maintenant en retard %s journées.';

$lang['overdue_reminder']                    = "Rappel en retard";
$lang['once_is']                             = "Une fois que la facture est";
$lang['days_late']                           = "jours de retard";
$lang['and_every']                           = "et tous";
$lang['days_after']                          = "jours après";

/* --------------------------- DATATABLES --------------------------------------------- */
$lang['loading_data']               =   "Chargement des données du serveur";
$lang['sEmptyTable']                =   "Aucun résultat trouvé dans les tableaux";
$lang['no_data']                    =   "Aucun résultat trouvé !";
$lang['sInfo']                      =   "Afficher _START_ à _END_ de _TOTAL_ lignes";
$lang['sInfoEmpty']                 =   "Montrer 0 de 0 de 0 lignes";
$lang['sInfoFiltered']              =   "(Filtré à partir de _MAX_ entrées totales)";
$lang['sInfoPostFix']               =   "";
$lang['sInfoThousands']             =   ",";
$lang['sLengthMenu']                =   "Afficher _MENU_ lignes";
$lang['sLoadingRecords']            =   "Chargement...";
$lang['sProcessing']                =   "En traitement...";
$lang['sSearch']                    =   "Chercher ";
$lang['advanced_search']            =   "Recherche Avancée";
$lang['sZeroRecords']               =   "Aucun résultat trouvé";
$lang['sFirst']                     =   "&lt;&lt;";
$lang['sLast']                      =   "&gt;&gt;";
$lang['sNext']                      =   "&gt;";
$lang['sPrevious']                  =   "&lt;";
$lang['sSortAscending']             =   ": Activer l&#39;arrangement ascendant";
$lang['sSortDescending']            =   ": Activer l&#39;arrangement de liaison descendante";
$lang['colvis_buttonText']          =   "Afficher / masquer les colonnes";
$lang['colvis_sRestore']            =   "Restaurer l&#39;original";
$lang['colvis_sShowAll']            =   "Montre tout";
$lang['tabletool_csv']              =   "Télécharger CSV";
$lang['tabletool_xls']              =   "Télécharger Excel";
$lang['tabletool_copy']             =   "Copie";
$lang['tabletool_pdf']              =   "Télécharger le fichier PDF";
$lang['tabletool_text']             =   "Télécharger le texte";
$lang['tabletool_print']            =   "Impression";
$lang['tabletool_print_sInfo']      =   "<H6> Aperçu avant impression </ h6> <p> Utilisez la fonction d\'impression de votre navigateur pour imprimer cette table. Appuyez sur Echap lorsque vous avez terminé. </ P>";
$lang['tabletool_print_sToolTip']   =   "Afficher la vue d&#39;impression";
$lang['tabletool_select']           =   "Sélectionner";
$lang['tabletool_select_single']    =   "Sélectionnez Single";
$lang['tabletool_select_all']       =   "Tout sélectionner";
$lang['tabletool_select_none']      =   "Tout sélectionner";
$lang['tabletool_ajax']             =   "Bouton Ajax";
$lang['tabletool_collection']       =   "Télécharger";
$lang['export']                     =   "Exportation";
$lang['export_csv']                 =   "Exporter en tant que CSV";
$lang['export_xls']                 =   "Exporter en Excel";
$lang['export_pdf']                 =   "Exporter en format PDF";
$lang['export_text']                =   "Exporter en tant que texte";
$lang['all']                        = "Tout";

/* --------------------------- DATERANGE --------------------------------------------- */
$lang['daterange_today']            = "Aujourd&#39;hui";
$lang['daterange_yesterday']        = "Hier";
$lang['daterange_last_7_days']      = "Les 7 derniers jours";
$lang['daterange_last_30_days']     = "Les 30 derniers jours";
$lang['daterange_this_month']       = "Ce mois";
$lang['daterange_last_month']       = "Le mois dernier";
$lang['daterange_this_year']        = "Cette année";
$lang['daterange_custom']           = "Gamme personnalisée";
$lang['daterange_end_of_last_month']= "Fin du mois dernier";
$lang['daterange_end_of_year']      = "Fin de l&#39;année dernière";

$lang['error']                      = 'Erreur';
$lang['success']                    = 'Succès';

// Register
$lang['register_heading']           = 'Inscription';
$lang['register_subheading']        = 'Créez votre compte';
$lang['register_ask']               = 'Vous n\'avez pas de compte?';
$lang['register_btn']               = 'Inscrire maintenant!';
$lang['register_username']          = 'Pseudo';
$lang['register_email']             = 'Adresse Email';
$lang['register_password']          = 'mot de passe';
$lang['register_password_confirm']  = 'Confirmer le mot de passe';
$lang['register_submit_btn']        = 'Créer un compte';

$lang['default_group']              = 'Groupe de nouveaux comptes';
$lang['enable_register']            = 'Activer l\'inscription';
$lang['reference_type']             = 'Type de référence';
$lang['show_reference']             = 'Afficher la référence';
$lang['reference_type_changed']     = 'Le type de référence est modifié !<br>Vous souhaitez réinitialiser la référence de toutes les factures au nouveau type?';
$lang['generate']                   = 'Générer';
$lang['no_invoice_items']           = 'Les éléments de facture sont requis. Doit être au moins 1 élément au minimum';


$lang["loading"]                    = 'Chargement...';
$lang["file"]                       = 'Fichier';
$lang["shortcut_help"]              = 'Aide sur les raccourcis';
$lang["shortcut_help_title"]        = 'Aide sur les raccourcis du clavier';
$lang["documentations"]             = 'Documentations';
$lang["about"]                      = 'À Propos';
$lang["shortcut"]                   = 'Raccourci';
$lang["main_menu"]                  = 'Menu principal';

$lang["settings_email"]             = 'Email';
$lang["configuration_email"]        = 'Paramètres d\'E-mail';
$lang["protocol"]                   = 'Protocole';
$lang["smtp_crypto"]                = 'Cryptage';
$lang["smtp_host"]                  = 'Hôte SMTP';
$lang["smtp_port"]                  = 'Port SMTP';
$lang["smtp_user"]                  = 'Utilisateur SMTP';
$lang["smtp_pass"]                  = 'Mot de passe SMTP';
$lang["mailpath"]                   = 'Mail Path';
$lang["settings_email_updated"]     = "Les paramètres de messagerie sont mis à jour avec succès";

// importing data
$lang['import_data']                   = "Importation de données";
$lang['idata_title']                   = "Importation de données";
$lang['idata_subheading']              = "Quelles données souhaitez-vous importer?";
$lang['idata_upload_file']             = "Upload un fichier";
$lang['idata_upload_file_subheading']  = 'Entrez les informations ci-dessous.';
$lang['idata_match_fields']            = "Champs de correspondance";
$lang['idata_match_fields_subheading'] = "Adaptez vos champs aux champs d&#39;application";
$lang['idata_confirm_data']            = "Confirmation des données";
$lang['idata_confirm_data_subheading'] = "Confirmez et supprimez vos données";
$lang['idata_add_to_database']         = "Ajouter à Base de données";
$lang['idata_add_to_db_subheading']    = "L&#39;ajout à la base de données et l&#39;étape finale";
$lang['idata_customers']               = "Importation de clients";
$lang['idata_customers_description']   = "Importation de clients (noms, adresses, etc.)";
$lang['idata_suppliers']               = "Fournisseurs d&#39;importation";
$lang['idata_suppliers_description']   = "Importation de fournisseurs (noms, adresses, etc.)";
$lang['idata_ex_cats']                 = "Catégories d&#39;importation de frais";
$lang['idata_ex_cats_description']     = "Catégories d&#39;importation de frais (type, étiquette)";
$lang['idata_users']                   = "Importer des utilisateurs";
$lang['idata_users_description']       = "Importation d&#39;utilisateurs (nom d&#39;utilisateur, mot de passe, courrier électronique, etc.)";
$lang['idata_tax_rates']               = "Imposition des taux d&#39;imposition";
$lang['idata_tax_rates_description']   = "Imposition des taux d&#39;imposition (étiquette, valeur et type)";
$lang['idata_items']                   = "Importation d&#39;articles";
$lang['idata_items_description']       = "Importation d&#39;éléments (nom, description, prix, etc.)";
$lang['idata_item_cats']               = "Importer des catégories d&#39;articles";
$lang['idata_item_cats_description']   = "Importation de catégories d&#39;articles (étiquette)";


$lang['idata_info']                    = "Liste des champs que votre fichier de données peut contenir. Les champs marqués en gras sont obligatoires. Si vous importez des données avec des symboles spéciaux (virgules, points-virgules, etc.), assurez-vous que ces champs sont indiqués avec citation.";
$lang['idata_checklist']               = "Vérifiez votre liste avant d&#39;importer";
$lang['idata_file_format']             = "Fichiers CSV acceptés par format (* .csv) ou fichiers Excel (* .xls, * .xlsx)";
$lang['idata_download_sample_file']    = "Téléchargez un fichier d&#39;exemple pour voir ce que nous pouvons importer.";
$lang['idata_download_sample']         = "Télécharger le fichier échantillon";
$lang['idata_csv_delimiter']           = "Séparateur CSV";
$lang['idata_semicolon']               = "Point-virgule";
$lang['idata_comma']                   = "Virgule";
$lang['idata_tab']                     = "Languette";
$lang['idata_file']                    = "Fichier";
$lang['idata_max_file_size']           = "Taille maximale de 2 Mo ou 1000 lignes";
$lang['idata_delete_item']             = "Supprimé cet article";
$lang['idata_items_are_imported']      = "articles sont importés";
$lang['idata_item_is_imported']        = "article est importé";
$lang['idata_imported']                = "L&#39;importation de données est complétée avec succès";
$lang['idata_failed']                  = "L&#39;importation de données échouée vérifie tes entrées à nouveau!";
$lang['idata_no_data']                 = "Vous n&#39;insérez aucune donnée, vérifiez vos entrées à nouveau!";


$lang["settings_db"]                   = 'Sauvegardes';
$lang["configuration_db"]              = 'Sauvegardes DataBase';
$lang["create_backup"]                 = 'Créer une sauvegarde';
$lang["date_creation"]                 = "Date de création";
$lang["filename"]                      = "Nom de fichier";
$lang["restore_backup"]                = 'Restaurer la sauvegarde';
$lang["delete_backup"]                 = 'Supprimer la sauvegarde';
$lang["restore_backup_success"]        = "La sauvegarde de la base de données est restaurée avec succès";
$lang["restore_backup_failed"]         = "La sauvegarde de la base de données a échoué";
$lang["backup_deleted"]                = "La sauvegarde de la base de données est supprimée avec succès";



$lang['tax_rate']                      = "Taux d&#39;imposition";
$lang['settings_tax_rates']            = "Les taux d&#39;imposition";
$lang['configuration_tax_rates']       = "Les taux d&#39;imposition";
$lang["no_tax"]                        = "Pas de taxes";
$lang['create_tax_rate']               = "Ajouter un taux d&#39;imposition";
$lang['tax_rate_label']                = "Code fiscal";
$lang['tax_rate_value']                = "Taux / montant";
$lang['tax_rate_type']                 = "Type de taux d&#39;imposition";
$lang['tax_rate_default']              = "Taux d&#39;imputation par défaut";
$lang['tax_rate_new']                  = "Créer un nouveau taux d&#39;imposition";
$lang['tax_rate_update']               = "Mettre à jour la taxe";
$lang['tax_rate_added']                = "Taux d&#39;imposition ajouté avec succès";
$lang['tax_rate_updated']              = "Taux d&#39;imposition mis à jour avec succès";
$lang['tax_rate_deleted']              = "Taux d&#39;imposition supprimé avec succès";
$lang['condition']                     = "Condition";
$lang['conditional_taxes']             = "Impôts conditionnels";
$lang['conditional_taxes_subheading']  = "Ajouter un taux de taxe à vos messages (facture / devis) avec une condition sur le sous-total";
$lang['conditional_taxes_tip']         = "ex: ajouter une taxe de 7 $ sur toutes les factures a total sous-total 150 $";
$lang['is_default']                    = "Est par défaut";
$lang['default']                       = "Défaut";
$lang['add_tax']                       = "Ajouter une taxe";
$lang['shipping']                      = "Shipping";
$lang['condition_terms']               = "Terms & Conditions";
$lang['invoice_note']                  = "Invoice Note";
$lang['note']                          = "Note de facture";
$lang['set_status']                    = "Change status";
$lang['set_status_subheading']         = "Choose the new status of this invoice";
$lang['old_status']                    = "Old Status";
$lang['clear_filter']                  = "Clear Filter";
$lang['shown_columns']                 = "Colonnes actifs";
$lang['number_format']                 = "Format de numéro";
$lang['round_number']                  = "Numéros ronds";
$lang['decimal_place']                 = "Décimale";
$lang['disabled']                      = "Désactivé";
$lang['enabled']                       = "Activée";
$lang['apply_to_subtotal']             = "Appliquez au total du relevé";
$lang['apply_to_line']                 = "Appliquer aux éléments de campagne";

$lang['estimate']                      = "Estimation";
$lang['estimates']                     = "Estimations";
$lang['estimates_subheading']          = "Veuillez utiliser le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['estimate_no']                   = "Estimation N °";
$lang['estimate_items']                = "Estimation des articles";
$lang['estimate_title']                = "Estimation du titre";
$lang['estimate_note']                 = "Note d&#39;estimation";
$lang['create_estimate']               = "Créer un devis";
$lang['create_estimate_subheading']    = "Pour créer une nouvelle Estimation, veuillez entrer les informations ci-dessous.";
$lang['estimate_add_success']          = "Estimation créée avec succès";
$lang['edit_estimate']                 = "Modifier l&#39;estimation";
$lang['edit_estimate_subheading']      = "Pour modifier cette estimation, veuillez entrer les informations ci-dessous.";
$lang['estimate_edit_success']         = "Estimation mise à jour avec succès";
$lang['estimate_deleted']              = "Estimation supprimée avec succès";
$lang['cant_delete_estimate']          = "Vous ne pouvez pas supprimer cette estimation, cause: <br><ul><li> Cette estimation est liée à d&#39;autres éléments </li></ul> Vous devez supprimer tous les éléments, puis réessayer";
$lang['estimate_duplicate_success']    = "Estimation dupliquée avec succès";
$lang['email_estimate_subject']        = "Estimation PDF de% s";
$lang['no_estimate_items']             = "Les éléments d&#39;estimation sont requis. Doit être au moins 1 élément au minimum";
$lang['preview_estimate_error']        = "Pour prévisualiser cette estimation, entrez toutes les informations requises.";
$lang['email_estimate_heading']        = 'Salutations!';
$lang['email_estimate_subheading']     = 'Vous avez reçu une estimation de <b>% s</b> . <br> Un fichier PDF est joint.';
$lang['convert_to_invoice']            = "Convertir en facture";
$lang['sent']                          = "Envoyé";
$lang['accepted']                      = "Accepté";
$lang['invoiced']                      = "Factuelle";
$lang['approve']                       = "Approuver";
$lang['reject']                        = "Rejeter";

$lang['cash']                          = "En espèces";
$lang['check']                         = "Vérifier";
$lang['bank_transfer']                 = "Virement";
$lang['online']                        = "En ligne";
$lang['other']                         = "Autre";

$lang['payment']                       = "Paiement";
$lang['payments']                      = "Paiements";
$lang['payments_subheading']           = "Veuillez utiliser le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['payments_create']               = "Créer un paiement";
$lang['payments_create_subheading']    = "Pour créer un nouveau Paiement, veuillez entrer les informations ci-dessous.";
$lang['payments_create_success']       = "Paiement créé avec succès";
$lang['payments_edit']                 = "Modifier le paiement";
$lang['payments_edit_subheading']      = "Pour modifier le paiement, entrez les informations ci-dessous.";
$lang['payments_edit_success']         = "Paiement mis à jour avec succès";
$lang['payments_deleted']              = "Paiement supprimé avec succès";
$lang['payment_number']                = "Numéro de paiement";
$lang['payment_details']               = "Détails de paiement";
$lang['amount']                        = "Montant";
$lang['payment_method']                = "Mode de paiement";
$lang['method']                        = "Méthode";
$lang['total_paid']                    = "Total payé";
$lang['email_payment_subject']         = "Paiement PDF de% s";
$lang['no_payment_items']              = "Les éléments de paiement sont requis. Doit être au moins 1 élément au minimum";
$lang['preview_payment_error']         = "Pour prévisualiser le paiement, saisissez toutes les informations requises.";
$lang['email_payment_heading']         = 'Salutations!';
$lang['email_payment_subheading']      = 'Vous avez reçu un paiement de <b>% s</b> . <br> Un fichier PDF est joint.';
$lang['payment_for']                   = "Paiement pour";
$lang['set_status_payment_subheading'] = "Choisissez le nouveau statut de ce reçu de paiement";

$lang['receipt']                       = "Reçu";
$lang['receipts']                      = "Les reçus de paiement";
$lang['receipt_no']                    = "N ° de reçu";
$lang['receipt_for']                   = "Réception pour";
$lang['create_receipt']                = "créer un reçu";
$lang['receipts_create']               = "Créer un reçu";
$lang['receipts_create_subheading']    = "Pour faire un nouveau reçu, veuillez entrer les informations ci-dessous.";
$lang['receipts_edit']                 = "Modifier le reçu";
$lang['receipts_edit_subheading']      = "Pour modifier ce reçu, veuillez entrer les informations ci-dessous.";
$lang['receipts_create_success']       = "Réception créée avec succès";
$lang['receipts_edit_success']         = "Réception mise à jour avec succès";
$lang['receipts_deleted']              = "Réception supprimée avec succès";


// PAYMENTS ONLINE
$lang['payments_online']               = "Paiements en ligne";
$lang['general']                       = "Général";
$lang['paypal']                        = "Pay Pal";
$lang['stripe']                        = "Stripe";
$lang['twocheckout']                   = "2Checkout";
$lang['mobilpay']                      = "MobilPay";
$lang['payments_online_requirements']  = "Ce serveur n&#39;a pas les exigences minimales pour permettre les paiements en ligne!";
$lang['payments_online_enable']        = "Activer";
$lang['biller_accounts']               = "Compte Biller";
$lang['enable']                        = "Activer";
$lang['username']                      = "Nom d&#39;utilisateur";
$lang['password']                      = "Mot de passe";
$lang['sandbox']                       = "bac à sable";
$lang['enable']                        = "Activer";
$lang['api_key']                       = "Clé API";
$lang['enable']                        = "Activer";
$lang['account_number']                = "Numéro de compte";
$lang['secretWord']                    = "Mot secret";
$lang['merchant_id']                   = "Identifiant du marchand";
$lang['public_key']                    = "Clé publique";
$lang['test_mode']                     = "Mode d&#39;essai";
$lang['panding']                       = "en attendant";
$lang['released']                      = "Libéré";
$lang['active']                        = "actif";
$lang['expired']                       = "Expiré";
$lang['finished']                      = "Fini";
$lang['payment_released']              = "Paiement réussi";
$lang['payment_canceled']              = "Le paiement est annulé";



$lang['credit_card']                   = "Carte de crédit";
$lang['credit_card_firstName']         = "Prénom";
$lang['credit_card_lastName']          = "Nom de famille";
$lang['credit_card_number']            = "Numéro de Carte de Crédit";
$lang['credit_card_expiryMonth']       = "Mois d&#39;expiration";
$lang['credit_card_expiryYear']        = "Année d&#39;expiration";
$lang['credit_card_cvv']               = "CVV / CVC";

$lang["settings_po_updated"]           = "Les paramètres de paiement en ligne sont mis à jour avec succès";

$lang['custom_field']                  = "Champ personnalisé";
$lang['custom_fields']                 = "Les champs personnalisés";
$lang['custom_field_label']            = "Etiquette de champ personnalisée";
$lang['custom_field_value']            = "Valeur du champ personnalisé";
$lang['customer_cf']                   = "Champs personnalisés du client";
$lang['custom_field_1']                = "Champ personnalisé1";
$lang['custom_field_2']                = "Champ personnalisé2";
$lang['custom_field_3']                = "Champ personnalisé3";
$lang['custom_field_4']                = "Champ personnalisé4";
$lang['vat_number']                    = "Numéro de TVA";
$lang['vat_number_placeholder']        = "Numéro d&#39;identification TVA";



// CUSTOMERS
$lang['customer_bill_to']             = 'Bill to';
$lang['customer']                     = 'Client';
$lang['customers']                    = 'Clients';
$lang['customer_add_success']         = "Client successfully added";
$lang['customer_edit_success']        = "Client successfully updated";
$lang['customer_deleted']             = "Client successfully deleted";
$lang['cant_delete_customer']         = "You can't delete this client !, cause: <br> <ul><li>This client is related with another invoice</li></ul> You have to delete all his invoices, then try again";
$lang['customers_subheading']         = 'Please use the table below to navigate or filter the results. ';
$lang['create_customer']              = 'Add client';
$lang['edit_customer']                = "Edit client";
$lang['details_customer']             = "Client Details";
$lang['create_customer_subheading']   = "To add a new client please enter the information below.";
$lang['edit_customer_subheading']     = "To edit this client please enter the information below.";
$lang['profile_customer']             = "Profil client";
$lang['profile']                      = "Profil";
$lang['edit_customer_account']        = "Modifier le compte";
$lang['create_customer_account']      = "Créer un compte";
$lang['account_created']              = "Le compte client est créé avec succès";
$lang['account_username']             = "Nom d&#39;utilisateur du compte";
$lang['account_status']               = "Statut du compte";


// SUPPLIERS
$lang['supplier_bill_to']             = 'Bill from';
$lang['supplier']                     = 'Supplier';
$lang['suppliers']                    = 'Suppliers';
$lang['supplier_add_success']         = "Supplier successfully added";
$lang['supplier_edit_success']        = "Supplier successfully updated";
$lang['supplier_deleted']             = "Supplier successfully deleted";
$lang['cant_delete_supplier']         = "You can't delete this supplier !, cause: <br> <ul><li>This Supplier is related with another invoice</li></ul> You have to delete all his invoices, then try again";
$lang['suppliers_subheading']         = 'Please use the table below to navigate or filter the results. ';
$lang['create_supplier']              = 'Add supplier';
$lang['edit_supplier']                = "Edit supplier";
$lang['details_supplier']             = "Supplier Details";
$lang['create_supplier_subheading']   = "To add a new supplier please enter the information below.";
$lang['edit_supplier_subheading']     = "To edit this supplier please enter the information below.";

// ITEMS
$lang['item']                     = 'Article';
$lang['items']                    = "Articles";
$lang['price']                    = 'Prix';
$lang['default_tax']              = 'Impôt par défaut';
$lang['default_discount']         = 'Réduction par défaut';
$lang['item_add_success']         = "Élément ajouté avec succès";
$lang['item_edit_success']        = "Article mis à jour avec succès";
$lang['item_deleted']             = "Article effacé avec succès";
$lang['cant_delete_item']         = "Vous ne pouvez pas supprimer cet élément! Cause: <br><ul><li> Cet élément est lié à une autre facture </li></ul> Vous devez supprimer toutes ses factures, puis réessayer";
$lang['items_subheading']         = 'Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.';
$lang['create_item']              = 'Ajouter un item';
$lang['edit_item']                = "Modifier l&#39;article";
$lang['details_item']             = "Détails de l&#39;article";
$lang['create_item_subheading']   = "Pour ajouter un nouvel élément, entrez les informations ci-dessous.";
$lang['edit_item_subheading']     = "Pour modifier cet élément, entrez les informations ci-dessous.";
$lang['prices']                   = "Des prix";
$lang['unit']                     = "Unité";
$lang['add_new_price']            = "Ajouter un nouveau prix";
$lang['no_item_prices']           = "Le prix de l&#39;article est requis. Doit être au moins 1 prix pour cet article au minimum";
$lang['category']                 = "Catégorie";
$lang['categories']               = "Catégories";
$lang['items_categories']         = "Catégories";
$lang['category_create']          = "Créer une nouvelle catégorie";
$lang['category_update']          = "Modifier la catégorie";
$lang['category_added']           = "Catégorie ajoutée avec succès";
$lang['category_updated']         = "Catégorie mise à jour avec succès";
$lang['category_deleted']         = "Catégorie supprimée avec succès";


$lang['invoices_activities']      = "Activités de facture";
$lang['estimates_activities']     = "Estimation des activités";
$lang['activities']               = "Activités";


$lang['files']                    = "Des dossiers";
$lang['files_subheading']         = "Files_subheading";
$lang['file_rename']              = "Renommer un fichier / dossier";
$lang['create_folder']            = "Créer le dossier";
$lang['file_move_to']             = "Bouge toi";
$lang['files_view']               = "Aperçu";
$lang['files_share']              = "Partager";
$lang['file_deleted']             = "Fichier supprimé avec succès";
$lang['file_moved_trash']         = "Fichier transféré avec succès à la corbeille";
$lang['file_restored']            = "Fichier restauré avec succès";
$lang['cant_delete_file']         = "Vous ne pouvez pas supprimer ce fichier!";
$lang['file_rename_success']      = "Fichier / dossier renommé avec succès";
$lang['file_moved_success']       = "Fichier / dossier déplacé avec succès";
$lang['create_folder_success']    = "Dossier créé avec succès";
$lang['filename']                 = "Nom de fichier";
$lang['size']                     = "Taille";
$lang['file_type']                = "Type de fichier";
$lang['upload_date']              = "Date de dépôt";
$lang['gohome']                   = "rentrer chez soi";
$lang['goback']                   = "Retourner";
$lang['open_trash']               = "Ouvrir la corbeille";
$lang['delete_definitive']        = "Supprimer définitif";
$lang['restore_file']             = "Restaurer le fichier";
$lang['grid']                     = "Vue en grille";
$lang['list']                     = "Vue en liste";
$lang['sort']                     = "Trier";
$lang['upload']                   = "Télécharger";
$lang['share']                    = "Partager";
$lang['copylink']                 = "Copier le lien";
$lang['copy']                     = "Copie";
$lang['move_to']                  = "Déménager à";
$lang['move']                     = "Bouge toi";
$lang['rename']                   = "Rebaptiser";
$lang['foldername']               = "Nom de dossier";
$lang['folder']                   = "Dossier";
$lang['text_is_copied']           = "Le texte est copié dans le presse-papiers";
$lang['no_file_selected']         = "Aucun fichier sélectionné pour télécharger!";
$lang['browse_files']             = "Parcourir les fichiers";
$lang['confirm']                  = "Confirmer";
$lang['dimensions']               = "Dimensions";
$lang['duration']                 = "Durée";
$lang['crop']                     = "Surgir";
$lang['rotate']                   = "Tourner";
$lang['choose']                   = "Choisir";
$lang['to_upload']                = "télécharger";
$lang['files_were']               = "les fichiers étaient";
$lang['file_was']                 = "le fichier était";
$lang['chosen']                   = "choisi";
$lang['drag_drop_file']           = "Faites glisser et déposez les fichiers ici";
$lang['or']                       = "ou";
$lang['drop_file']                = "Déposez les fichiers ici pour télécharger";
$lang['paste_file']               = "En collant un fichier, cliquez ici pour annuler.";
$lang['remove_confirmation']      = "Êtes-vous sûr de vouloir supprimer ce fichier?";
$lang['folder']                   = "Dossier";
$lang['filesLimit']               = "Seulement %s les fichiers peuvent être téléchargés.";
$lang['filesType']                = "Seulement %s les fichiers peuvent être téléchargés.";
$lang['fileSize']                 = "est trop grand! Veuillez choisir un fichier jusqu&#39;à %s MB.";
$lang['filesSizeAll']             = "Les fichiers que vous avez choisis sont trop grands! Téléchargez les fichiers jusqu&#39;à %s MB.";
$lang['fileName']                 = "Fichier avec le nom %s est déjà sélectionné. &#39;";
$lang['folderUpload']             = "Vous n&#39;êtes pas autorisé à télécharger des dossiers.";
$lang['no_more_space']            = "Plus d&#39;espace pour télécharger ces fichiers!";
$lang['add_attached_file']        = "Pièce jointe";
$lang['uploader']                 = "Documents";
$lang['settings_files']           = "Paramètres de téléchargement";
$lang['configuration_files']      = "Téléchargement de fichiers de configuration";
$lang['file_upload_enable']       = "permet de télécharger des fichiers";
$lang['user_disc_space']          = "Espace disque utilisateur";
$lang['user_disc_space_tip']      = "Combien d&#39;espace les fichiers d&#39;utilisateurs sont autorisés à prendre sur votre serveur (en mégaoctets).";
$lang['max_upload_size']          = "Taille de téléchargement maxi";
$lang['max_upload_size_tip']      = "La taille maximale du fichier que les utilisateurs peuvent télécharger (en mégaoctets).";
$lang['max_simult_uploads']       = "Nombre maximum de téléchargements simultanés.";
$lang['max_simult_uploads_tip']   = "Combien de fichiers les utilisateurs peuvent télécharger en même temps.";
$lang['white_list']               = "Liste blanche";
$lang['white_list_tip']           = "Les utilisateurs ne pourront télécharger de fichiers qu&#39;avec ces formats. Exemple: mp4, jpg, mp3, pdf.";
$lang["settings_files_updated"]   = "Les paramètres des fichiers sont mis à jour avec succès";

$lang['send_link_via_email']      = "Envoyer ce lien par courrier électronique";
$lang['links']                    = "Des liens";
$lang['view_link']                = "Afficher le lien";
$lang['direct_link']              = "Lien direct";
$lang['download_link']            = "Lien de téléchargement";
$lang['html_embed_code']          = "Html code intégré";
$lang['forum_embed_code']         = "Code d&#39;intégration du forum";
$lang['email_file_subject']       = "Fichier de %s ";

$lang['folder']                   = "Dossier";
$lang['folder']                   = "Dossier";
$lang['folder']                   = "Dossier";
$lang['folder']                   = "Dossier";
$lang['folder']                   = "Dossier";


// RECURRING INVOICES
$lang['rinvoice']                      = "Facture récurrente";
$lang['rinvoices']                     = "Factures récurrentes";
$lang['rinvoices_subheading']          = "Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['recu_invoice_schedule']         = "Calendrier de facturation récurrent";
$lang['frequency']                     = "La fréquence";
$lang['every']                         = "Chaque";
$lang['occurences']                    = "Les occurrences";
$lang['daily']                         = "du quotidien";
$lang['weekly']                        = "Hebdomadaire";
$lang['monthly']                       = "Mensuel";
$lang['yearly']                        = "Annuel";
$lang['day']                           = "journée";
$lang['days']                          = "Journées";
$lang['week']                          = "La semaine";
$lang['weeks']                         = "Semaines";
$lang['month']                         = "Mois";
$lang['months']                        = "Mois";
$lang['year']                          = "An";
$lang['years']                         = "Années";
$lang['recu_when_start']               = "Quand le programme automatique démarrera-t-il?";
$lang['recu_when_create']              = "Quand les factures seront-elles créées?";
$lang['invoice_will_every']            = "La facture sera créée chaque";
$lang['on']                            = "sur";
$lang['on_the']                        = "sur le";
$lang['forever']                       = "Pour toujours";
$lang['for']                           = "pour";
$lang['occurence_time']                = "Une fois";
$lang['occurence_times']               = "fois";
$lang['recurring_effective']           = "Récurrent est efficace";
$lang['package_name']                  = "Nom du paquet";
$lang['create_rinvoice']               = "Créer une facture récurrente";
$lang['create_rinvoice_subheading']    = "Pour créer une nouvelle facture récurrente, veuillez saisir les informations ci-dessous.";
$lang['rinvoice_is_canceled']          = "Cette facture récurrente est annulée, vous ne pouvez pas l&#39;éditer!";
$lang['edit_rinvoice']                 = "Modifier la facture récurrente";
$lang['edit_rinvoice_subheading']      = "Pour modifier cette facture récurrente, veuillez saisir les informations ci-dessous.";
$lang['rinvoices_activities']          = "Activités récurrentes sur facture";
$lang['rinvoice_add_success']          = "Facture récurrente créée avec succès";
$lang['rinvoice_edit_success']         = "La facture récurrente a été mise à jour avec succès";
$lang['rinvoice_deleted']              = "La facture récurrente a été supprimée avec succès";
$lang['cant_delete_rinvoice']          = "Vous ne pouvez pas supprimer cette facture récurrente! Cause: <br><ul><li> Cette facture récurrente est liée à d&#39;autres éléments </li></ul> Vous devez supprimer tous les éléments, puis réessayer";
$lang['rinvoice_duplicate_success']    = "Facture récurrente reproduite avec succès";
$lang['rinvoice_started']              = "Le profil récurrent des factures a débuté avec succès";
$lang['rinvoice_canceled']             = "Le profil récurrent des factures est annulé";
$lang['rinvoice_skipped']              = "La facture récurrente a sauté la prochaine facture avec succès";
$lang['start_profile']                 = "Profil de départ";
$lang['cancel_profile']                = "Annuler le profil";
$lang['skip_next_invoice']             = "Passer la prochaine facture";
$lang['scheduled']                     = "Planifié";
$lang['skipped']                       = "Sauf";
$lang['this_invoice_skipped']          = "Cette facture est ignorée";
$lang['next_billing_date']             = "Date de facturation suivante";
$lang['today']                         = "Aujourd&#39;hui";
$lang['cronjob_desactivated']          = "pour activer les factures récurrentes, vous devez ajouter cette commande %s sur le travail de cron dans votre CPanel";
$lang['rinvoice_draft']                = "Enregistrer la facture en tant que brouillon à chaque occurrence";
$lang['rinvoice_sent']                 = "Facture par courrier électronique directement au client à chaque occurrence";


// contracts
$lang['contract']                      = "Contrat";
$lang['contracts']                     = "Contrats";
$lang['contracts_subheading']          = "Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['create_contract']               = "Créer un nouveau contrat";
$lang['create_contract_subheading']    = "Pour créer un nouveau contrat, veuillez entrer les informations ci-dessous.";
$lang['edit_contract']                 = "Modifier le contrat";
$lang['edit_contract_subheading']      = "Pour modifier ce contrat, veuillez entrer les informations ci-dessous.";
$lang['contract_add_success']          = "Facture du contrat créée avec succès";
$lang['contract_edit_success']         = "La facture du contrat a été mise à jour avec succès";
$lang['contract_deleted']              = "La facture du contrat a été supprimée avec succès";
$lang['cant_delete_contract']          = "Vous ne pouvez pas supprimer ce contrat! Cause: <br><ul><li> Cette facture récurrente est liée à d&#39;autres éléments </li></ul> Vous devez supprimer tous les éléments, puis réessayer";
$lang['subject']                       = "Assujettir";
$lang['contract_type']                 = "Type de contrat";
$lang['contract_value']                = "Contract Value";
$lang['contract_description']          = "Description du contrat par défaut";
$lang['email_contract_subject']        = "Contrat PDF à partir de %s ";
$lang['email_contract_heading']        = 'Salutations !';
$lang['email_contract_subheading']     = 'Vous avez reçu un contrat de %s . <br> Un fichier PDF est joint.';


// Expenses
$lang['expense']                       = "Frais";
$lang['expenses']                      = "Dépenses";
$lang['expenses_subheading']           = "Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['expenses_create']               = "Créer de nouvelles dépenses";
$lang['expenses_create_subheading']    = "Pour créer une nouvelle dépense, veuillez entrer les informations ci-dessous.";
$lang['expenses_edit']                 = "Modifier les dépenses";
$lang['expenses_edit_subheading']      = "Pour modifier cette dépense, veuillez entrer les informations ci-dessous.";
$lang['expenses_create_success']       = "Dépenses créées avec succès";
$lang['expenses_edit_success']         = "Dépenses mises à jour avec succès";
$lang['expenses_deleted']              = "Dépenses supprimées avec succès";
$lang['category']                      = "Catégorie";
$lang['attachments']                   = "Pièces jointes";
$lang['download_attachments']          = "Télécharger des pièces jointes";
$lang['invoice_number']                = "Numéro de facture";
$lang['expense_number']                = "Numéro de frais";
$lang['expenses_category']             = "Catégorie";
$lang['expenses_categories']           = "Catégories";
$lang['expenses_subheading']           = "Utilisez le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['expenses_category_create']      = "Créer une nouvelle catégorie";
$lang['expenses_category_update']      = "Modifier la catégorie";
$lang['expenses_category_added']       = "Catégorie créée avec succès";
$lang['expenses_category_updated']     = "Catégorie mise à jour avec succès";
$lang['expenses_category_deleted']     = "Catégorie supprimé avec succès";
$lang['expenses_category_type']        = "Type";
$lang['expenses_category_label']       = "Étiquette";
$lang['expense_no']                    = "Dépenses N °";



$lang['amount_in_words']         = 'Le montant en mots';
$lang['nbr_conjunction']         = 'et';
$lang['nbr_negative']            = 'négatif';
$lang['nbr_decimal']             = 'point';
$lang['nbr_separator']           = ',';
$lang['nbr_inversed']            = false;
$lang['nbr_0']                   = 'zéro';
$lang['nbr_1']                   = 'un';
$lang['nbr_2']                   = 'deux';
$lang['nbr_3']                   = 'Trois';
$lang['nbr_4']                   = 'quatre';
$lang['nbr_5']                   = 'cinq';
$lang['nbr_6']                   = 'six';
$lang['nbr_7']                   = 'Sept';
$lang['nbr_8']                   = 'huit';
$lang['nbr_9']                   = 'neuf';
$lang['nbr_10']                  = 'Dix';
$lang['nbr_11']                  = 'onze';
$lang['nbr_12']                  = 'Douze';
$lang['nbr_13']                  = 'treize';
$lang['nbr_14']                  = 'Quatorze';
$lang['nbr_15']                  = 'quinze';
$lang['nbr_16']                  = 'seize';
$lang['nbr_17']                  = 'dix-sept';
$lang['nbr_18']                  = 'dix-huit';
$lang['nbr_19']                  = 'dix-neuf';
$lang['nbr_20']                  = 'vingt';
$lang['nbr_30']                  = 'trente';
$lang['nbr_40']                  = 'quarante';
$lang['nbr_50']                  = 'cinquante';
$lang['nbr_60']                  = 'soixante';
$lang['nbr_70']                  = 'soixante-dix';
$lang['nbr_80']                  = 'quatre-vingts';
$lang['nbr_90']                  = 'quatre vingt dix';
$lang['nbr_100']                 = 'cent';
$lang['nbr_200']                 = 'deux cent';
$lang['nbr_300']                 = 'trois cents';
$lang['nbr_400']                 = 'quatre cents';
$lang['nbr_500']                 = 'cinq cents';
$lang['nbr_600']                 = 'six cent';
$lang['nbr_700']                 = 'sept cent';
$lang['nbr_800']                 = 'huit cent';
$lang['nbr_900']                 = 'neuf cent';
$lang['nbr_1000']                = 'mille';
$lang['nbr_1000000']             = 'million';
$lang['nbr_1000000000']          = 'milliard';
$lang['nbr_1000000000000']       = 'billion';
$lang['nbr_1000000000000000']    = 'quadrillion';
$lang['nbr_1000000000000000000'] = 'quintillon';


$lang['report']                    = "Rapport";
$lang['reports']                   = "Rapports";
$lang['report_no_data']            = "Vous n&#39;avez aucune donnée pour cette période. Ajustez la date";
$lang['profit']                    = "Profit";
$lang['income']                    = "le revenu";
$lang['spending']                  = "Dépenses";
$lang['total_spending']            = "Total des dépenses";
$lang['outstanding_revenue']       = "Revenus exceptionnels";
$lang['total_outstanding']         = "Total en souffrance";
$lang['total_profit']              = "Bénéfice total";
$lang['total_profit']              = "Bénéfice total";
$lang['accounts_aging']            = "Vieillissement des comptes";
$lang['accounts_aging_subheading'] = "Découvrez les clients qui prennent beaucoup de temps à payer";
$lang['no_aging_accounts']         = "Aucun client en retard n&#39;a été trouvé. Veuillez régler la date.";
$lang['as_of']                     = "À partir de";
$lang['aging_age1']                = "00 - 30 jours";
$lang['aging_age2']                = "31 - 60 jours";
$lang['aging_age3']                = "61 - 90 jours";
$lang['aging_age4']                = "Plus de 90 jours";
$lang['from']                      = "De";
$lang['to']                        = "À";
$lang['revenue_by_customer']       = "Revenus par client";
$lang['invoice_details']           = "Détails de la facture";
$lang['total_revenue']             = "Revenu total";
$lang['total_invoiced']            = "Total facturé";
$lang['total_due']                 = "Total dû";
$lang['total_paid']                = "Total payé";
$lang['summary']                   = "Résumé";
$lang['tax_summary']               = "Sommaire fiscal";
$lang['tax_name']                  = "Nom de l&#39;impôt";
$lang['taxable_amount']            = "Montant imposable";
$lang['net']                       = "Net";
$lang['profit_loss']               = "Profit &amp; Loss (graphiques)";
$lang['profit_loss_subheading']    = "Aide à déterminer ce que vous devez en taxes et si vous faites plus que vous dépensez";
$lang['tax_summary_subheading']    = "Aide à déterminer combien vous devez au gouvernement les taxes de vente";
$lang['invoice_det_subheading']    = "Un résumé détaillé de toutes les factures que vous avez envoyées sur une période de temps";
$lang['revenue_cust_subheading']   = "Revenus classés par client au cours d&#39;une période donnée";


$lang['chat']                      = "Bavarder";
$lang['chat_new_message_from']     = "Nouveau message";
$lang['online']                    = "En ligne";
$lang['offline']                   = "Hors ligne";
$lang['delete_conversation']       = "Supprimer la conversation";
$lang['type_your_message']         = "tapez votre message ...";
$lang['support']                   = "Soutien";
$lang['chat_support_label']        = "Nom du support";
$lang['chat_support_id']           = "Administrateur de support";

$lang['tools']                     = "Outils";
$lang['low']                       = "Faible";
$lang['medium']                    = "Moyen";
$lang['high']                      = "Haute";
$lang['todo_task']                 = "Tâche à faire";
$lang['todo_list']                 = "Liste de choses à faire";
$lang['priority']                  = "Priorité";
$lang['mark_as_complete']          = "Marquer comme complet";
$lang['create_todo']               = "Créer une nouvelle tâche";
$lang['edit_todo']                 = "Modifier la tâche";
$lang['todo_add_success']          = "Tâche créée avec succès";
$lang['todo_edit_success']         = "Tâche correctement mise à jour";
$lang['todo_complete_success']     = "Tâche terminée avec succès";
$lang['todo_delete_success']       = "Tâche réussie supprimée";

$lang['calculator']                = "Calculatrice";

$lang['calendar']                  = "Calendrier des rappels";
$lang['calendar_subheading']       = "Cliquez sur la date pour ajouter / modifier un rappel.";
$lang['create_reminder']           = "Créer un rappel par courrier électronique";
$lang['create_reminder_subheading']= "Pour ajouter un nouveau rappel, veuillez entrer les informations ci-dessous.";
$lang['edit_reminder']             = "Mettre à jour le rappel électronique";
$lang['edit_reminder_subheading']  = "Pour modifier ce rappel, veuillez entrer les informations ci-dessous.";
$lang['reminder_add_success']      = "Rappel créé avec succès";
$lang['reminder_edit_success']     = "Rappel mis à jour avec succès";
$lang['reminder_delete_success']   = "Rappel supprimé avec succès";
$lang['reminder_for']              = "Rappel pour ";
$lang['repeat']                    = "Répéter";
$lang['repeat_every']              = "Répétez tous les";
$lang['end_date']                  = "Date de fin";
$lang['no_end']                    = "Interminable";
$lang['no_repeat']                 = "Pas de répétition";
$lang['reminder_subject']          = "Sujet du courriel";
$lang['reminder_content']          = "Contenu du courrier électronique";
$lang['untitled_reminder']         = "Un rappel sans titre";

$lang['notifications']             = "Notifications";
$lang['no_notifications']          = "0 Notifications";

$lang['exchange']                  = "Échange de devises";
$lang['exchange_subheading']       = "Changement entre les taux de change";
$lang['result']                    = "Résultat";
$lang['change']                    = "Changement";
$lang['not_supported']             = "Non supporté";


$lang['permission']                = "Autorisation";
$lang['permissions']               = "Autorisations";
$lang['members_permission']        = "Droits des membres";
$lang['posts_level_permission']    = "Autorisations de niveau Posts";
$lang['posts_level_permission_p']  = "spécifiez les messages que les membres peuvent lire et modifier";
$lang['posts_tip']                 = "Les postes sont les factures, les factures, les estimations, les dépenses, les contrats";
$lang['read_his_posts']            = "Lire et modifier les posts créés par le membre";
$lang['read_all_posts']            = "Lire et modifier tous les messages";

$lang['customer_permission']       = "Autorisations des clients";
$lang['customer_pay_methods']      = "Modes de paiement";
$lang['customer_pay_methods_p']    = "préciser les méthodes de paiement que les clients peuvent payer";
$lang['customer_pay_methods_tip']  = "Méthodes hors ligne (Cash, Chèque, Virement Bancaire, Autre), Méthodes en ligne: (Paypal, Stripe, 2Checkout ...)";
$lang['use_all_pay_methods']       = "Utiliser toutes les méthodes de paiement (en ligne et hors ligne)";
$lang['use_offline_pay_methods']   = "Utiliser les méthodes de paiement hors ligne";


$lang['link']                           = "Lien";
$lang['overdue_days']                   = "Jours en retard";
$lang['update_email_template']          = "Mettre à jour le modèle d&#39;email";
$lang['email_template_updated']         = "Le modèle d&#39;email est mis à jour avec succès";
$lang['template_name']                  = "Nom du modèle";
$lang['template']                       = "Modèle";
$lang['templates']                      = "Templates";
$lang['activation_code']                = "Code d&#39;activation";
$lang['forgotten_password_code']        = "Code de mot de passe oublié";
$lang['send_invoices_to_customer']  = "Envoyer les factures au client";
$lang['send_receipts_to_customer']  = "Envoyer des reçus au client";
$lang['send_rinvoices_to_customer'] = "Envoyer des factures récurrentes au client";
$lang['send_estimates_to_customer'] = "Envoyer des devis au client";
$lang['send_contracts_to_customer'] = "Envoyer des contrats au client";
$lang['send_customer_reminder']     = "Envoyer un rappel client";
$lang['send_overdue_reminder']      = "Envoyer un rappel en retard";
$lang['send_forgotten_password']    = "Envoyer un mot de passe oublié";
$lang['send_activate']              = "Envoyer le code d&#39;activation du compte";
$lang['send_activate_customer']     = "Envoyer le code d&#39;activation du compte client";
$lang['send_file']                  = "Envoyer le fichier";


$lang['customize_template']           = "Personnaliser le modèle";
$lang['blank']                        = "Blanc";
$lang['customize']                    = "Personnaliser";
$lang['font_size']                    = "Taille de police";
$lang['margin']                       = "Marge";
$lang['tables']                       = "les tables";
$lang['bordered']                     = "Bordé";
$lang['striped']                      = "Rayé";
$lang['line_th_height']               = "Hauteur de la tête";
$lang['line_td_height']               = "Rangées hauteur";
$lang['line_th_bg']                   = "Arrière-plan de la rubrique";
$lang['line_th_color']                = "Titre de la couleur du texte";
$lang['monocolor']                    = "Monochrome";
$lang['grayscale']                    = "Niveaux de gris";
$lang['background']                   = "Contexte";
$lang['color']                        = "Couleur";
$lang['image']                        = "Image";
$lang['position']                     = "Position";
$lang['fit']                          = "En forme";
$lang['opacity']                      = "Opacité";
$lang['bg_color']                     = "Couleur de fond";
$lang['txt_color']                    = "Couleur du texte";
$lang['stamp']                        = "Timbre";
$lang['select_color']                 = "Choisissez la couleur";



// projects
$lang['project']                      = "Projet";
$lang['projects']                     = "Projets";
$lang['projects_subheading']          = "Veuillez utiliser le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['create_project']               = "Créer un nouveau projet";
$lang['create_project_subheading']    = "Pour créer un nouveau projet, veuillez entrer les informations ci-dessous.";
$lang['edit_project']                 = "Modifier le projet";
$lang['edit_project_subheading']      = "Pour éditer ce projet, veuillez entrer les informations ci-dessous.";
$lang['project_add_success']          = "Projet créé avec succès";
$lang['project_edit_success']         = "Projet mis à jour avec succès";
$lang['project_deleted']              = "Projet supprimé avec succès";
$lang['cant_delete_project']          = "Vous ne pouvez pas supprimer ce projet!";
$lang['project_name']                 = "Nom du projet";
$lang['billing_type']                 = "Type de facturation";
$lang['total_rate']                   = "Taux total";
$lang['rate_per_hour']                = "Tarif par heure";
$lang['estimated_hours']              = "Heures estimées";
$lang['not_started']                  = "Pas commencé";
$lang['in_progress']                  = "En cours";
$lang['on_hold']                      = "En attente";
$lang['fixed_rate']                   = "Taux fixe";
$lang['project_hours']                = "Heures de projet";
$lang['task_hours']                   = "Heures de travail";
$lang['deadline']                     = "Date limite";
$lang['members']                      = "Membres";
$lang['progress']                     = "Le progrès";
$lang['task']                         = "Tâche";
$lang['tasks']                        = "les tâches";
$lang['tasks_list']                   = "Liste des tâches";
$lang['testing']                      = "Essai";
$lang['complete']                     = "Achevée";
$lang['create_task']                  = "Créer une nouvelle tâche";
$lang['edit_task']                    = "Modifier la tâche";
$lang['task_add_success']             = "Tâche créée avec succès";
$lang['task_edit_success']            = "Tâche mise à jour avec succès";
$lang['task_complete_success']        = "Tâche terminée avec succès";
$lang['task_delete_success']          = "Tâche supprimée avec succès";
$lang['project_progress']             = "L&#39;avancement du projet";
$lang['project_informations']         = "Informations sur le projet";
$lang['not_completed_tasks']          = "Tâches non terminées";
$lang['days_left']                    = "Jours restants";
$lang['overview']                     = "Aperçu";
$lang['hour_rate']                    = "Taux horaire";
$lang['hour']                         = "Heure";


$lang['partial_invoices']                = "Factures partielles";
$lang['partial_invoices_subheading']     = "Veuillez utiliser le tableau ci-dessous pour naviguer ou filtrer les résultats.";
$lang['paid_amount']                     = "Montant payé";
$lang['amount_due']                      = "Montant dû";
$lang['payment_date']                    = "Date de paiement";
$lang['rate']                            = "Taux";
$lang['activate_double_currency']        = "Activer l&#39;option double devise";
$lang['filter_customer']                 = "Filtrer par client";
$lang['customer_suggestion_placeholder'] = "Suggestion client";
$lang['daterange']                       = "Plage de dates";
$lang['filtering']                       = "Filtration";
$lang['partial_invoice_details']         = "Détails de la facture partielle";
$lang['partial_invoice_det_subheading']  = "Un résumé détaillé des factures partielles que vous avez envoyées à une période donnée";
$lang['cost_per_supplier']               = "Coûts par fournisseur";
$lang['cost_per_supplier_subheading']    = "Coûts catégorisés par fournisseur à une période donnée";
$lang['tasks_progress']                  = "Progression des tâches";
$lang['filter_supplier']                 = "Filtre des fournisseurs";
$lang['supplier_suggestion_placeholder'] = "Suggestion du fournisseur";
$lang['exchange_api']                    = "API Exchange";
$lang['create_an_account']               = "Créer un compte";
$lang['generates_an_api_key']            = "et génère une clé API";


?>
