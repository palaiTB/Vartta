<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert"><?php print $aMsg[1];?></div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" id="frmArrCtrl" method="post" action="<?php print $_SERVER['PHP_SELF'].'?ID=27';?>" >
				<?php foreach($aSortedCtrlList as $aRow) { ?>
				<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
					<div class="col-sm-10 osf-box-tabular-cell-thin osf-box-left">
						<?php print stripslashes($aRow['ctrname']); ?>
						<input type="hidden" name="names[]" value="<?php print stripslashes($aRow['ctrid']); ?>">
					</div>
					<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
						<button onClick="moveElementUp(this.parentNode.parentNode);"><i class="fa fa-arrow-up"></i></button>
					</div>
					<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
						<button onClick="moveElementDown(this.parentNode.parentNode);"><i class="fa fa-arrow-down"></i></button>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-lg-12">
						<input type="hidden" name="hidArrStatus" id="hidArrStatus" value="1" />
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:frmSubmit();"><i class="fa fa-check-square-o"></i> Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">
function frmSubmit()
{ 	
 	$("#frmArrCtrl").submit();
}
function moveElementDown(element){
	
    var elements = element.parentNode.getElementsByTagName(element.nodeName);
    for(i=0;i<elements.length;i++){
        if(elements[i]==element){
            //swap
            var x = (i+1) % (elements.length);
            element.parentNode.insertBefore(element.cloneNode(true), 
                (x>0?elements[x].nextSibling:elements[x]));
            element.parentNode.removeChild(element);
        }
    }
}
function moveElementUp(element){
    var elements = element.parentNode.getElementsByTagName(element.nodeName);
    for(i=0;i<elements.length;i++){
        if(elements[i]==element){
            //swap
            element.parentNode.insertBefore(element.cloneNode(true), 
                    (i-1>=0?elements[i-1]:elements[elements.length-1].nextSibling));
            element.parentNode.removeChild(element);
        }
    }
}
</script>

