<?php
    header('Cache-Control: max-age=900');
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('paging.php');
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
            <?php if(!empty($_SESSION['productstatus'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['product'][$_SESSION['productstatus']]; ?>
                </div>
                <div class="clearfix"></div>
            <?php unset($_SESSION['productstatus']); } ?>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left col-md-6"><h3>Products</h3></div>
                    <div class="text-right col-md-6 margin-top15"><a href="product.php" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Product</a></div>
                    <div class="clearfix"></div>
                    <div class="blank-border"></div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            <?php
               $category_id     =   (!empty($_REQUEST['category_id'])) ? (int)$_REQUEST['category_id']: 0;
               $product_name    =   (!empty($_REQUEST['product_name'])) ? $DB->cleanInput($_REQUEST['product_name']) : '';
               $sku             =   (!empty($_REQUEST['sku'])) ? $DB->cleanInput($_REQUEST['sku']) : '';
            ?>
            <div class="form-actions margin-top20">
                  <div class="row">
                          <div class="col-md-12">
                           <div class="panel panel-default">
                           <div class="panel-heading">Filter Search Result <a id="apanel" href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div>
                              <div class="panel-body">
                                  <form method="post" action="displayproduct.php" name="addform" id="addform">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="category_id">Category</label>
                                          <select name="category_id" id="category_id" style="width: 100%;" placeholder="Select Category Name">
                                              <option value="0">Select Category</option>
                                              <?php
                                                  $level = 0;
                                                  $sqlquery = $fpdo->from("tblcategories")
                                                                   ->select(null)
                                                                   ->select("tblcategories.id, tblcategories.category_name")
                                                                   ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => 0, ":status" => 707))
                                                                   ->order("tblcategories.category_name");
                                                  $rscategory = $sqlquery->fetchAll();
                                                  if (count($rscategory) > 0){
                                                      foreach($rscategory as $rowcategory){
                                                        $level = 1;
                                              ?>
                                              <optgroup label="<?php echo $rowcategory['category_name']; ?>">
                                                    <?php display_children($rowcategory['id'], $level); ?>
                                              </optgroup>
                                              <?php
                                                      }
                                                  }
                                              ?>
                                              
                                              <?php
                                                // $parent_cat_id is the parent id of the children we want to see
                                                // $level is increased when we go deeper into the tree, used to display a nice indented tree
                                                function display_children($parent_cat_id, $level) {
                                                    global $fpdo;
                                                    //global $category_id;
                                                    global $category_id;
                                                    $sqlquery = $fpdo->from("tblcategories")
                                                                     ->select(null)
                                                                     ->select("tblcategories.id, tblcategories.category_name")
                                                                     ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $parent_cat_id, ":status" => 707))
                                                                     ->order("tblcategories.category_name");
                                                    $rssubcategories = $sqlquery->fetchAll();
                                                    if (count($rssubcategories)>0) {
                                                        foreach($rssubcategories as $rowsubcategory){
                                              ?>
                                              <option value="<?php echo $rowsubcategory['id'];?>" <?php if((int)$rowsubcategory['id'] == (int)$category_id){ echo "selected=\"selected\""; } ;?>><?php  echo str_repeat('- ',$level).$rowsubcategory['category_name'];?> </option>
                                              <?php
                                                            display_children($rowsubcategory['id'], $level+1);
                                                        }
                                                    }
                                                }
                                              ?>
                                          </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="product_name">Product Name</label>
                                          <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="sku">SKU</label>
                                          <input type="text" name="sku" id="sku" value="<?php echo $sku; ?>" class="form-control" />
                                       </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                          <label for="submit">&nbsp;</label>
                                          <input type="submit" name="submit" value="Submit" class="btn btn-default btn-primary" />
                                        </div>
                                    </div>
                                  </form>
                              </div>
                           </div>
                      </div>
                  </div>
            </div>
            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    $rowsPerPage = RECORDS_PER_PAGE;
                    
                    $pageNum = (!empty($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
                    
                    $offset = ($pageNum - 1) * $rowsPerPage;
                    
                    
                    $sqlquery  =  "SELECT tblproducts.id, tblproducts.product_name, tblproducts.sku, tblproducts.net_price, tblproducts.status, tblproduct_images.mini_image FROM tblproducts";
                    
                    $sqlquery  =  $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";
                    if(!empty($category_id)){
                        $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id = ".$category_id.") AS tblproduct_categories ON tblproduct_categories.product_id = tblproducts.id";
                    }                    
                    $sqlquery  =  $sqlquery . " WHERE tblproducts.id != 0 ";
                    if(!empty($product_name)){
                        $sqlquery = $sqlquery . " AND tblproducts.product_name LIKE '".$product_name."%'";
                    }
                    if(!empty($sku)){
                        $sqlquery = $sqlquery . " AND tblproducts.sku LIKE '".$sku."%'";
                    }
                    $sqlquery  = $sqlquery . " LIMIT ".$offset.", ".$rowsPerPage."";
                    
                    $rsdata    = $fpdo->customResult($sqlquery)->fetchAll();
                    if (count($rsdata)>0) {
                ?>
                    <form method="post" action="updateproductsave.php" name="addform" id="addform">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">Sr. No.</th>
                                        <th class="col-md-2">Product Name</th>
                                        <th class="col-md-1">SKU</th>
                                        <th class="col-md-1">Thumb Image</th>
                                        <th class="col-md-1">Technical Specifications & Gallery</th>
                                        <th class="col-md-1">Status</th>
                                        <th class="col-md-1">Enable / Disable</th>
                                        <th class="col-md-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                        foreach($rsdata as $rowdata ){
                                            $intcnt = $intcnt+1;
                                            $level = 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $intcnt; ?></td>
                                            <td><?php echo $rowdata['product_name']; ?></td>
                                            <td><?php echo $rowdata['sku']; ?></td>
                                            <td><?php if(!empty($rowdata['mini_image'])){ ?><img src="<?php echo DISPLAY_PATH."/products/".$rowdata['mini_image']; ?>" max-width="150" max-height="100" /><?php } ?></td> 
                                            <td>
                                                <a href="product-technical-specifications.php?product_id=<?php echo $rowdata['id']; ?>" class="label label-info"><i class="fa fa-plus"></i> Add</a>
                                                <a href="product-gallery.php?product_id=<?php echo $rowdata['id']; ?>" class="label label-info"><i class="fa fa-image"></i> Gallery</a>
                                            </td>
                                            <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                                            <td>
                                                <input type="checkbox" name="chkproduct_<?php echo $rowdata['id']; ?>" id="chkproduct_<?php echo $rowdata['id']; ?>" <?php if ((int)$rowdata['status'] == 707) { echo "checked=\"checked\""; } ?>  />
                                                <input type="hidden" name="hdnproduct[]" id="hdnproduct_<?php echo $rowdata['id']; ?>" value="<?php echo $rowdata['id']; ?>"  />
                                            </td>
                                            <td><a href="product.php?id=<?php echo $rowdata['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Modify</a>  <!--&nbsp; <a href="deleteproduct.php?=id<?php echo $rowdata['id']; ?>&delete=1" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>--></td>
                                        </tr>
                                    <?php } ?>
                                    <!--<tr>
                                        <td colspan="7">&nbsp;</td>
                                        <td colspan="1"><input type="submit" name="btnupdate" value="Update" class="btn btn-default btn-primary" /></td>
                                    </tr>-->
                                </tbody>
                                <tfoot>
                                      <tr>
                                          <td colspan="12" class="text-center">
                                             <div class="pagination">
                                              <?php
                                                  $queryrows  =    "SELECT COUNT(id) AS numrows FROM tblproducts";
                                                  if(!empty($category_id)){
                                                      $queryrows = $queryrows . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id = ".$category_id.") AS tblproduct_categories ON tblproduct_categories.product_id = tblproducts.id";
                                                  }
                                                  $queryrows  =    $queryrows . " WHERE tblproducts.id != 0 ";
                                                  if(!empty($product_name)){
                                                      $queryrows = $queryrows . " AND tblproducts.product_name LIKE '".$product_name."%'";
                                                  }
                                                  if(!empty($sku)){
                                                      $queryrows = $queryrows . " AND tblproducts.sku LIKE '".$sku."%'";
                                                  }

                                                  $rscount    = $fpdo->customResult($queryrows)->fetchAll();
                                                  foreach($rscount as $rowcount){
                                                    $numrows  = $rowcount['numrows'];
                                                  }
                                                  $self       = $_SERVER['PHP_SELF'];

                                                  $querystring= "";
                                                  if(!empty($category_id)){
                                                      $querystring = $querystring . "&category_id=".$category_id."";
                                                  }
                                                  if(!empty($product_name)){
                                                      $querystring = $querystring . "&product_name=".$product_name."";
                                                  }
                                                  if(!empty($sku)){
                                                      $querystring = $querystring . "&sku=".$sku."";
                                                  }
                                                  
                                                  //print the paging result
                                                  doPages($rowsPerPage, $self, $querystring, $numrows);
                                              ?>
                                             </div>
                                          </td>
                                      </tr>
                                  </tfoot>
                            </table>
                        </div>
                    </form>
                <?php } else { ?>
                    <table class="table">
                        <tr>
                            <td class="text-center h4">No Record Found</td>
                        </tr>
                    </table>
                <?php } ?>
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
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="js/jquery.smartmenus.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>
        
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                Admin.Utils.Product.displayProduct();
            });
        </script>
    </body>
</html>
