<div class="container" role="footer">
	<hr/>
	<div class="row">
		<div class="col-lg-6 osf-content-left">
			<small>&copy; <?php print date('Y');?> <a href="https://www.batoi.com" target="_blank">Batoi Systems Pvt Ltd</a>. All Rights Reserved.</small>
		</div>
		<div class="col-lg-6 osf-content-right">
			<small><a href="https://www.batoi.com/opensource-framework" title="OSF Home" target="_blank">OSF Home</a> | <a href="http://www.gnu.org/licenses/gpl.html" title="Licensed under GPL" target="_blank">GPL</a> | <a href="https://www.batoi.com/company/legal/" target="_blank" title="Legal Terms">Batoi Legal Terms</a></small>
		</div>
	</div>
</div>
<!-- Footer Ends -->
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script>window.jQuery || document.write('<script src="./pub/js/jquery-2.1.4.min.js"><\/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../ide/js/jquery.validate.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../ide/codeeditor/lib/codemirror.js"></script>
<script src="../ide/codeeditor/addon/edit/matchbrackets.js"></script>
<script src="../ide/codeeditor/mode/htmlmixed/htmlmixed.js"></script>
<script src="../ide/codeeditor/mode/xml/xml.js"></script>
<script src="../ide/codeeditor/mode/javascript/javascript.js"></script>
<script src="../ide/codeeditor/mode/css/css.js"></script>
<script src="../ide/codeeditor/mode/clike/clike.js"></script>
<script src="../ide/codeeditor/mode/php/php.js"></script>
<script type="text/javascript">
var editor = CodeMirror.fromTextArea(textarea_1, {
    lineNumbers: true
});
function funcInstall()
{
	$("#frmInstall").validate();
 	$("#frmInstall").submit();
}
function funcCreateApp()
{
	$('frmCreateAppln').submit();
}
</script>

</body>
</html>
