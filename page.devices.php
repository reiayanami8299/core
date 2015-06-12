<?php /* $Id$ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
?>
<div class="fpbx-container container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<?php
			// If this is a popOver, we need to set it so the selection of device type does not result
			// in the popover closing because config.php thinks it was the process function. Maybe
			// the better way to do this would be to log an error or put some proper mechanism in place
			// since this is a bit of a kludge
			//
			if (!empty($_REQUEST['fw_popover'])) {
			?>
				<script>
					$(document).ready(function(){
						$('[name="fw_popover_process"]').val('');
						$('<input>').attr({type: 'hidden', name: 'fw_popover'}).val('1').appendTo('.popover-form');
					});
				</script>
			<?php
			}

			$display = isset($_REQUEST['display'])?$_REQUEST['display']:null;
			$action = isset($_REQUEST['action'])?$_REQUEST['action']:null;
			$extdisplay = isset($_REQUEST['extdisplay'])?$_REQUEST['extdisplay']:null;

			global $currentcomponent;
			if(empty($_REQUEST['tech_hardware']) && empty($_REQUEST['extdisplay'])) {
				?>
				<div class="display no-border">
					<div class="nav-container">
						<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
						<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
						<div class="wrapper">
							<ul class="nav nav-tabs list" role="tablist">
								<li role="presentation" data-name="alldids" class="active">
									<a href="#alldids" aria-controls="alldids" role="tab" data-toggle="tab">
										<?php echo _("All Devices")?>
									</a>
								</li>
								<?php foreach(FreePBX::Core()->getAllDriversInfo() as $driver) {?>
									<li role="presentation" data-name="<?php echo $driver['hardware']?>" class="">
										<a href="#<?php echo $driver['hardware']?>" aria-controls="<?php echo $driver['hardware']?>" role="tab" data-toggle="tab">
											<?php echo sprintf(_("%s Devices"),$driver['shortName'])?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="tab-content display">
						<div role="tabpanel" id="alldids" class="tab-pane active">
							<div id="toolbar-all">
								<button id="remove-all" class="btn btn-danger btn-remove" data-type="devices" data-section="all" disabled>
									<i class="glyphicon glyphicon-remove"></i> <span><?php echo _('Delete')?></span>
								</button>
							</div>
							<table data-url="ajax.php?module=core&amp;command=getDeviceGrid&amp;type=all" data-cache="false" data-show-refresh="true" data-toolbar="#toolbar-all" data-maintain-selected="true" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" class="table table-striped ext-list" id="table-all">
								<thead>
									<tr>
										<th data-checkbox="true"></th>
										<th data-sortable="true" data-field="extension"><?php echo _('Extension')?></th>
										<th data-sortable="true" data-field="name"><?php echo _('Name')?></th>
										<th data-formatter="CWIconFormatter"><?php echo _('CW')?></th>
										<th data-formatter="DNDIconFormatter"><?php echo _('DND')?></th>
										<th data-formatter="FMFMIconFormatter"><?php echo _('FMFM')?></th>
										<th data-formatter="CFIconFormatter"><?php echo _('CF')?></th>
										<th data-formatter="CFBIconFormatter"><?php echo _('CFB')?></th>
										<th data-formatter="CFUIconFormatter"><?php echo _('CFU')?></th>
										<th data-sortable="true" data-field="tech"><?php echo _('Type')?></th>
										<th data-field="actions"><?php echo _('Actions')?></th>
									</tr>
								</thead>
							</table>
						</div>
						<?php foreach(FreePBX::Core()->getAllDriversInfo() as $driver) {?>
							<div id="toolbar-<?php echo $driver['rawName']?>">
								<button id="remove-<?php echo $driver['rawName']?>" class="btn btn-danger btn-remove" data-type="devices" data-section="<?php echo $driver['rawName']?>" disabled>
									<i class="glyphicon glyphicon-remove"></i> <span><?php echo _('Delete')?></span>
								</button>
							</div>
							<div role="tabpanel" id="<?php echo $driver['hardware']?>" class="tab-pane">
								<table data-url="ajax.php?module=core&amp;command=getDeviceGrid&amp;type=<?php echo $driver['rawName']?>" data-cache="false" data-show-refresh="true" data-toolbar="#toolbar-<?php echo $driver['rawName']?>" data-maintain-selected="true" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" id="table-<?php echo $driver['rawName']?>" class="table table-striped ext-list">
									<thead>
										<tr>
											<th data-checkbox="true"></th>
											<th data-sortable="true" data-field="extension"><?php echo _('Extension')?></th>
											<th data-sortable="true" data-field="name"><?php echo _('Name')?></th>
											<th data-formatter="CWIconFormatter"><?php echo _('CW')?></th>
											<th data-formatter="DNDIconFormatter"><?php echo _('DND')?></th>
											<th data-formatter="FMFMIconFormatter"><?php echo _('FMFM')?></th>
											<th data-formatter="CFIconFormatter"><?php echo _('CF')?></th>
											<th data-formatter="CFBIconFormatter"><?php echo _('CFB')?></th>
											<th data-formatter="CFUIconFormatter"><?php echo _('CFU')?></th>
											<th data-field="actions"><?php echo _('Actions')?></th>
										</tr>
									</thead>
								</table>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
			} else {
				echo $currentcomponent->generateconfigpage(__DIR__."/views/devices.php");
			} ?>
		</div>
		<div class="col-sm-3 hidden-xs bootnav">
			<div class="list-group">
				<a href="?display=devices<?php echo isset($popover)?$popover:''?>" class="list-group-item"><i class="fa fa-list"></i> <?php echo _('List Devices')?></a>
				<?php
					foreach(FreePBX::Core()->getAllDriversInfo() as $driver) {
						?><a href="?display=devices&amp;tech_hardware=<?php echo $driver['hardware']?><?php echo isset($popover)?$popover:''?>" class="list-group-item"><?php echo sprintf(_("Add New %s Device"), $driver['shortName'])?></a><?php
					}
				?>
			</div>
		</div>
	</div>
</div>
<script>
	function DNDIconFormatter(value, row) {
		return row.settings.dnd ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Do Not Disturb is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Do Not Disturb is disabled")?>"></i>';
	}
	function CWIconFormatter(value, row) {
		return row.settings.cw ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Call Waiting is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Call Waiting is disabled")?>"></i>';
	}
	function CFIconFormatter(value, row) {
		return row.settings.cf ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Call Forwarding is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Call Forwarding is disabled")?>"></i>';
	}
	function CFBIconFormatter(value, row) {
		return row.settings.cfb ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Call Forwarding Busy is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Call Forwarding Busy is disabled")?>"></i>';
	}
	function CFUIconFormatter(value, row) {
		return row.settings.cfu ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Call Forwarding Unconditional is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Call Forwarding Unconditional is disabled")?>"></i>';
	}
	function FMFMIconFormatter(value, row) {
		return row.settings.fmfm ? '<i class="fa fa-check-square-o" style="color:green" title="<?php echo _("Find Me/Follow Me is enabled")?>"></i>' : '<i class="fa fa-square-o" title="<?php echo _("Find Me/Follow Me is disabled")?>"></i>';
	}
</script>
