
            </div>
            <!-- /.conainer-fluid -->
        </main>
        <?php if ($this->settings_model->SYS_Settings->chat_enable): ?>
            <?php echo $this->load->view('global/chat', array(), true); ?>
        <?php endif ?>
        <footer class="footer">
            <small class="text-left">
                <a href="#">Bookkeeping software</a>
            </small>
            <small class="pull-right flip">
                Powered by <a href="mailto:bessemzitouni@gmail.com">PHP</a>
            </small>
        </footer>
<?php
$this->load->enqueue_script("assets/vendor/jquery-ui/jquery-ui.js");
$this->load->enqueue_script("assets/js/libs/tether.min.js");
$this->load->enqueue_script("assets/js/libs/bootstrap.min.js");
$this->load->enqueue_script("assets/js/libs/pace.min.js");
//$this->load->enqueue_script("assets/js/libs/Chart.min.js");
$this->load->enqueue_script("assets/vendor/chartjs/Chart.min.js");
$this->load->enqueue_script("assets/js/libs/select2.min.js");
$this->load->enqueue_script("assets/vendor/toastrjs/toastr.min.js");
$this->load->enqueue_script("assets/vendor/bootbox/bootbox.js");
$this->load->enqueue_script("assets/js/libs/gauge.min.js");
$this->load->enqueue_script("assets/vendor/moment/moment.js");
if( LANG != "en" ){
    $this->load->enqueue_script("assets/vendor/moment/locale/".LANG.".js");
}
$this->load->enqueue_script("assets/js/libs/daterangepicker.js");
$this->load->enqueue_script("assets/vendor/bootstrap.datepicker/js/bootstrap-datepicker.min.js");
$this->load->enqueue_script("assets/vendor/tinymce/js/tinymce/tinymce.min.js");
if( LANG != "en" ){
    $this->load->enqueue_script("assets/vendor/bootstrap.datepicker/locales/bootstrap-datepicker.".LANG.".min.js");
}
$this->load->enqueue_script("assets/js/libs/jquery.maskedinput.min.js");
$this->load->enqueue_script("index.php/settings/jsConstant/footer?v=".rand(1000, 9999));
$this->load->enqueue_script("assets/js/mainmenu.js");
$this->load->enqueue_script("assets/js/app.js");
echo $this->load->javascript();
?>
<script type="text/javascript">
var additional_breadcrumbs;
<?php if (isset($breadcrumbs)): ?>
additional_breadcrumbs = <?php echo json_encode($breadcrumbs) ?>;
<?php endif ?>
<?php if (isset($breadcrumb_first)): ?>
var breadcrumbs = <?php echo json_encode( array_merge( array("home" => $this->router->default_controller, "class_label" => $this->router->class, "class" => $this->router->class, "method" => $this->router->method, "title" => $page_title), $breadcrumb_first) );?>;
<?php else: ?>
var breadcrumbs = <?php echo json_encode(array("home" => $this->router->default_controller, "class_label" => $this->router->class, "class" => $this->router->class, "method" => $this->router->method, "title" => $page_title));?>;
<?php endif ?>
// <?php 
// if(!isset($breadcrum_false)){
//     ?>
//     create_breadcrumb();
//     <?php
// }
// ?>

$(document).ready(function(){
    $('#page_loading').fadeOut(function(){$(this).remove();});
    <?php
    if (isset($success_message)) {
        echo "showToastr('success', '".str_replace("\n", "%n", trim($success_message))."');";
    }
    if (isset($message)) {
        echo "showToastr('error', '".str_replace("\n", "%n", trim($message))."');";
    }
    if (isset($error_fields) && count($error_fields) > 0) {
        echo "$('form').show_errors(".json_encode($error_fields).");";
    }
    ?>
    PAGE_IS_LOADED = true;
});
</script>
        <?php echo $this->load->view ( 'global/calculator' , array(), true ); ?>
        <div class="loading-backdrop"></div>
    </body>
</html>
