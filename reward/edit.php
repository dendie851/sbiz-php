<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>AFFILIATE REWARD</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="20%" valign="top">NAMA</td>
					<td>
						<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['title'] ?>" />						
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
			<tr>
				<td valign="top">POINT REQUIRED</td>
				<td>
					<input name="point_required" type="text" value="<?php echo isset($_POST['points_required']) ? $_POST['points_required'] : $data['points_required'] ?>" />
					<div style="color:red"><?php echo isset($msgError['point_required']) ? $msgError['point_required'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">STOK</td>
				<td>
					<input name="daily_stock" type="text" value="<?php echo isset($_POST['daily_stock']) ? $_POST['daily_stock'] : $data['daily_stock'] ?>"/>
					<div style="color:red"><?php echo isset($msgError['daily_stock']) ? $msgError['daily_stock'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">STATUS AKTIF</td>
				<td>
					<select name="is_active" style="width: 180px" >
						<option value="0" <?php echo (string)($_POST['is_active'] ?? $data['is_active'] ?? 0) === '0' ? 'selected' : ''; ?> >Tidak</option>
						<option value="1" <?php echo (string)($_POST['is_active'] ?? $data['is_active'] ?? 1) === '1' ? 'selected' : ''; ?> >Ya</option>
					</select>
				</td>
			</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
