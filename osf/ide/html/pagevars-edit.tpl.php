<!-- Mid Body Start -->
<a href="https://www.batoi.com/opendelight/docs/model-and-view" title="info" target="_blank"><span class="ui-icon ui-icon-info" style="float: right; margin-right: 2px;margin-top:2px;"></span></a>
<a href="<?php print $APP->BASEURL;?>/delight-ide/index.php?ID=90" title="Back"><span class="ui-icon ui-icon-circle-arrow-n ui-icon-back" style="margin-top:2px;"></span></a></div>
<div id="markerdiv"></div>
<div id="errordiv" class="<?php print $aMsg[1]; ?>" style="padding: 8px;width:97%;margin-top:15px;"> 
<span class="<?php print $aMsg[2]; ?>" style="float: left; margin-right: .3em;"></span>
<span id="errormessage" ><?php print $aMsg[0]?></span>
</div>
<div class="formSpacing">
<form name="frmPagevarEdit" id="frmPagevarEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=92&RecID='.stripslashes($aEachPagevarDetails[0]['pagevarid']);?>" method="post">
<div class="divSpacing">
<label>Variable Key <span>(A-Z 0-9, and no white space, no special characters)</span></label>
<input type="text" name="txtPagevarKey" id="txtPagevarKey" value="<?php if($_POST['txtPagevarKey']){ print $_POST['txtPagevarKey']; }else{ print stripslashes($aEachPagevarDetails[0]['pagevarkey']); } ?>" class="textboxNormal required" style="width:250px;font-size:11px;"/>
</div>
<div class="divSpacing">
<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
<a href="javascript:void(0);" onclick="javascript:editPagevar();" title="Submit" style="float:left;margin:8px 0px 4px 0px;font-weight:bold;" class="ui-od-button-with-icon ui-state-default ui-corner-all"><span class="ui-icon ui-icon-arrowthick-1-e"></span>Submit</a>
</div>
</div>
</form>
</div>
<!-- Mid Body End -->
<!-- Main content ends -->
<script type="text/javascript">
function editPagevar()
{
 	$("#frmPagevarEdit").validate();
 	$("#frmPagevarEdit").submit();
}
</script>