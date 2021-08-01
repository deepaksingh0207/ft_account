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
				<div class="container-fluid pb-5">
					<div class="row my-3">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header">
									<h3 class="card-title" style="line-height: 2.2">
										Order Details
									</h3>
									<div class="text-right">
										<!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
										</a> -->
										<a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm"> Back
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12 col-md-6 col-lg-4 pl-4">
											<div class="row">
												<div class="col-6">
													<label for="id_contactperson">
														<b>Date :</b>
													</label>
												</div>
												<div class="col-6 form-group">
													<?php echo date('d, M Y', strtotime($order['order_date'])) ?>
												</div>
											</div>
											<div class="row">
												<div class="col-6">
													<label for="id_customername">
														<b>Customer :</b>
													</label>
												</div>
												<div class="col-6 form-group">
													<?php echo $customer['name'] ?>
												</div>
											</div>
											<div class="row">
												<div class="col-6">
													<label for="id_address"> <b>Customer PO No. :</b> </label>
												</div>
												<div class="col-6 form-group" style="text-align: justify;">
													<?php echo $order['po_no'] ?>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-4">
											<div class="row">
												<div class="col-6">
													<label for="id_pincode"> <b>Contact Person :</b> </label>
												</div>
												<div class="col-6 form-group">
													<?php echo $order['sales_person'] ?>
												</div>
											</div>
											<div class="row">
												<div class="col-6"><b>Comments :</b></div>
												<div class="col-6 form-group">
													<?php echo $order['remarks'] ?>
												</div>
											</div>
											<div class="row">
												<div class="col-6"><b>Order Type :</b></div>
												<div class="col-6 form-group">
													<?php echo $ORDER_TYPE[$order['order_type']] ?>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-4">
											<div class="row">
												<div class="col-6">
													<label for="id_amc_from">
														<b>AMC From :</b>
													</label>
												</div>
												<div class="col-6 form-group">asdasd</div>
											</div>
											<div class="row">
												<div class="col-6">
													<label for="id_amc_till">
														<b>AMC Till :</b>
													</label>
												</div>
												<div class="col-6 form-group">sdfsdfsd</div>
											</div>
											<div class="row">
												<div class="col-6">
													<label for="id_po_upload">
														<b>Uploaded PO :</b>
													</label>
												</div>
												<div class="col-6 form-group">sdsfd</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-12 pl-4">
											<div class="row">
												<div class="col-2">
													<label for="id_address"> <b>Bill To :</b> </label>
												</div>
												<div class="col-6 form-group">
													<?php echo $order['bill_to'] ?>
												</div>
											</div>
											<div class="row">
												<div class="col-2">
													<label for="id_gst">
														<b>Ship To :</b>
													</label>
												</div>
												<div class="col-6 form-group">
													<?php echo $order['ship_to'] ?>
												</div>
											</div>
										</div>

										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="card">
												<div class="card-header">
													<div class="row ordertoggle pointer">
														<div class="col-10">
															<b>Order Items</b>
														</div>
														<div class="col-2 text-right">
															<i class="fas fa-chevron-right mt-1"
																id="id_order"></i>
														</div>
													</div>
												</div>
												<div class="table-responsive card-body order hide">
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
															<?php 
															$orderAmount += $item['total'];
															
															endforeach; ?>
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

										<?php if ($order['order_type'] == 2) : // project sale ?>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="card">
												<div class="card-header">
													<div class="row paytermtoggle pointer">
														<div class="col-10">
															<b>Payment Terms</b>
														</div>
														<div class="col-2 text-right">
															<i  id="id_payterm" class="fas fa-chevron-right mt-1"></i>
														</div>
													</div>
												</div>
												<div class="table-responsive card-body payterm hide">
													<table class="table text-center">
														<thead>
															<tr>
																<th class="min150">Item</th>
																<th class="min150">Payment Term</th>
																<th class="minmax100">Qty</th>
																<th class="min150">Unit of Measure</th>
																<th class="min100">Unit Price</th>
																<th class="min150">Total</th>
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
																	<?php echo $payterm['qty']?>
																</td>
																<td>
																	<?php echo $UOM[$payterm['uom_id']] ?>
																</td>
																<td>
																	<?php echo $payterm['unit_price']?>
																</td>
																<td>₹
																	<?php echo $payterm['total'] ?>
																</td>
															</tr>
															<?php
															
															endforeach; ?>
															<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php endif; ?>

										<?php if (isset($invoices)) : ?>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="card">
												<div class="card-header">
													<div class="row invdtlstoggle pointer">
														<div class="col-10">
															<b>Invoice Details</b>
														</div>
														<div class="col-2 text-right">
															<i id="id_invdtls" class="fas fa-chevron-right mt-1"></i>
														</div>
													</div>
												</div>
												<div class="card-body table-responsive invdetail hide">
													<table class="table text-center mb-0">
														<thead>
															<tr>
																<th class="min100">Invoice No. </th>
																<th class="min100">Pay Term</th>
																<th class="min100">Pay Percent </th>
																<th class="min100">Sub Total</th>
																<th class="min100">IGST</th>
																<th class="min100">CGST</th>
																<th class="min100">SGST</th>
																<th class="min100">Total</th>
																<th class="min100">Date</th>
															</tr>
														</thead>
														<tbody id="invoicelist">

															<?php foreach($invoices as $invoice) : ?>
															<tr>
																<td>
																	<?php echo $invoice['id']?>
																</td>
																<td>
																	<?php echo $invoice['payment_term']?>
																</td>
																<td>
																	<?php echo $invoice['pay_percent']?>
																</td>
																<td>
																	<?php echo $invoice['sub_total']?>
																</td>
																<td>
																	<?php echo $invoice['igst']?>
																</td>
																<td>
																	<?php echo $invoice['sgst']?>
																</td>
																<td>
																	<?php echo $invoice['cgst']?>
																</td>
																<td>
																	<?php echo $invoice['invoice_total']?>
																</td>
																<td>
																	<?php echo date('d, M Y', strtotime($invoice['invoice_date']))?>
																</td>
															</tr>
															<?php $invliceTotal += $invoice['sub_total']; endforeach; ?>
														</tbody>
													</table>
												</div>
												<div class="card-footer text-right invdetail hide">
													<b>Pending Balance : </b>₹
													<span id="pendingbalance">
														<?php echo ($orderAmount - $invliceTotal)?>
													</span>
												</div>
											</div>
										</div>
										<?php endif;?>
									</div>
								</div>

								<div class="card-footer text-right">
									<!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
                                        </a> -->
									<a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm"> Back
									</a>
								</div>

							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<script>
			$(document).ready(function () {
				$(".hide").hide();
			});
			$(document).on("click", ".ordertoggle", function () {
				$(".order").toggle();
				if ($("#id_order").attr('class') == "fas fa-chevron-down mt-1") {
					$("#id_order").attr('class', 'fas fa-chevron-right mt-1');
				} else {
					$("#id_order").attr('class', 'fas fa-chevron-down mt-1');
				}
			});
			$(document).on("click", ".paytermtoggle", function () {
				$(".payterm").toggle();
				if ($("#id_payterm").attr('class') == "fas fa-chevron-down mt-1") {
					$("#id_payterm").attr('class', 'fas fa-chevron-right mt-1');
				} else {
					$("#id_payterm").attr('class', 'fas fa-chevron-down mt-1');
				}
			});
			$(document).on("click", ".invdtlstoggle", function () {
				$(".invdetail").toggle();
				if ($("#id_invdtls").attr('class') == "fas fa-chevron-down mt-1") {
					$("#id_invdtls").attr('class', 'fas fa-chevron-right mt-1');
				} else {
					$("#id_invdtls").attr('class', 'fas fa-chevron-down mt-1');
				}
			});
		</script>
		<?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>