<?php
function format_number($number_str){
	if (preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $number_str))
	{
		$number_str = $number_str;
	}
	else if (preg_match('/^\s*[$]?\s*((\d+)|(\d{1,3}(\,\d{3})+))(\.\d+)?\s*$/', $number_str))
	{
		$number_str = str_replace(",", "", $number_str);
	}
	else if (preg_match('/^\s*[$]?\s*((\d+)|(\d{1,3}(\.\d{3})+))(\,\d+)?\s*$/', $number_str))
	{
		$number_str = str_replace(".", "", $number_str);
		$number_str = str_replace(",", ".", $number_str);
	}
	else if (preg_match('/^\s*[$]?\s*((\d+)|(\d{1,3}( \d{3})+))(\,\d+)?\s*$/', $number_str))
	{
		$number_str = str_replace(" ", "", $number_str);
		$number_str = str_replace(",", ".", $number_str);
	}
	else if (preg_match('/^\s*[$]?\s*((\d+)|(\d{1,3}( \d{3})+))(\.\d+)?\s*$/', $number_str))
	{
		$number_str = str_replace(" ", "", $number_str);
	}
	else
	{
		$number_str = "0";
	}

	$number = floatval($number_str);
	return $number;
}
?>
<style type="text/css">
	input.table_input,
	input.table_input:hover,
	input.table_input:focus {
		text-align: center;
		width: 100% !important;
		padding: 0 !important;
		margin: 0 !important;
		border: 1px solid #ecde99 !important;
		background: #fcf6db !important;
		box-shadow: none !important;
	}
	input.transparent_input,
	input.transparent_input:hover,
	input.transparent_input:focus {
		text-align: center;
		width: 100% !important;
		padding: 0 !important;
		margin: 0 !important;
		border: none !important;
		background: none !important;
		box-shadow: none !important;
	}
	th {
		vertical-align: middle !important;
		text-align: center !important;
	}
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<div class="row bs-wizard step-count-4">
	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_upload_file') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_match_fields') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step active"><!-- active -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_confirm_data') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step disabled"><!-- disabled -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_add_to_database') ?></div>
	</div>
</div>

<?php
$hiddens = array(
	"file_path" => $file_path,
	"csv_delimiter" => $csv_delimiter,
	"pathfile" => $file_path,
	);
$attrib = array('class' => 'form-horizontal ');
echo form_open("import_data/add_to_database?section=".$section, $attrib, $hiddens);
?>
<table class="table table-sm table-striped table-bordered table-condensed table-hover">
	<thead>
		<?php foreach ($fields_relations as $key => $value): ?>
			<th class=""><?php echo lang($fields[$key][0]) ?></th>
		<?php endforeach ?>
		<th style="width: 20px;"><i class="fa fa-trash"></i></th>
	</thead>
	<tbody>
		<?php foreach ($insert_data as $key => $data): ?>
			<tr>
				<?php
				foreach ($data as $key1 => $value){
					$required = ($fields[$key1][1]?'required="required" data-error="'.lang($fields[$key1][0]).' '.lang('is_required').'"':'');
					$f = array(
						"type" => $fields[$key1][2],
						"name" => $key1."[]"
					);
					if( $fields[$key1][2] == "checkbox"){
						if($value==true) $f["checked"] = "checked";
					}
					if( $fields[$key1][2] == "number"){
						if( isset($fields[$key1]["step"]) ) { $f["step"] = $fields[$key1]["step"]; }
						if( isset($fields[$key1]["min"]) ) { $f["min"] = $fields[$key1]["min"]; }
						if( isset($fields[$key1]["max"]) ) { $f["max"] = $fields[$key1]["max"]; }
						$f["value"] = format_number($value);
					}
					if( $fields[$key1][2] == "text"){
						if( isset($fields[$key1]["max"]) ) { $f["maxlength"] = $fields[$key1]["max"]; }
					}

					$list_o = array();
					if( $fields[$key1][2] == "select"){
						if( isset($fields[$key1]["list"]) ) {
							$list_o = $fields[$key1]["list"];
						}else{
							$fields[$key1][2] = "text";
						}
					}

					if( $value !== false ){
						$Input_class="transparent_input";
					}else{
						$Input_class="table_input";
					}

					if( $fields[$key1][2] == "select"){
						$d = $value !== false?$value:(isset($fields[$key1]["default_list"])?$fields[$key1]["default_list"]:"");
						echo "<td>".(form_dropdown($key1."[]", $list_o, $d, 'class="'.$Input_class.'" '.$required))."</td>";
					}else{
						echo "<td>".(form_input($f, $value, 'class="'.$Input_class.'" '.$required))."</td>";
					}
				}
				?>
				<td><i class="fa fa-trash tip-top del_item" title="<?php echo lang('idata_delete_item') ?>" style="cursor:pointer;" data-placement="right"></i></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('previous', lang('previous'), array('class' => 'btn btn-primary'));?>
  <?php echo form_submit('submit', lang('next'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
<script type="text/javascript">
$(function() {
    $("input[name=previous]").click(function(e){
        $(this).parents("form").attr("action", "<?php echo site_url("/import_data/match_fields?section=".$section) ?>").submit();
        e.preventDefault();
        return false;
    });
	$('.del_item').click(function(){
		$(this).parents('tr').remove();
		return false;
	});

	$.each($('input[type="checkbox"]'), function(i, checkbox){
		var name = $(checkbox).attr('name');
		var value = $(checkbox).val();
		var input = $('<input type="hidden" name="'+name+'" value="'+value+'" />');
		$(input).insertAfter($(checkbox));
		$(checkbox).attr('name', '');
	});

	$('input[type="checkbox"]').change(function(){
		var checkbox = this;
		$(checkbox).next('input').val((checkbox.checked?"1":"0"));
	});
});
</script>
