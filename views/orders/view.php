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
										View Order
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
												Date :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['contact_person'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> Customer PO No. : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group" style="text-align: justify;">
											<?php echo $customer['address'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_pincode"> Contact Person : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['pincode'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_address"> Bill To : </label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $state['name'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												Ship To :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['pan'] ?>
										</div>
									</div>
									<div class="row mx-1">
										<div class="col-sm-12 col-lg-2">
											<label for="id_gst">
												Comments :
											</label>
										</div>
										<div class="col-sm-12 col-lg-3 form-group">
											<?php echo $customer['gstin'] ?>
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
													<tr>
														<td>itema</td>
														<td>descp</td>
														<td>2</td>
														<td>200</td>
														<td>₹500.00</td>
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
					<br>
					<br>
				</div>
				<?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
			</section>
		</div>
	</div>