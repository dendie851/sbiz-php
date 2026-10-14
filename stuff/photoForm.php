	<?php
		/* view of photo of stuff, all data provided by addRead.php / editRead.php */
	?>

	<fieldset style="margin:30px 0px 30px 0px">
		<table width="100%">
			<tr>
				<td valign="top" width="30%">UPLOAD FOTO KE 1</td>
				<td>
					<input name="photo[]" type="file" multiple="multiple" accept="image/jpeg,image/png" />
					<small>Format JPG, JPEG atau PNG. Maksimal 500 KB per foto. Maksimal <?php echo $photoMax ?> foto.</small>
					<div style="color:red"><?php echo $photoMsgError ?></div>
				</td>
			</tr>

			<tr>
				<td valign="top" width="30%">UPLOAD FOTO KE 2</td>
				<td>
					<input name="photo[]" type="file" multiple="multiple" accept="image/jpeg,image/png" />
					<small>Format JPG, JPEG atau PNG. Maksimal 500 KB per foto. Maksimal <?php echo $photoMax ?> foto.</small>
					<div style="color:red"><?php echo $photoMsgError ?></div>
				</td>
			</tr>

			<tr>
				<td valign="top" width="30%">UPLOAD FOTO KE 3</td>
				<td>
					<input name="photo[]" type="file" multiple="multiple" accept="image/jpeg,image/png" />
					<small>Format JPG, JPEG atau PNG. Maksimal 500 KB per foto. Maksimal <?php echo $photoMax ?> foto.</small>
					<div style="color:red"><?php echo $photoMsgError ?></div>
				</td>
			</tr>

			<tr>
				<td valign="top" width="30%">UPLOAD FOTO KE 4</td>
				<td>
					<input name="photo[]" type="file" multiple="multiple" accept="image/jpeg,image/png" />
					<small>Format JPG, JPEG atau PNG. Maksimal 500 KB per foto. Maksimal <?php echo $photoMax ?> foto.</small>
					<div style="color:red"><?php echo $photoMsgError ?></div>
				</td>
			</tr>

			<tr>
				<td valign="top" width="30%">UPLOAD FOTO KE 5</td>
				<td>
					<input name="photo[]" type="file" multiple="multiple" accept="image/jpeg,image/png" />
					<small>Format JPG, JPEG atau PNG. Maksimal 1 MB per foto. Maksimal <?php echo $photoMax ?> foto.</small>
					<div style="color:red"><?php echo $photoMsgError ?></div>
				</td>
			</tr>
		</table>

		<?php if (!isset($addCopyStatus)): ?>
			<br />	
			<?php if($dataPhotoAmount < 1) : ?>
				<div class="warning">
					<h3>Foto Belum Tersedia</h3>
				</div>
			<?php else: ?>
				<div id="tbl">
					<table width="100%" border="1">
						<thead>
							<tr>
								<th align="center" width="5%">NO</th>
								<th align="center" width="40%">FOTO</th>
								<th align="center">FOTO UTAMA</th>
								<th align="center">AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1 ?>
							<?php while($val = mysqli_fetch_array($dataPhoto)): ?>
								<tr>
									<td align="center" valign="middle"><?php echo $i ?></td>
									<td align="center" valign="middle">
										<a href="../<?php echo $val['photo'] ?>" target="_blank">
											<img src="../<?php echo $val['photo_thumail'] ?>" width="100" />
										</a>
										<br />
										<small><i>Klik foto untuk melihat ukuran penuh</i></small>
									</td>
									<td align="center" valign="middle">
										<?php if($val['is_primary'] == '1'): ?>
											<b style="color: green">FOTO UTAMA</b>
										<?php else: ?>
											<input type="button" value="JADIKAN FOTO UTAMA" onclick="window.location='photoSetPrimary.php?id=<?php echo $val['id'] ?>&stuffId=<?php echo $val['stuff_id'] ?>'" />
										<?php endif; ?>
									</td>								
									<td align="center" valign="middle">
										<input type="button" value="HAPUS FOTO" onclick="confirm('Anda yakin akan menghapus foto ?') ? window.location='photoDelete.php?id=<?php echo $val['id'] ?>&stuffId=<?php echo $val['stuff_id'] ?>' : false" />
									</td>
								</tr>
							<?php $i++; ?>
							<?php endwhile; ?>
						<tbody>
					</table>
				</div>
			<?php endif; ?>
		<?php endif; ?>	
	</fieldset>
	<?php unset($_SESSION['msgErrorPhoto']); ?>
