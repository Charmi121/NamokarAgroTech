<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin Panel</title>
		<meta name="keywords" content="Admin Panel" />
		<meta name="description" content="Admin Panel" />
		
		<!-- Bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/media-queries.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!-- SmartMenus jQuery Bootstrap Addon CSS -->
		<link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
	</head>
	<body>
		<header>
			<?php require_once("header.php") ?>
		</header>
		<div class="container">
			<h3>Product Technical specifications</h3>
			<div class="col-md-12"><div class="blank-border"></div></div>
			<?php if(!empty($_SESSION['technicalstatus']) &&  $_SESSION['technicalstatus']=="invalid" ) { ?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4>Invalid!</h4>
					<?php echo $errorlist['technical'][$_SESSION['technicalstatus']]; ?>
				</div>
				<div class="clearfix"></div>
				<?php unset($_SESSION['technicalstatus']);
					} elseif(!empty($_SESSION['technicalstatus']) &&  $_SESSION['technicalstatus']!="invalid") {
				?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4>Success!</h4>
					<?php echo $errorlist['technical'][$_SESSION['technicalstatus']]; ?>
				</div>
				<div class="clearfix"></div>
			<?php unset($_SESSION['technicalstatus']); } ?>
			
			<div class="clearfix"></div>
			<div class="middlesection margin-top20">
				<?php
					if (!empty($_GET['product_id']))
					{
						$edit = !empty($_GET['edit']) ? $_GET['edit'] : 0;
						$product_id = (int)$_GET['product_id'];
						$id = (!empty($_GET['id'])) ? (int)$_GET['id'] : 0;
						$sqlquery = $fpdo->from("tblproducts")
										->where("tblproducts.id = :product_id", array(":product_id" => $product_id));
						$rsproducts = $sqlquery->fetchAll();
						if (count($rsproducts)>0) {
							foreach($rsproducts as $rowproduct){
								$product_name        =   trim($rowproduct['product_name']);
							}
						}
						if(!empty($id) && !empty($edit)){
							$sqlquery = $fpdo->from("tblproduct_tech_spec")
											->where("tblproduct_tech_spec.id = :id", array(":id" => $id));
							$rstechspec = $sqlquery->fetchAll();
							if (count($rstechspec)>0) {
								foreach($rstechspec as $rowtechspec){
									$title   			=   trim($rowtechspec['title']);
									$tech_description   =   html_entity_decode($rowtechspec['tech_description'],ENT_QUOTES,"utf-8");
									$sort_order     	=   (int)$rowtechspec['sort_order'];    
									$status         	=   $rowtechspec['status'];    
								}
							}
							} else {
								$sort_order		   	=   0;
								$title   			=	'';
								$tech_description   =	'';   
								$status		   		=   707;
						}
						} else {
							$edit                =   0;
							$id                  =   0;
							$product_name        =   '';
							$status              =   0;
					}
				?>
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td>
								<form name="addform" id="addform" method="post" action="product-technical-specifications-save.php"  enctype="multipart/form-data" target="_self" autocomplete="off">
									<input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
									<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id;?>" />
									<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
									<table class="table table-bordered table-striped table-condensed">
										<tbody>
											<tr>
												<td class="col-md-2"><div class="text-right">Product Name</div></td>
												<td class="col-md-10">
													<div class="col-md-12">
														<span><?php echo $product_name; ?></span>
													</div>
												</td>
											</tr>
											<tr>
												<td><div class="text-right">Title</div></td>
												<td>
													<div class="col-md-12">
														<input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control  required" title="Please enter tech title." />
													</div>
												</td>
											</tr>
											<tr>
												<td><div class="text-right">Technical Specifications</div></td>
												<td>
													<div class="col-md-12">
														<textarea type="text" name="tech_description" id="tech_description"  class="form-control inbox-editor inbox-wysihtml5 required" title="Please enter tech description." ><?php echo $tech_description; ?></textarea>
													</div>
												</td>
											</tr>
											<tr>
												<td><div class="text-right">Status</div></td>
												<td>
													<div class="col-md-3">
														<select name="status" id="status" class="form-control">
															<option value="707" <?php if ((int) $status == 707) { echo "selected"; } ?>>Enable</option>
															<option value="505" <?php if ((int) $status == 505) { echo "selected"; } ?>>Disable</option>
														</select>
													</div>
												</td>
											</tr>
											<tr>
												<td><div class="text-right">Sort Order</div></td>
												<td>
													<div class="col-md-3">
														<input type="text" name="sort_order" id="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
													</div>
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
													<div class="col-md-6">
														<button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-large btn-primary">Submit <i class=" fa fa-arrow-right"></i></button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</td>
						</tr>
						<tr>
							<td colspan="10">
								<table class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>Sr. No.</th>
											<th>Product Name</th>
											<th>Title</th>
											<th>Status</th>
											<th>Sort Order</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$imgrowcount = 0;
											$i = 1;
											
											$sqlquery = $fpdo->from("tblproduct_tech_spec")
															->where("tblproduct_tech_spec.product_id = :product_id AND status != :status", array(":product_id" => $product_id,":status" => 909));
											$rsprojectkeytech_descriptions = $sqlquery->fetchAll();
											if (count($rsprojectkeytech_descriptions)>0) {
												foreach($rsprojectkeytech_descriptions as $rowprojectkeytech_description){      
												?>
												<tr>
													
													<td><?php echo $i; ?></td>
													<td><?php echo $product_name; ?></td>
													<td><?php echo trim($rowprojectkeytech_description['title']); ?></td>									
													<td><span class="label <?php if ((int)$rowprojectkeytech_description['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowprojectkeytech_description['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
													<td><?php echo $rowprojectkeytech_description['sort_order']; ?></td>									
													<td>
														<a href="product-technical-specifications.php?product_id=<?php echo $product_id; ?>&id=<?php echo $rowprojectkeytech_description['id']; ?>&edit=1" class="btn btn-mini btn-warning btn-xs"><i class="fa fa-edit"></i> Modify</a>
														<a href="javascript://" data-id="<?php echo $rowprojectkeytech_description['id']; ?>" data-productid="<?php echo $product_id; ?>" data-toggle="modal" data-target="#modalDelete" class="btn btn-sm btn-danger adelete"><i class="fa fa-trash"></i> Delete</a>
													</td>
												</tr>
												<?php
													$i++;
												}
											}
										?>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myDeleteLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myDeleteLabel">Delete Tech Description ?</h4>
					</div>
					<div class="modal-body">
						<p>You have selected to delete this tech description.</p>
						<p>
							If this was the action that you wanted to do,
							please confirm your choice, or cancel and return
							to the page.
						</p>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<form name="frmdelete" id="frmdelete" method="post" action="product-technical-specifications-save.php">
							<input type="hidden" name="delete" id="delete" value="1" />
							<input type="hidden" name="id" id="id" value="" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="submit" id="btndelete" class="btn btn-danger">Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--end middle part-->
		<div class="col-md-12"><div class="blank-border"></div></div>
		<footer>
			<?php require_once("footer.php") ?>
		</footer>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>  -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<!-- SmartMenus jQuery plugin -->
		<script type="text/javascript" src="js/jquery.smartmenus.js"></script>
		
		<!-- SmartMenus jQuery Bootstrap Addon -->
		<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
		<link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
		<script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
		<script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>
		
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>
		
		<script type="text/javascript" src="js/admin.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				Admin.Utils.initSummerNote();
				Admin.Utils.ProductTechSpec.initProductTechSpec();
				Admin.Utils.ProductTechSpec.deleteProductTechSpec();
			});
		</script>
	</body>
</html>