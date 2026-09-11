<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>AFFILIATE PENUKARAN POIN</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" id="frmFilter" >	
				   <input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy ?>">				
					<table width="100%">
						<tr>
							<td width="15%" valign="top">KATA KUNCI</td>
							<td width="35%" valign="top">
								<input name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" /><br />
								<small>NAMA AFFILIATE / NO PENUKARAN POIN</small>
							</td>
							<td width="15%" valign="top">STATUS</td>
							<td idth="35%" valign="top">
								<select name="statusClaim">
										<option value="0">PENGAJUAN</option>
										<option value="1">DI SETUJUI</option>	
										<option value="2">PROSES PENYERAHHAN</option>
										<option value="3">SELESAI</option>
										<option value="4">DI TOLAK</option>
								</select>
							</td>	
						</tr>
						<tr>
							<td width="15%">DARI TANGGAL</td>
							<td width="35%">
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly  style="width:180px"  />
							</td>
							<td width="15%">SAMPAI TANGGAL</td>							
							<td width="35%">
								<input type="text" name="dateTo" id="dateTo" value="" readonly  style="width:180px"  />
							</td>							
						</tr>	
						</tr>	
							<td valign="bottom" valign="top" colspan="4">
								<input type="submit" value="FILTER" style="width: 100%" />
							</td>					
						</tr>
							
					</table>
				</form>	
		</fieldset>
		<br />
		
	<?php if(isset($_GET['msgType'])) : ?>
	 	<div class="error">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>	
	<?php elseif(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif; ?>
		
	
	<?php if(mysqli_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="addSave.php" method="post" id="frm" onsubmit="return printLabel()" />	
			<table width="100%">
				<tr>
					<td width="30%">			
						<select name="actionType" id="actionType" style="width:200px;">
							<option value="0">-- PILIH AKSI --</option>
								<option value="0">PENGAJUAN</option>
								<option value="1">DI SETUJUI</option>	
								<option value="2">PROSES PENYERAHHAN</option>
								<option value="3">SELESAI</option>
								<option value="4">DI TOLAK</option>
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>
				</tr>
			</table>
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th align="center" width="5%"><input class="bigCheckBox" style="cursor:pointer" type="checkbox" onclick="toggleCheckBox(this)" /></th>				
							<th align="center" width="5%">NO</th>
							<th align="center" width="7%" style="font-size: 12px">TGL PENGAJUAN</th>
							<th align="center" width="12%">NO PENUKARAN POIN</th>						
							<th align="center" width="14%">AFFILATE</th>
							<th align="center" width="10%">PENUKARAN</th>
							<th align="center" width="12%">REWARD</th>
							<th align="center" width="15%">KATERANGAN</th>
							<th align="center" width="%" style="font-size: 12px">STATUS</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysqli_fetch_array($data)): ?>
							<tr style="cursor:pointer">
								<td align="center">
									<input class="bigCheckBox" style="cursor:pointer" name="pointClaimId[]" type="checkbox" value="<?php echo $val['id'] ?>" />
								</td>						
								<td align="center"><?php echo $i ?></td>
								<td align="center"><?php echo $val['date_request_frm'] ?></td>
								<td align="center"><?php echo $val['no_point_claim'] ?>	</td>	
								<td align="center"><?php echo $val['affiliate_name'] ?></td>								
								<td align="center"><?php echo $val['points_spent'] ?> Point</td>
								<td align="center">
										<?php echo $val['reward_name'] ?><br />
										<small>Harga : <?php echo $val['points_price_reward'] ?> Point</small>
								</td>
								<td align="center">
									<textarea name="notes" style="width:100%; height:50px; text-valign:top">
										<?php echo $val['notes'] ?>
									</textarea>	
								</td>
								<td align="left">
									<div style="font-size:10px">
									Tgl Pengajuan: <?php echo $val['date_request_frm'] ?><br/>
									Tgl Disetujui: <?php echo $val['date_approve_frm'] ?><br/>
									Tgl Proses Penyerahaan : <?php echo $val['date_process_frm'] ?><br/>
									Tgl Selesai : <?php echo $val['date_complete_frm'] ?><br/>
									Tgl Ditolak :<?php echo $val['date_reject'] ?>
									</div>
								</td>		
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
				<p style="text-align:center; padding:10px">
					<?php
						echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'tipeOrder='.$tipeOrder,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment));
						echo '<br /><br />';
						echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
					?>
				</p>
			</div>
		</form>	
		
		<script>
			function printLabel() { 
				var e = document.getElementById ("actionType");
				var p = e.options [e.selectedIndex] .value;
					
				if(p == '0') {
					alert('Mohon untuk memilih aksi terlebih dahulu');
					return false;
				}
				
				if(p == '1') {
					if(confirm('Anda yakin akan melakukan pengiriman ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}

				
				if(p == '2') {
					if(confirm('Anda yakin print label alamat ?')) {
						document.getElementById('frm').action = 'printLabel.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}
				
				if(p == '3') {
					if(confirm('Anda yakin akan membatalkan pengemasan ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}


				if(p == '4') {
					if(confirm('Anda yakin akan export data ke format expidisi ninja ?')) {
						document.getElementById('frm').action = 'excelExpeditionNinja.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}

				if(p == '5') {
					if(confirm('Anda yakin akan export data ke format expedisi mengantar ?')) {
						document.getElementById('frm').action = 'excelExpeditionMengantar.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}												

				if(p == '6') {
					if(confirm('Anda yakin akan export data ke format expedisi SAP Express ?')) {
						document.getElementById('frm').action = 'excelExpeditionSAPExpress.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}

				if(p == '7') {
					if(confirm('Anda yakin akan export data ke format expedisi SICEPAT ?')) {
						document.getElementById('frm').action = 'excelExpeditionSicepat.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}		

				if(p == '8') {
					if(confirm('Anda yakin akan export data ke format expedisi JDL ?')) {
						document.getElementById('frm').action = 'excelExpeditionJdl.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}											
			}

			function orderBy(p){
				//window.location = 'index.php?orderBy='+p;
				document.getElementById('orderBy').value = p;
				document.getElementById('frmFilter').submit();
			}
		</script>

		<script type="text/javascript">
		$(document).ready(function() {
			$(function() {
					$( "#dateFrom" ).datepicker({
						dateFormat : 'dd/mm/yy',
						changeMonth : true,
						changeYear : true,
						yearRange: '-100y:c+nn',
						maxDate: '0d',
					}); 
					<?php $tmp = strlen(trim($_REQUEST['dateFrom'])) == 0 ?  '' : explode('/',$_REQUEST['dateFrom']) ?>
					$("#dateFrom" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				});


			$(function() {
					$( "#dateTo" ).datepicker({
						dateFormat : 'dd/mm/yy',
						changeMonth : true,
						changeYear : true,
						yearRange: '-100y:c+nn',
						maxDate: '0d',
					});

					<?php $tmp = strlen(trim($_REQUEST['dateTo'])) == 0 ?  '' : explode('/',$_REQUEST['dateTo']) ?>
					$("#dateTo" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				});
		});
		</script>		

	<?php endif; ?>

	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
