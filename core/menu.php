
<?php
if(isset($menu_valid) && $menu_valid=1){
$masters_valid=false;
$masters=<<<EOM
<ul class="nav navbar-nav">
	<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Masters<span class="caret"></span></a>
		  <ul class="dropdown-menu">
EOM;
	try
	{	require_once $dir."core/rights.php";
		$ram_all=get_rights();
		foreach($menu_items as $mi => $mv)
		{	$in=strtolower($mv);
			$in.="_access";
			$ram=$ram_all[$in];
			$r=intval($ram[0]);
			$w=intval($ram[1]);
			$m=intval($ram[2]);
			if($r || $w || $m)
			{	$masters_valid = true;
				$masters.= "\n\t\t<li><a class=\"trigger right-caret\">".$menu_items_label[$mi]."</a>";
				$masters.= "\n\t\t\t<ul class=\"dropdown-menu sub-menu\">";
				foreach($menu_sub_items as $ind => $msi)
				{	$opt_access=intval($ram[$ind]);
					if($opt_access && isset($menu_sub_items_label[$ind]))
					{	$masters.= "\n\t\t\t\t<li><a href=\"/".APP_NAME."/dashboard/?act=".$msi."&master=".$mv."\">".$menu_sub_items_label[$ind];
						if($ind==0 && $m)
							$masters.=" & Update";
						else
							$masters.=" Records";
						$masters.="</a></li>";
					}
				}
				$masters.= "\n\t\t\t</ul></li>";
			}
		}
	}catch(\Exception $e)
	{	$masters.= "\n\t\t<li><a class=\"trigger\">"."Some Error Occurred"."</a>";
		$masters.= "\n\t\t\t</li>";
	}
$masters.=<<<EOM
			</ul>
	</li>
</ul>
EOM;
	$cur_dir=basename(dirname($_SERVER['PHP_SELF']));
	$nav_active_url['account']="/".APP_NAME."/dashboard/account/";
	$nav_active_class['account']="";
	if(strcmp($cur_dir,"account")==0)
		$nav_active_class['account']="active";
$htdoc = $masters_valid ? $masters : "";
$json_rights = json_encode($ram_all);
$htdoc.=<<<EOM
<ul class="nav navbar-nav navbar-right">
	<li class="{$nav_active_class['account']}">
		<a href="{$nav_active_url['account']}">Account</a>
	</li>
	<li>
		<a href="{$dir}core/logout.php">Logout</a>
	</li>
</ul>
<script>
var json_rights = {$json_rights};
</script>
EOM;
echo $htdoc;
}
else if(isset($dir))
{	$htdoc=<<<EOM
<ul class="nav navbar-nav">
		<li class="active">
          <a href="{$dir}">Log In</a>
        </li>
</ul>
EOM;
	echo $htdoc;
}
else
{	exit('Unauthorized access to system detected!!');
}
?>
