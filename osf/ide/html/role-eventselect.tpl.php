<?php
if ($_POST['requestctrlid'])
{
	if(count($aEventDetails) > 0)
	{
		$sSelectEvent = '<label>Default Event</label>
	    <select name="selEvent" id="selEvent" class="form-control required">
	    <option value="">Select Event</option>';
	    foreach($aEventDetails as $aRow)
	    {
			$sSelectEvent .= '<option value="'.$aRow['eventid'].'">'.$aRow['eventname'].'</option> .';
	    }
	    $sSelectEvent .= '</select>';
		$sSelectEvent .= '<p class="help-block">(Choose the Event that will be instantiated by default after signing in)</p>';
	    print $sSelectEvent;
	}
	else 
	{
	   $sSelectEvent = '<label>Default Event</label>
	    <select name="selEvent" id="selEvent" class="form-control required">
			<option value="">Select Event</option>';
	   $sSelectEvent .= '</select>';
	   $sSelectEvent .= '<p class="help-block">(Choose the Event that will be instantiated by default after signing in)</p>';
	   print $sSelectEvent;
	}
}
else 
{
    $sSelectEvent = '<label>Default Event</label>
	    <select name="selEvent" id="selEvent" class="form-control required">
			<option value="">Select Event</option>';
	   $sSelectEvent .= '</select>';
	   $sSelectEvent .= '<p class="help-block">(Choose the Event that will be instantiated by default after signing in)</p>';
    print $sSelectEvent;
}
?>
