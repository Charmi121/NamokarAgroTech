<?php
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
    <div class="container-fluid">
      <h3>Customer List</h3>
      <div class="col-md-12"><div class="blank-border"></div></div>
      <div class="clearfix"></div>
      <?php if(!empty($_SESSION['registerstatus'])) { ?>
          <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Success!</h4>
              <?php echo $errorlist['register'][$_SESSION['registerstatus']]; ?>
          </div>
          <div class="clearfix"></div>
      <?php unset($_SESSION['registerstatus']); } ?>
      <?php /*<div class="pull-right"><a href="register.php" class="btn btn-info"><i class="fa fa-plus-circle"></i> Register Customer</a></div>*/ ?>
      <?php
         $company_name            =   (!empty($_REQUEST['company_name']))? $DB->removeTags($_REQUEST['company_name']) : '';
         $full_name               =   (!empty($_REQUEST['full_name'])) ? $DB->removeTags($_REQUEST['full_name']) : '';    
         $email                   =   (!empty($_REQUEST['email']))? $DB->removeTags($_REQUEST['email']) : '';
         $city                    =   (!empty($_REQUEST['city']))? $DB->removeTags($_REQUEST['city']) : '';
         $mobile                  =   (!empty($_REQUEST['mobile']))? $DB->removeTags($_REQUEST['mobile']) : '';
         $date_picker_range       =   (!empty($_REQUEST['date_picker_range'])) ? $_REQUEST['date_picker_range'] : '';
         $date_range              =   (!empty($_REQUEST['date_picker_range'])) ? explode("-", $_REQUEST['date_picker_range']) : array();
         $from_date               =   (!empty($date_range[0])) ? date("Y-m-d", strtotime($date_range[0])) : '';
         $to_date                 =   (!empty($date_range[1])) ? date("Y-m-d", strtotime($date_range[1])) : '';
      ?>
      <div class="form-actions margin-top20">
      <div class="row">
              <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">Filter Search Result <a id="apanel" href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div>
                  <div class="panel-body">
                      <form method="post" action="displayregister.php" name="addform" id="addform">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="company_name">Company Name</label>
                              <input type="text" name="company_name" id="company_name" value="<?php echo $company_name;?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="full_name">Full Name</label>
                              <input type="text" name="full_name" id="full_name" value="<?php echo $full_name;?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input type="text" name="email" id="email" value="<?php echo $email;?>" class="form-control" />
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label for="city">City</label>
                              <input type="text" name="city" id="city" value="<?php echo $city;?>" class="form-control" />
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label for="mobile">Mobile</label>
                              <input type="text" name="mobile" id="mobile" value="<?php echo $mobile;?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                             <label for="date-range">Register Date Range</label>
                             <div id="date-range" class="input-group col-md-12">
                                 <input id="date_picker_range" name="date_picker_range" class="form-control" type="text" <?php if (!empty($from_date) && $DB->checkValidDate($from_date)) { ?> value="<?php echo $date_picker_range; ?>" <?php } ?> />
                                 <span class="input-group-btn">
                                 <button id="image_button" class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                             </div>
                           </div>
                        </div>
                        <div class="col-md-12 margin-top20">
                            <div class="form-group text-center">
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
              $rowsPerPage = 30;
              $pageNum = 1;

              if(!empty($_GET['page']) && (int)$_GET['page'] > 0){
                  $pageNum = (int)$_GET['page'];
              } else {
                  $pageNum =  1;
              }

              $offset = ($pageNum - 1) * $rowsPerPage;
              $sqlquery = "SELECT tblregister.*, tblregister_billing_addresses.billing_company_name FROM tblregister ";
              $sqlquery = $sqlquery . " INNER JOIN tblregister_billing_addresses ON tblregister_billing_addresses.user_id = tblregister.id ";
              $sqlquery = $sqlquery . " INNER JOIN tblcountries ON tblcountries.id = tblregister.country_id ";
              $sqlquery = $sqlquery . " WHERE tblregister.id != 0 ";
              /*if (!empty($country_id)){
                  $sqlquery = $sqlquery . " AND tblregister.countryid = ".$country_id."";
              } */
              if (!empty($company_name)){
                  $sqlquery = $sqlquery . " AND tblregister_billing_addresses.billing_company_name LIKE '%".$company_name."%'";
              }
              if (!empty($full_name)){
                  $sqlquery = $sqlquery . " AND CONCAT(tblregister.first_name,' ', tblregister.last_name) LIKE '%".$full_name."%'";
              }
              if (!empty($email)){
                  $sqlquery = $sqlquery . " AND tblregister.email LIKE '%".$email."%'";
              }
              if (!empty($city)){
                  $sqlquery = $sqlquery . " AND tblregister.city LIKE '".$city."'";
              }
              if (!empty($mobile)){
                  $sqlquery = $sqlquery . " AND tblregister.mobile LIKE '".$mobile."'";
              }
              if(!empty($from_date)){
                  $sqlquery = $sqlquery . " AND DATE(tblregister.created) >= '".$from_date."'";
              }
              if(!empty($to_date)){
                  $sqlquery = $sqlquery . " AND DATE(tblregister.created) <= '".$to_date."'";
              }
              $sqlquery = $sqlquery . " ORDER BY tblregister.id DESC LIMIT ".$offset.", ".$rowsPerPage."";

              $rsdata   = $fpdo->customResult($sqlquery)->fetchAll();
              if (count($rsdata) > 0){
          ?>
             <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="col-md-1">Sr. No.</th>
                    <th class="col-md-2">Company Name</th>
                    <th class="col-md-2">Customer Name</th>
                    <th class="col-md-1">E-Mail</th>
                    <th class="col-md-1">Mobile</th>
                    <th class="col-md-1">City</th>
                    <th class="col-md-2">Register Date</th>
                    <th class="col-md-2">Is Verified</th>
                    <th class="col-md-2">Orders</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-2">Action</th>
                  </tr>
                </thead>
                <tbody>
             <?php
                   $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                   foreach($rsdata as $rowdata){
                        $intcnt = $intcnt+1;
             ?>
                  <tr>
                    <td><?php echo $intcnt; ?></td>
                    <td><?php echo $rowdata['billing_company_name']; ?></td>
                    <td><?php echo $rowdata['first_name']." ".$rowdata['last_name']; ?></td>
                    <td><?php echo $rowdata['email']; ?></td>
                    <td><?php echo $rowdata['mobile']; ?></td>
                    <td><?php echo $rowdata['city']; ?></td>
                    <td><?php echo date("d-M-Y", strtotime($rowdata['created'])); ?></td>
                    <td><?php if((int)$rowdata['is_verified'] == 1) { ?> <i class="fa fa-check text-success"></i> <?php } else { echo "-"; } ?></td>
                    <td class="add"><a href="displayorder.php?user_id=<?php echo $rowdata['id'];?>"> View Orders</a></td>
                    <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                    <td><a href="register.php?id=<?php echo $rowdata['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> View</a>
                    <!--&nbsp; <a href="deleteregister.php?id=<?php //echo $rowdata['id']; ?>&delete=1" class="btn btn-sm btn-danger adelete"><i class="icon-trash"></i> Delete</a>--></td>
                  </tr>
             <?php } ?>
                </tbody>
                <tfoot>
                      <tr>
                          <td colspan="12" class="text-center">
                             <div class="pagination">
                              <?php
                                  $sqlquery = "SELECT COUNT(tblregister.id) AS numrows FROM tblregister ";
                                  $sqlquery = $sqlquery . " INNER JOIN tblregister_billing_addresses ON tblregister_billing_addresses.user_id = tblregister.id ";
                                  $sqlquery = $sqlquery . " INNER JOIN tblcountries ON tblcountries.id = tblregister.country_id ";
                                  $sqlquery = $sqlquery . " WHERE tblregister.id != 0 ";
                                  /*if (!empty($country_id)){
                                      $sqlquery = $sqlquery . " AND tblregister.countryid = ".$country_id."";
                                  } */
                                  if (!empty($company_name)){
                                      $sqlquery = $sqlquery . " AND tblregister_billing_addresses.billing_company_name LIKE '%".$company_name."%'";
                                  }
                                  if (!empty($full_name)){
                                      $sqlquery = $sqlquery . " AND CONCAT(tblregister.first_name,' ', tblregister.last_name) LIKE '%".$full_name."%'";
                                  }
                                  if (!empty($email)){
                                      $sqlquery = $sqlquery . " AND tblregister.email LIKE '%".$email."%'";
                                  }
                                  if (!empty($city)){
                                      $sqlquery = $sqlquery . " AND tblregister.city LIKE '".$city."'";
                                  }
                                  if (!empty($mobile)){
                                      $sqlquery = $sqlquery . " AND tblregister.mobile LIKE '".$mobile."'";
                                  }
                                  if(!empty($from_date)){
                                      $sqlquery = $sqlquery . " AND DATE(tblregister.created) >= '".$from_date."'";
                                  }
                                  if(!empty($to_date)){
                                      $sqlquery = $sqlquery . " AND DATE(tblregister.created) <= '".$to_date."'";
                                  }
                                  $sqlquery = $sqlquery . " ORDER BY tblregister.id DESC LIMIT ".$offset.", ".$rowsPerPage."";
                                  
                                  $resultrows = $fpdo->customResult($sqlquery)->fetchAll();
                                  if(count($resultrows) > 0) {
                                      foreach ($resultrows as $row) {
                                          $numrows = $row['numrows'];
                                      }
                                  }
                                  
                                  $self = $_SERVER['PHP_SELF'];

                                  $querystring= "";

                                  if(!empty($company_name)) {
                                      $querystring = $querystring . "&company_name=".$company_name."";
                                  }
                                  if(!empty($full_name)){
                                      $querystring = $querystring . "&full_name=".$full_name."";
                                  }
                                  if(!empty($email)){
                                      $querystring = $querystring . "&email=".$email."";
                                  }
                                  if(!empty($city)){
                                      $querystring = $querystring . "&city=".$city."";
                                  }
                                  if(!empty($mobile)){
                                      $querystring = $querystring . "&mobile=".$mobile."";
                                  }
                                  if(!empty($date_picker_range)){
                                      $querystring = $querystring . "&date_picker_range=".$date_picker_range."";
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
          <?php } else { ?>
              <table class="table">
                  <tr>
                     <td class="text-center">No Record Found</td>
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

    <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />

    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            Admin.Utils.Customer.displayCustomer();
        });
    </script>
</body>
</html>