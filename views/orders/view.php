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
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_customername">
												<b>Customer :</b>
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['name'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_contactperson">
												<b>Date :</b>
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo date('d, M Y', strtotime($order['order_date'])) ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> <b>Customer PO No. :</b> </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group" style="text-align: justify;">
											<?php echo $order['po_no'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_pincode"> <b>Contact Person :</b> </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $order['sales_person'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> <b>Bill To :</b> </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $order['bill_to'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												<b>Ship To :</b>
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $order['ship_to'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												<b>Comments :</b>
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $order['remarks'] ?>
										</div>
									</div>
									<div class="table-responsive card">
										<div class="card-body p-3">
											<table class="table text-center">
												<thead>
													<tr>
														<th class="min100">Item</th>
														<th class="min100">Description</th>
														<th class="minmax150">Qty</th>
														<th class="min100">Unit Price</th>
														<th class="min100">Total</th>
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
															<?php echo $item['unit_price']?>
														</td>
														<td>₹
															<?php echo ($item['unit_price'] * $item['qty']) ?>
														</td>
													</tr>
													<?php 
													$orderAmount += ($item['unit_price'] * $item['qty']);
													
													endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>

									<?php if (isset($invoices)) : ?>
									<div class="table-responsive card">
										<div class="card-header">
											<b>Invoice Details</b>
										</div>
										<div class="card-body p-3">
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
											<hr class="mt-0">
											<div class="text-right">
												<b>Pending Balance : </b>₹
												<span id="pendingbalance">
													<?php echo ($orderAmount - $invliceTotal)?>
												</span>
											</div>
										</div>
									</div>
									<?php endif;?>

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
	</div>
	<?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>