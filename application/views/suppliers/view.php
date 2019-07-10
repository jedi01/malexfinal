<?php
$show_title = isset($show_title)?$show_title:true;
$show_row = isset($show_row)?$show_row:true;
$cols = isset($cols)?$cols:"col-6 col-xs-6";
?>
<?php if ($show_title): ?>
<div class="row inv">
    <div class="col-xs-12">
        <h4><?php echo lang("supplier_bill_to") ?></h4>
    </div>
</div>
<?php endif ?>
<?php if ($show_row): ?>
<div class="row-cols row">
<?php endif ?>
    <div class="<?php echo $cols ?>" >
        <b class="inv">
        <?php
        if( trim($supplier->company) != "" ) {
            echo $supplier->company;
        } else {
            echo $supplier->fullname."<br />";
        }
        ?>
        </b>
        <?php if( trim($supplier->company) != "" ) { echo "<br /><b>".lang("attn")."</b>: ".$supplier->fullname."<br />"; } ?>
        <?php
        if( $supplier->phone ){ echo "<b>".lang("phone").":</b> ".$supplier->phone."<br>";}
        if( $supplier->email ){ echo "<b>".lang("email").":</b> ".$supplier->email."<br>"; }
        if( $supplier->website ){ echo "<b>".lang("website").":</b> ".$supplier->website;}
        ?>
    </div>
    <div class="<?php echo $cols ?>" >
        <?php
        if( $supplier->address  ){
            echo "<b>".lang("address").":</b> ";
            echo $supplier->fulladdress.",<br />";
        }
        if( $supplier->vat_number ){ echo "<b>".lang("vat_number").":</b> ".$supplier->vat_number."<br>";}

        $cf = $this->settings_model->SYS_Settings;
        if( $supplier->custom_field1 && trim($cf->supplier_cf1) != "" ){ echo "<b>".$cf->supplier_cf1.":</b> ".$supplier->custom_field1."<br>";}
        if( $supplier->custom_field2 && trim($cf->supplier_cf2) != "" ){ echo "<b>".$cf->supplier_cf2.":</b> ".$supplier->custom_field2."<br>";}
        if( $supplier->custom_field3 && trim($cf->supplier_cf3) != "" ){ echo "<b>".$cf->supplier_cf3.":</b> ".$supplier->custom_field3."<br>";}
        if( $supplier->custom_field4 && trim($cf->supplier_cf4) != "" ){ echo "<b>".$cf->supplier_cf4.":</b> ".$supplier->custom_field4;}
        ?>
    </div>
<?php if ($show_row): ?>
    <div class="clearfix"></div>
</div>
<?php endif ?>
