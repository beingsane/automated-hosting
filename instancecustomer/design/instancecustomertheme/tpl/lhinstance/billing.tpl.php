<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Billing');?></h1>

<table class="large-6">
	<tr>
		<td>Request left</td>
		<td><?php echo $instance->request?></td>
	</tr>
	<tr>
		<td>Expires</td>
		<td><?php echo date('Y-m-d H:i:s',$instance->expires)?></td>
	</tr>
	<tr>
		<td>E-mail</td>
		<td><?php echo $instance->email?></td>
	</tr>
</table>
