<?php
$show_title = isset($show_title)?$show_title:true;
$show_row = isset($show_row)?$show_row:true;
$cols = isset($cols)?$cols:"col-6 col-xs-6";
?>
<?php if ($show_title): ?>
<div class="row inv">
    <div class="col-xs-12">
        <h4><?php echo lang("customer_bill_to") ?></h4>
    </div>
</div>
<?php endif ?>
<?php if ($show_row): ?>
<div class="row-cols row">
<?php endif ?>
    <div class="<?php echo $cols ?>" >
        <b class="inv">
        <?php
        if( trim($biller->company) != "" ) {
            echo $biller->company;
        } else {
            echo $biller->fullname."<br />";
        }
        ?>
        </b>
        <?php if( trim($biller->company) != "" ) { echo "<br /><b>".lang("attn")."</b>: ".$biller->fullname."<br />"; } ?>
        <?php
        if( $biller->phone ){ echo "<b>".lang("phone").":</b> ".$biller->phone."<br>";}
        if( $biller->email ){ echo "<b>".lang("email").":</b> ".$biller->email."<br>"; }
        if( $biller->website ){ echo "<b>".lang("website").":</b> ".$biller->website;}
        ?>
    </div>
    <div class="<?php echo $cols ?>" >
        <?php
        if( $biller->address  ){
            echo "<b>".lang("address").":</b> ";
            echo $biller->fulladdress.",<br />";
        }
        if( $biller->vat_number ){ echo "<b>".lang("vat_number").":</b> ".$biller->vat_number."<br>";}

        $cf = $this->settings_model->SYS_Settings;
        if( $biller->custom_field1 && trim($cf->customer_cf1) != "" ){ echo "<b>".$cf->customer_cf1.":</b> ".$biller->custom_field1."<br>";}
        if( $biller->custom_field2 && trim($cf->customer_cf2) != "" ){ echo "<b>".$cf->customer_cf2.":</b> ".$biller->custom_field2."<br>";}
        if( $biller->custom_field3 && trim($cf->customer_cf3) != "" ){ echo "<b>".$cf->customer_cf3.":</b> ".$biller->custom_field3."<br>";}
        if( $biller->custom_field4 && trim($cf->customer_cf4) != "" ){ echo "<b>".$cf->customer_cf4.":</b> ".$biller->custom_field4;}
        ?>
    </div>
<?php if ($show_row): ?>
    <div class="clearfix"></div>
</div>
<?php endif ?>
