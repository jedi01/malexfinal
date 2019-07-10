<body dir="<?php echo (lang("IS_RTL"))?"rtl":"ltr" ?>">
<div class="loading-backdrop" id="page_loading" style="display: block;"></div>
<?php if ($this->ion_auth->logged_in ()): ?>
<div class="navbar-mainmenu navbar-mainmenu-fixed-top <?php echo (lang("IS_RTL"))?"rtl":"" ?>">
  <div class="navbar-mainmenu-inner ">
    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#collapse-navbar">
      <i class="fa fa-bars"></i>
    </button>
    <a href="<?=base_url() ?>/" tabindex="-1" class="brand-up" style="width: 100%;">
      <img src="<?=base_url("assets/img/logo-white.png") ?>" alt="<?php echo APP_DESCRIPTION ?>" style="height:26px;">
      <span></span>
    </a>
    <div class="nav-collapse collapse accordion-body" id="collapse-navbar" >
      <ul class="nav">
        <li class="dropdown" >
          <a href="<?=base_url() ?>/" tabindex="-1" class="brand">
            <img src="<?=base_url("assets/img/logo-white.png") ?>" alt="<?php echo APP_DESCRIPTION ?>" height="100%">
            <span></span>
          </a>
        </li>
        <li class="dropdown" >
          <a href="<?=base_url() ?>/" tabindex="-1">
            <span><?php echo lang("dashboard") ?></span>
          </a>
        </li>

        <li class="dropdown" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
            <span><?php echo lang("purchases") ?></span>
          </a>
          <ul class="dropdown-menu" >
            <li><a href="<?=base_url() ?>/purchases" tabindex="-1">
              <i class="fa fa-cut"></i>
              <span><?php echo lang("purchase_order") ?></span>
            </a></li>
            <li><a href="<?=base_url() ?>/expenses" tabindex="-1">
              <i class="fa fa-cut"></i>
              <span><?php echo lang("expenses") ?></span>
            </a></li>
              <!-- <li><a href="<?=base_url() ?>/expenses/create" sis-modal="expenses_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("expenses_create") ?></span>
                </a></li> -->
                <li class="divider"></li>
                <li><a href="<?=base_url() ?>/suppliers" tabindex="-1">
                  <i class="fa fa-truck"></i>
                  <span><?php echo lang("suppliers") ?></span>
                </a></li>
          <!--     <li><a href="<?=base_url() ?>/suppliers/create" sis-modal="suppliers_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("create_supplier") ?></span>
                </a></li> -->
                <li class="divider"></li>
                <li><a href="<?=base_url() ?>/expenses/categories" tabindex="-1">
                  <i class="fa fa-tags"></i>
                  <span><?php echo lang("expenses_categories") ?></span>
                </a></li>
             <!--  <li><a href="<?=base_url() ?>/expenses/create_category" sis-modal="categories_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("expenses_category_create") ?></span>
                </a></li> -->
              </ul>
            </li>

          <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("Sales") ?></span>
            </a>
            <ul class="dropdown-menu" >
             <!--  <li><a href="<?=base_url() ?>/invoices/create" tabindex="-1">
                  <i class="fa fa-file-o"></i>
                  <span><?php echo lang("create_invoice") ?></span>
                  <small class="nav-shortcut">CTRL+SHIFT+O</small>
                </a></li> -->
              <li><a href="<?=base_url() ?>/invoices" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("invoices") ?></span>
                  <small class="nav-shortcut">CTRL+O</small>
                </a></li>
              <li class="divider"></li>
              <?php if ( ENABLE_RECURRING ): ?>
             <!--  <li><a href="<?=base_url() ?>/rinvoices/create" tabindex="-1">
                  <i class="fa fa-file-o"></i>
                  <span><?php echo lang("create_rinvoice") ?></span>
                </a></li> -->
              <li><a href="<?=base_url() ?>/rinvoices" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("rinvoices") ?></span>
                </a></li>
              <li class="divider"></li>
              <?php endif; //ENABLE_RECURRING ?>
            <!--   <li><a href="<?=base_url() ?>/estimates/create" tabindex="-1">
                  <i class="fa fa-file-o"></i>
                  <span><?php echo lang("create_estimate") ?></span>
                  <small class="nav-shortcut">CTRL+SHIFT+E</small>
                </a></li> -->
              <li><a href="<?=base_url() ?>/estimates" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("estimates") ?></span>
                  <small class="nav-shortcut">CTRL+E</small>
                </a></li>
              <li class="divider"></li>
             <!--  <li><a href="<?=base_url() ?>/receipts/create" sis-modal="receipts_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("receipts_create") ?></span>
                  <small class="nav-shortcut">CTRL+SHIFT+R</small>
                </a></li> -->
              <!-- <li><a href="<?=base_url() ?>/receipts" tabindex="-1">
                  <i class="fa fa-file-text-o"></i>
                  <span><?php echo lang("receipts") ?></span>
                  <small class="nav-shortcut">CTRL+R</small>
                </a></li> -->
            </ul>
          </li>
           <li class="dropdown" >
          <a href="<?=base_url() ?>/receipts" tabindex="-1">
            <span><?php echo lang("receipt") ?></span>
          </a>
        </li>
          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("items") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <!-- <li><a href="<?=base_url() ?>/items/create" sis-modal="items_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-file-o"></i>
                  <span><?php echo lang("create_item") ?></span>
                  <small class="nav-shortcut">CTRL+SHIFT+I</small>
                </a></li> -->
              <li><a href="<?=base_url() ?>/items" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("items") ?></span>
                  <small class="nav-shortcut">CTRL+I</small>
                </a></li>
              <li class="divider"></li>
             <!--  <li><a href="<?=base_url() ?>/items/create_category" sis-modal="categories_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("category_create") ?></span>
                </a></li> -->
              <li><a href="<?=base_url() ?>/items/categories" tabindex="-1">
                  <i class="fa fa-tags"></i>
                  <span><?php echo lang("categories") ?></span>
                </a></li>

              
            </ul>
          </li>

          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("miscellaneous") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li><a href="<?=base_url() ?>/je_current" tabindex="-1">
                  <i class="fa fa-truck"></i>
                  <span><?php echo lang("journal_entry") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/billers" tabindex="-1">
                  <i class="fa fa-truck"></i>
                  <span><?php echo lang("customers") ?></span>
                  <small class="nav-shortcut">CTRL+B</small>
                </a></li>
             <!--  <li><a href="<?=base_url() ?>/billers/create" sis-modal="billers_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("create_customer") ?></span>
                  <small class="nav-shortcut">CTRL+SHIFT+B</small>
                </a></li> -->
              <?php if (ENABLE_CONTRACTS): ?>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/contracts" tabindex="-1">
                  <i class="fa fa-file-text"></i>
                  <span><?php echo lang("contracts") ?></span>
                </a></li>
              <?php endif; //ENABLE_CONTRACTS ?>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/projects" tabindex="-1">
                  <i class="fa fa-tasks"></i>
                  <span><?php echo lang("projects") ?></span>
                </a></li>
              <!-- <li><a href="<?=base_url() ?>/projects/create" sis-modal="projects_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-plus"></i>
                  <span><?php echo lang("create_project") ?></span>
                </a></li> -->
            </ul>
          </li>



          <?php endif; // not customer ?>

          <?php if ($this->ion_auth->in_group(array("customer", "supplier"))): ?>
          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("file") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li><a href="<?=base_url() ?>/invoices" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("invoices") ?></span>
                  <small class="nav-shortcut">CTRL+O</small>
                </a></li>
              <li><a href="<?=base_url() ?>/estimates" tabindex="-1">
                  <i class="fa fa-folder-open-o"></i>
                  <span><?php echo lang("estimates") ?></span>
                  <small class="nav-shortcut">SHIFT+E</small>
                </a></li>
              <li><a href="<?=base_url() ?>/receipts" tabindex="-1">
                  <i class="fa fa-file-text-o"></i>
                  <span><?php echo lang("receipts") ?></span>
                  <small class="nav-shortcut">CTRL+R</small>
                </a></li>
              <li><a href="<?=base_url() ?>/payments" tabindex="-1">
                  <i class="fa fa-money"></i>
                  <span><?php echo lang("payments") ?></span>
                  <small class="nav-shortcut">SHIFT+P</small>
                </a></li>
              <?php if (ENABLE_CONTRACTS): ?>
              <li><a href="<?=base_url() ?>/contracts" tabindex="-1">
                  <i class="fa fa-file-text"></i>
                  <span><?php echo lang("contracts") ?></span>
                </a></li>
              <?php endif; //ENABLE_CONTRACTS ?>
              <li><a href="<?=base_url() ?>/projects" tabindex="-1">
                  <i class="fa fa-tasks"></i>
                  <span><?php echo lang("projects") ?></span>
                </a></li>
            </ul>
          </li>
          <?php endif; // is customer ?>

          <?php if ($this->ion_auth->is_admin()): ?>
