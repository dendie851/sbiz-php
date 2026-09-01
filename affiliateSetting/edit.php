<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>AFFILIATE SETTING</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="15%" valign="top">NAMA</td>
					<td>
						<input size="50" name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">SETTING</td>
					<td valign="top">
						<input size="50" name="value"  type="text" value="<?php echo isset($_POST['value']) ? $_POST['value'] : $data['value'] ?>" />
						<div style="color:red"><?php echo isset($msgError['value']) ? $msgError['value'] : '' ?></div>
					</td>
				</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php'" />
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
