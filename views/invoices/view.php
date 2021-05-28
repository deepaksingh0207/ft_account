<body class="hold-transition sidebar-collapse layout-top-nav">
	<div class="wrapper">
		<div class="content-wrapper">
			<?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
			<section class="content">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="card card-default mt-3">
								<div class="card-header">
									<h3 class="card-title" style="line-height: 2.2">
										View Invoice
									</h3>
									<div class="text-right">
										<!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
										</a> -->
										<a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm"> Back
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_customername">
												Customer :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['name'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_contactperson">
												Order Number:
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['contact_person'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> Date : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group" style="text-align: justify;">
											<?php echo $customer['address'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_pincode"> Customer PO No. : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['pincode'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> Salesperson: </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $state['name'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												Bill To :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['pan'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												Ship To :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['gstin'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_pphone"> Comments : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group numberonly">
											<?php echo $customer['pphone'] ?>
										</div>
									</div>
									<div class="table-responsive card">
										<div class="card-body p-3">
											<table class="table text-center">
												<thead>
													<tr>
														<th class="min100">Item </th>
														<th class="min100">Description</th>
														<th class="minmax150">Qty </th>
														<th class="min100">Unit Price</th>
														<th class="min100">Order Total</th>
													</tr>
												</thead>
												<tbody id="orderlist">
													<tr id="9">
														<td id="id_item9">ABAP Support</td>
														<td id="id_description9">support</td>
														<td id="id_quantity9">1</td>
														<td id="id_unitprice9">6000.00</td>
														<td>₹<span id="ordertotal9">6000.00</span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="table-responsive card">
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
													<tr>
														<td>12</td>
														<td>Advance</td>
														<td>30</td>
														<td>1800</td>
														<td>0</td>
														<td>162</td>
														<td>162</td>
														<td>2124.00</td>
														<td>27 May 2021</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="card-footer text-right">
									<!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
									</a> -->
									<a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm"> Back
									</a>
								</div>
							</div>
						</div>
					</div>
					<br><br>
				</div>
				<?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
			</section>
		</div>
	</div>