<!--           <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("users") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li>
                <a href="<?=base_url() ?>/auth" tabindex="-1">
                  <i class="fa fa-users"></i>
                  <span><?php echo lang("users") ?></span>
                  <small class="nav-shortcut">CTRL+U</small>
                </a>
              </li> -->
             <!--  <li>
                <a href="<?=base_url() ?>/auth/create_user" sis-modal="users_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-user-plus"></i>
                  <span><?php echo lang("index_create_user_link") ?></span>
                </a>
              </li> -->
           <!--  </ul>
          </li> -->
          <?php endif; // is Admin ?>

          <li class="dropdown" >
            <a href="<?=base_url() ?>/files" tabindex="-1">
              <span><?php echo lang("uploader") ?></span>
            </a>
          </li>

          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("tools") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li>
                <a href="<?=base_url() ?>/todo" tabindex="-1">
                  <i class="fa fa-tasks"></i>
                  <span><?php echo lang("todo_list") ?></span>
                </a>
              </li>
              <li>
                <a href="#" class="create_calculator" tabindex="-1">
                  <i class="fa fa-calculator"></i>
                  <span><?php echo lang("calculator") ?></span>
                </a>
              </li>
              <?php if ( trim(EXCHANGE_API_KEY) != "" ): ?>
              <li>
                <a href="<?=base_url() ?>/home/exchange" sis-modal="" class="sis_modal" tabindex="-1">
                  <i class="fa fa-exchange"></i>
                  <span><?php echo lang("exchange") ?></span>
                </a>
              </li>
              <?php endif ?>
              <?php if ($this->settings_model->SYS_Settings->reminder_enable && $this->ion_auth->is_admin()): ?>
              <li>
                <a href="<?=base_url() ?>/calendar" tabindex="-1">
                  <i class="fa fa-calendar"></i>
                  <span><?php echo lang("calendar") ?></span>
                </a>
              </li>
              <?php endif; //reminder_enable & is admin ?>
            </ul>
          </li>
          <?php if ($this->ion_auth->is_admin()): ?>
          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("reports") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li><a href="<?=base_url() ?>/reports/accounts_aging" tabindex="-1">
                  <i class="fa fa-hourglass"></i>
                  <span><?php echo lang("accounts_aging") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/reports/profit_loss" tabindex="-1">
                  <i class="fa fa-line-chart"></i>
                  <span><?php echo lang("profit_loss") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/reports/revenue_by_customer" tabindex="-1">
                  <i class="fa fa-users"></i>
                  <span><?php echo lang("revenue_by_customer") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/reports/cost_per_supplier" tabindex="-1">
                  <i class="fa fa-truck"></i>
                  <span><?php echo lang("cost_per_supplier") ?></span>
                </a></li>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/reports/invoice_details" tabindex="-1">
                  <i class="fa fa-map-o"></i>
                  <span><?php echo lang("invoice_details") ?></span>
                </a></li>
                <li><a href="<?=base_url() ?>/reports/purchase_order_detail" tabindex="-1">
                  <i class="fa fa-map-o"></i>
                  <span><?php echo lang("purchase_detail") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/reports/tax_summary" tabindex="-1">
                  <i class="fa fa-institution"></i>
                  <span><?php echo lang("tax_summary") ?></span>
                </a></li>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/payments" tabindex="-1">
                  <i class="fa fa-calendar-check-o"></i>
                  <span><?php echo lang("payments") ?></span>
                </a></li>
            </ul>
          </li>

          <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo lang("settings") ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li><a href="<?=base_url() ?>/settings?config=settings_general" tabindex="-1">
                  <i class="fa fa-gear"></i>
                  <span><?php echo lang("settings_general") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/settings?config=settings_company" tabindex="-1">
                  <i class="fa fa-home"></i>
                  <span><?php echo lang("settings_company") ?></span>
                </a></li>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/settings?config=settings_template" tabindex="-1">
                  <i class="fa fa-file-text-o"></i>
                  <span><?php echo lang("settings_template") ?></span>
                </a></li>
                
              <li><a href="<?=base_url() ?>/settings?config=settings_email" tabindex="-1">
                  <i class="fa fa-envelope"></i>
                  <span><?php echo lang("settings_email") ?></span>
                </a></li>
              <li><a href="<?=base_url() ?>/settings?config=settings_tax_rates" tabindex="-1">
                  <i class="fa fa-calculator"></i>
                  <span><?php echo lang("settings_tax_rates") ?></span>
                </a></li>
              <?php if ($this->ion_auth->in_group(array("superadmin"))): ?>
              <li><a href="<?=base_url() ?>/settings?config=settings_files" tabindex="-1">
                  <i class="fa fa-folder-o"></i>
                  <span><?php echo lang("settings_files") ?></span>
                </a></li>
              <?php endif; //superadmin ?>
              <?php if (PAYMENTS_ONLINE_REQUIREMENTS): ?>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/settings?config=payments_online" tabindex="-1">
                  <i class="fa fa-credit-card-alt"></i>
                  <span><?php echo lang("payments_online") ?></span>
                </a></li>
              <?php endif; //PAYMENTS_ONLINE_REQUIREMENTS ?>
              <li class="divider"></li>
              <li><a href="<?=base_url() ?>/import_data" sis-modal="" class="sis_modal" tabindex="-1">
                  <i class="fa fa-upload"></i>
                  <span><?php echo lang("import_data") ?></span>
                </a></li>
                              <li><a href="<?=base_url() ?>/settings?config=settings_charts_of_accounts" tabindex="-1">
                  <i class="fa fa-tags"></i>
                  <span><?php echo lang("chart_of_accounts") ?></span>
                </a>
              </li>
              <li><a href="<?=base_url() ?>/settings?config=settings_db" tabindex="-1">
                  <i class="fa fa-clock-o"></i>
                  <span><?php echo lang("settings_db") ?></span>
                </a></li>
                 <li><a href="<?=base_url() ?>/settings?config=initial_balance" tabindex="-1">
                  <i class="fa fa-clock-o"></i>
                  <span><?php echo lang("initial_balance") ?></span>
                </a></li>


                <li><a href="<?=base_url() ?>/settings?config=users" tabindex="-1">
                  <i class="fa fa-clock-o"></i>
                  <span><?php echo lang("users") ?></span>
                </a></li>
            </ul>
          </li>
          <?php endif; //is Admin ?>

          <li class="dropdown right" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1"><i class="fa fa-info-circle"></i>&nbsp;</a>
            <ul class="dropdown-menu" >
              <li>
                <a href="#show_shortcut_help" tabindex="-1">
                  <i class="fa fa-info-circle"></i>
                  <span><?php echo lang("shortcut_help") ?></span>
                  <small class="nav-shortcut">SHIFT+F1</small>
                </a>
              </li>
              <li>
                <a href="#about" tabindex="-1">
                  <i class="fa fa-exclamation-circle"></i>
                  <span><?php echo lang("about") ?></span>
                </a>
              </li>
            </ul>
          </li>
          <!-- Profile -->
          <li class="dropdown right" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span><?php echo USER_NAME ?></span>
            </a>
            <ul class="dropdown-menu" >
              <li>
                <a href="<?=base_url("/auth/change_password"); ?>" sis-modal="users_table" class="sis_modal" tabindex="-1">
                  <i class="fa fa-shield"></i> <span><?php echo lang("change_password") ?></span>
                </a>
              </li>
              <li>
                <a href="<?=base_url("/auth/logout"); ?>" tabindex="-1">
                  <i class="fa fa-lock"></i> <span><?php echo lang("logout") ?></span>
                </a>
              </li>
            </ul>
          </li>
        <?php if ($this->settings_model->SYS_Settings->chat_enable): ?>
          <li class="right chat-toggler-btn" title="<?php echo lang("chat") ?>">
            <a href="#" class="aside-toggle" tabindex="-1">
              <i class="fa fa-comments"></i>
              <span class="label-pill label-danger label" style="display: none">1</span>
            </a>
          </li>
        <?php endif; //chat_enable ?>
        <li class="dropdown right sis-notifications" title="<?php echo lang("notifications") ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
            <i class="fa fa-bell"></i>
            <span class="label-pill label-danger label" style="display: none">1</span>
          </a>
          <ul class="dropdown-menu" >
            <li class="text-xs-center text-muted small"><?php echo lang("no_notifications") ?></li>
          </ul>
        </li>
        <!-- Languages -->
        <li class="dropdown right" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
            <img src="<?=base_url("assets/img/flags/".LANGUAGE.".png"); ?>" class="img-flag" />&nbsp;
            <span class="hidden-lg-up"><?php echo lang("language") ?></span>
          </a>
          <ul class="dropdown-menu" >
            <?php
              $languages = $this->settings_model->getAvailableLanguages();
              foreach ($languages as $key => $value) {
                echo '<li><a href="'.base_url("/settings/change_language?lang=".$key).'" tabindex="-1">
                <img src="'.base_url("assets/img/flags/".$key.".png").'" class="img-flag"> '.$value.'</a></li>';
              }
            ?>
          </ul>
        </li>
      </ul>
    </div>
    <div style="clear:both;"></div>
  </div>
</div>
<div style="clear:both;"></div>
<?php else: // is logged in ?>
  <div class="dropdown choose_lang" >
    <a href="#" data-toggle="dropdown">
      <img src="<?=base_url("assets/img/flags/".LANGUAGE.".png"); ?>" class="img-flag" />
    </a>
    <ul class="dropdown-menu dropdown-menu-right" >
      <?php
        $languages = $this->settings_model->getAvailableLanguages();
        foreach ($languages as $key => $value) {
          $class = $key == LANGUAGE? "dropdown-item active p-x-h":"dropdown-item p-x-h";
          echo '<a href="'.base_url("/settings/change_language?lang=".$key).'" class="'.$class.'">
          <img src="'.base_url("assets/img/flags/".$key.".png").'" class="img-flag"> '.$value.'</a>';
        }
      ?>
    </ul>
  </div>
<?php endif; // not logged in ?>

<!-- Main content -->
<main class="main">
