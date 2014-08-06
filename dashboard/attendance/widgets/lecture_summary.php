<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="accordion-toggle">
						Lecture Details
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<table class="panel-body table table-bordered" style="margin-bottom:0px" id="lec_details">
					<tr id="inst_name">
						<th >Institute</th>
						<td></td>
					</tr>
					<tr id="prog_name">
						<th >Programme</th>
						<td></td>
					</tr>
					<tr id="dept_name">
						<th >Branch</th>
						<td></td>
					</tr>
					<tr id="semester">
						<th >Semester</th>
						<td></td>
					</tr>
					<tr id="division">
						<th >Division</th>
						<td></td>
					</tr>
					<tr id="batchno">
						<th >Batchno</th>
						<td></td>
					</tr>
					<tr id="subject">
						<th >Subject</th>
						<td></td>
					</tr>
<?php
	if(!empty($spec_field['simple']))
	{	$form=<<<EOF
			<tr id="{$spec_field['simple']['id']}">
				<th >{$spec_field['simple']['label']}</th>
				<td></td>
			</tr>
EOF;
		echo $form;
	}
?>
<?php
    if(!empty($spec_field['date'])){
?>
					<tr id="date">
						<th ><label for="lec_date">Lecture Date (dd-mm-yyyy)</label></th>
						<td style="padding:1px"><input class="form-control date-control" type="text" id="lec_date" value="<?php echo (new DateTime)->format("d-m-Y"); ?>"/></td>
					</tr>
<?php
    }
?>
<?php
    if(!empty($spec_field['radio_2']))
    {
        $form=<<<EOF
					<tr class="no-print">
						<th ><label for="{$spec_field['radio_2_id']}">{$spec_field['radio_2_label']}</label></th>
						<td style="padding:1px">
                            <div id="{$spec_field['radio_2_id']}" class="ui-radio-2 col-lg-5 col-sm-7 zero-pad">
                                <input type="radio" name="{$spec_field['radio_2_id']}" id="{$spec_field['radio_2_id']}_1" value="1" checked="checked"/>
                                <label style="margin-bottom:0px" for="{$spec_field['radio_2_id']}_1">{$spec_field['radio_2_1']}</label>
                                <input type="radio" name="{$spec_field['radio_2_id']}" id="{$spec_field['radio_2_id']}_2" value="0"/>
                                <label style="margin-bottom:0px" for="{$spec_field['radio_2_id']}_2">{$spec_field['radio_2_2']}</label>
                            </div>
                        </td>
					</tr>
EOF;
        echo $form;
    }
?>
				</table>
			</div>
		</div>
	</div>