<?php
global $dir;
$user_status['1']=$this->user_status==1?"checked":"";
$user_status['2']=$this->user_status==0?"checked":"";
$form = <<<EOF
	<div class="form-group {$class['user_name']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_name">Username:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="user_name" id="user_name" maxlength="%d" value="{$this->user_name}" placeholder="E.g. chirayu.chiripal"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block">{$guide['user_name']}</div>
	</div>
	<div class="form-group {$class['email_id']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="email_id">Email ID:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="email_id" id="email_id" maxlength="%d" value="{$this->email_id}" placeholder="E.g. example@example.com"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block">{$guide['email_id']}</div>
	</div>
	<div class="form-group {$class['user_password']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_password">Password:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="password" name="user_password" id="user_password" maxlength="%d" autocomplete="off"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block">{$guide['user_password']}</div>
	</div>
	<div class="form-group {$class['user_password']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_password1">Re-type Password:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="password" name="user_password1" id="user_password1" maxlength="%d" autocomplete="off"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block"></div>
	</div>
	<div class="form-group {$class['faculty_id']}">
		<label class="col-lg-3 col-sm-3 control-label" for="faculty_id">Select Faculty:</label>
		<div class="col-lg-5 col-sm-6">
			<select class="form-control ajax-control" id="faculty_id" name="faculty_id" size="1" data-val="{$this->faculty_id}">
			</select>
			<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
		</div>
	</div>
	<div class="form-group {$class['privilege_id']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="privilege_id">Privilege Level:</label>
		<div class="col-lg-3 col-sm-4">
			<select class="form-control ajax-control" id="privilege_id" name="privilege_id" size="1" data-val="{$this->privilege_id}">
			</select>
			<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
		</div>
	</div>
	<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_status">User Status:</label>
	<div id="user_status" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="user_status" id="user_status_1" value="1" {$user_status['1']}/>
		<label for="user_status_1">Unlocked</label>
		<input type="radio" name="user_status" id="user_status_2" value="0" {$user_status['2']}/>
		<label for="user_status_2">Locked</label>
	</div>
</div>
EOF;
return sprintf($form,$nm::MAX_USR_LENGTH,$nm::MAX_USR_LENGTH,$nm::MAX_PWD_LENGTH,$nm::MAX_PWD_LENGTH);
?>