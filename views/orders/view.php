<?php 
$orderAmount = 0.00;
$invliceTotal = 0.00;
$pendingAmount = 0.00;
?>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
		<div class="content-wrapper">
			<section class="content">
				<div class="container-fluid mt-2 pb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title" style="line-height: 2.2">
								Order Details
							</h3>
							<div class="text-right">
								<a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
									Back
								</a>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-lg-6">
									<div class="row">
										<div class="col-6">
											<label for="id_customername">
												<b>Customer :</b>
											</label>
										</div>
										<div class="col-6 form-group">
											<?php echo $customer['name'] ?>
										</div>
										<div class="col-6">
											<label for="id_contactperson">
												<b>Date :</b>
											</label>
										</div>
										<div class="col-6 form-group">
											<?php echo date('d, M Y', strtotime($order['order_date'])) ?>
										</div>
										<div class="col-6">
											<label for="id_address"> <b>Customer PO No. :</b> </label>
										</div>
										<div class="col-6 form-group" style="text-align: justify;">
											<?php echo $order['po_no'] ?>
										</div>
									</div>
									<div class="row">
										<div class="col-6">
											<label for="id_address"> <b>Order PO Attachment :</b> </label>
										</div>
										<div class="col-6 form-group pointer attach" id="attach"
											style="text-align: justify;"
											data-href="<?php echo 'order_po/'.$order['po_file']?>">
											<i class="fas fa-paperclip"></i>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-lg-6">
									<div class="row">
										<div class="col-6">
											<label for="id_pincode"> <b>Contact Person :</b> </label>
										</div>
										<div class="col-6 form-group">
											<?php echo $order['sales_person'] ?>
										</div>
										<div class="col-6"><b>Order Type :</b></div>
										<div class="col-6 form-group">
											<?php echo $ORDER_TYPE[$order['order_type']] ?>
										</div>
										<?php if ($order['po_from_date']) :  ?>
										<div class="col-6">
											<label for="id_amc_from">
												<b>From Date:</b>
											</label>
										</div>
										<div class="col-6 form-group">
											<?php echo date('d, M Y', strtotime($order['po_from_date'])) ?>
										</div>
										<div class="col-6">
											<label for="id_amc_till">
												<b>Till Date :</b>
											</label>
										</div>
										<div class="col-6 form-group">
											<?php echo date('d, M Y', strtotime($order['po_to_date'])) ?>
										</div>
										<?php endif;  ?>
									</div>
								</div>
								<?php if ($order['remarks']) :  ?>
								<div class="col-sm-12 col-lg-12">
									<div class="row">
										<div class="col-3"><b>Comments :</b></div>
										<div class="col-9 form-group">
											<?php echo $order['remarks'] ?>
										</div>
									</div>
								</div>
								<?php endif;  ?>
								<div class="col-sm-12 col-lg-12">
									<div class="row">
										<div class="col-3">
											<label for="id_address"> <b>Bill To :</b> </label>
										</div>
										<div class="col-9 form-group">
											<?php echo $customer['address'] ?>
										</div>
									</div>
									<div class="row">
										<div class="col-3">
											<label for="id_gst">
												<b>Ship To :</b>
											</label>
										</div>
										<div class="col-9 form-group">
											<?php echo $shipToAddress ?>
										</div>
									</div>
								</div>

								<div class="col	-12">
									<div class="card">
										<div class="card-header">
											<div class="row ordertoggle pointer">
												<div class="col-10">
													<b>Order Items</b>
												</div>
												<div class="col-2 text-right">
													<i class="fas fa-chevron-right mt-1" id="id_order"></i>
												</div>
											</div>
										</div>
										<div class="table-responsive card-body order" style="display: none;">
											<table class="table">
												<thead>
													<tr>
														<th class="min150">Item</th>
														<th class="min150">Description</th>
														<th class="minmax100">Qty</th>
														<th class="min150">Unit of Measure</th>
														<th class="min100">Unit Price</th>
														<th class="min150">Total</th>
													</tr>
												</thead>
												<tbody>
													<?php if (is_array($items) || is_object($items)) : ?>
													<?php foreach($items as $item) : ?>
													<tr>
														<td>
															<?php echo $item['item']?>
														</td>
														<td>
															<?php echo $item['description']?>
														</td>
														<td>
															<?php echo $item['qty']?>
														</td>
														<td>
															<?php echo $UOM[$item['uom_id']] ?>
														</td>
														<td>
															<?php echo $item['unit_price']?>
														</td>
														<td>₹
															<?php echo $item['total'] ?>
														</td>
													</tr>
													<?php $orderAmount += $item['total']; endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
										<div class="card-footer order hide">
											<div class="row justify-content-center">
												<div class="col-sm-12 col-lg-3 text-center">
													<b>Sub Total :</b><br>
													<?php echo $order['sub_total'] ?>
												</div>
												<?php if (floatval($order['igst']) == 0.0) :  ?>
												<div class="col-sm-12 col-lg-3 text-center">
													<b>SGST (
														<?php echo $order['tax_rate'] ?>% ) :
													</b><br>
													<?php echo $order['sgst'] ?>
												</div>
												<div class="col-sm-12 col-lg-3 text-center">
													<b>CGST (
														<?php echo $order['tax_rate'] ?>% ) :
													</b><br>
													<?php echo $order['cgst'] ?>
												</div>
												<?php else :  ?>
												<div class="col-sm-12 col-lg-3 text-center">
													<b>IGST (
														<?php echo $order['tax_rate'] ?>% ) :
													</b><br>
													<?php echo $order['igst'] ?>
												</div>
												<?php endif;  ?>
												<div class="col-sm-12 col-lg-3 text-center"
													style="color: mediumslateblue;">
													<b>Total :</b><br>
													<?php echo $order['ordertotal'] ?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<?php if ($order['order_type'] == 1 || $order['order_type'] == 2) : // project sale ?>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="card">
										<div class="card-header">
											<div class="row paytermtoggle pointer">
												<div class="col-10">
													<b>Payment Terms</b>
												</div>
												<div class="col-2 text-right">
													<i id="id_payterm" class="fas fa-chevron-right mt-1"></i>
												</div>
											</div>
										</div>
										<div class="table-responsive card-body payterm hide">
											<table class="table text-center">
												<thead>
													<tr>
														<th class="min150">Item</th>
														<th class="min150">Item Description</th>
														<th class="max150">Qty./Unit</th>
														<th class="min100">Unit Price</th>
														<th class="min150">Total Value</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php if (is_array($payterms) || is_object($payterms)) : ?>
													<?php foreach($payterms as $payterm) : ?>
													<tr>
														<td>
															<?php echo $payterm['item']?>
														</td>
														<td>
															<?php echo $payterm['description']?>
														</td>
														<td>
															<?php echo $payterm['qty']?> /
															<?php echo $UOM[$payterm['uom_id']] ?>
														</td>
														<td>
															<?php echo $payterm['unit_price']?>
														</td>
														<td>₹
															<?php echo $payterm['total'] ?>
														</td>
														<td id="pdf<?php echo $payterm['id'] ?>"></td>
													</tr>
													<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm"> Back
							</a>
						</div>
					</div>
				</div>
			</section>
		</div>
		<button type="button" id="modelpdf" style="display: none" data-toggle="modal" data-target="#modal-xl"></button>
		<div class="modal fade" id="modal-xl">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header" id="modal_header">
						Invoice
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body p-0" id="modal_body">
					</div>
				</div>
			</div>
		</div>
		<script>
			var oti = <? php echo $order['order_type'] ?> ;
			var id = <? php echo $order['id'] ?> ;
		</script>
		<?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>