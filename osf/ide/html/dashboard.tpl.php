<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new user role <strong><?php print $_GET['PC'];?></strong> has been successfully added.</div>
	<?php } elseif(isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The role <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } elseif (isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
	<div class="alert alert-success" role="alert">The role <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } elseif (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
	<div class="alert alert-success" role="alert">The display order of user roles has successfully been changed.</div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Develop and manage your application with Opendelight. For help, click on info icon on right of header texts bar at any time.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-3 osf-content-left">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">What You Edited Last -</h3>
				</div>
				<div class="panel-body">
					<?php
					foreach($aLatestEvents as $aLatestEvent)
					{
					?>
					<p><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=25&RecID=<?php print $aLatestEvent['eventid'];?>&CtrID=<?php print $aLatestEvent['ctrid'];?>" title="<?php print $aLatestEvent['eventname'];?>">Event: <code><?php print $aLatestEvent['eventname'];?></code> (CTR: <code><?php print $aLatestEvent['ctrname'];?></code>)</a></p>
					<?php
					}
					?>
					
					<?php
					foreach($aLatestClasses as $aLatestClass)
					{
						$aClassFileParts = explode('.cls.php',$aLatestClass[name]);
						$sClassFileName = $aClassFileParts[0];
					?>
					<p><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=32&Class=<?php print $sClassFileName;?>" title="<?php print $sClassFileName;?>">Model Class: <code><?php print $sClassFileName;?></code></a></p>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 osf-content-left">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Latest News from Batoi.com</h3>
				</div>
				<div class="panel-body">
					<?php
					foreach($oFeedItems as $oFeedItem)
					{
					?>
					<p><a href="<?php print $oFeedItem->link;?>" target="_blank"><strong><?php print $oFeedItem->title;?></strong></a><br /><?php print $oFeedItem->description;?></p>
					<?php
					}
					?>
				</div>
			</div><!-- END OF PANEL -->
		</div>
		<div class="col-lg-3 osf-content-left">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Documentation Links</h3>
				</div>
				<div class="panel-body">
					<ul>
					<li><a href="https://www.batoi.com/framework/get-started/" title="Get Started" target="_blank">Get Started</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/overview-of-batoi-osf-ide" title="Opendelight IDE" target="_blank">Opendelight IDE</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/overview-of-batoi-osf-architecture" title="Architecture of Framework" target="_blank">Architecture of Framework</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/glossary-of-the-terms-used-in-the-batoi-osf/" title="Glossary of Terms" target="_blank">Glossary of Terms</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/batoi-osf-objects-arrays-and-libraries" title="" target="_blank">Objects, Arrays and Libraries</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/batoi-osf-application-database-structure/" title="Database Structure" target="_blank">Database Structure</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/batoi-osf-application-file-structure" title="File Structure" target="_blank">File Structure</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/controller-in-the-batoi-osf/" title="Controller" target="_blank">Controller</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/event-in-the-batoi-osf" title="Event" target="_blank">Event</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/model-in-the-batoi-osf" title="" target="_blank">Model in the Batoi OSF</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/view-in-the-batoi-osf" title="" target="_blank">View in the Batoi OSF</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/users-and-roles-in-the-batoi-osf" title="Users and Roles" target="_blank">Users and Roles</a></li>
					<!--<li><a href="hhttps://www.batoi.com/opendelight/docs/settings.php" title="Application Settings" target="_blank">Application Settings</a></li>-->
					<li><a href="https://www.batoi.com/support/articles/article/batoi-coding-standards-and-conventions" title="Standards and Conventions" target="_blank">Standards &amp; Conventions</a></li>
					<li><a href="https://www.batoi.com/support/articles/article/installation-and-upgrades-of-batoi-osf" title="Installation and Upgrades" target="_blank">Installation and Upgrades</a></li>
					</ul>
					<p style="font-style:italic;font-size:11px;"><strong>NOTE:</strong> For help on using Opendelight IDE, click on the icon <span class="ui-icon ui-icon-info"></span> on the top right of any screen on IDE.</p>
				</div>
			</div>
	
	
		</div>
	</div>

</div>