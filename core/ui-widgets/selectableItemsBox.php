<?php
function selectableItemsBox($title,$class,$items_id)
{	$form=<<<EOF
	<div class="sel-items {$class}">
		<h2>{$title}</h2>
		<table class="sel-items-options">
			<tr>
				<th><a href="#" class="opt-select-all sel-options">Select All</a></th>
				<th><a href="#" class="opt-deselect-all sel-options">Deselect All</a></th>
			</tr>
		</table>
		<div class="checkbox-items zero-pad" id="{$items_id}"></div>
	</div>
EOF;
	return $form;
}
?>