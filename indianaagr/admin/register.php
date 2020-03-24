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
      <h3>Customer</h3>
      <div class="col-md-12"><div class="blank-border"></div></div>

      <?php if(!empty($_SESSION['registerstatus']) &&  $_SESSION['registerstatus']=="invalid" ) { ?>
          <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Invalid!</h4>
              <?php echo $errorlist['register'][$_SESSION['registerstatus']]; ?>
          </div>
          <div class="clearfix"></div>
      <?php unset($_SESSION['registerstatus']);
           } elseif(!empty($_SESSION['registerstatus']) &&  $_SESSION['registerstatus']!="invalid") {
      ?>
          <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Success!</h4>
              <?php echo $errorlist['register'][$_SESSION['registerstatus']]; ?>
          </div>
          <div class="clearfix"></div>
      <?php unset($_SESSION['registerstatus']); } ?>

      <div class="clearfix"></div>
      <div class="middlesection margin-top20">
            <?php
                if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1)
                {
                    $edit    = (int)$_GET['edit'];
                    $user_id = (int)$_GET['id'];

                    $sqlquery = "SELECT tblregister.*, tblregister_billing_addresses.billing_company_name, tblregister_billing_addresses.billing_business_number, tblcountries.countryname FROM tblregister";
                    $sqlquery = $sqlquery ." INNER JOIN tblregister_billing_addresses ON tblregister_billing_addresses.user_id = tblregister.id";
                    $sqlquery = $sqlquery ." LEFT OUTER JOIN tblcountries ON tblcountries.id = tblregister.country_id";
                    $sqlquery = $sqlquery ." WHERE tblregister.id = ".$user_id." ORDER BY tblregister.id";
                    $rsdata   = $fpdo->customResult($sqlquery)->fetchAll();
                    if (count($rsdata) > 0)
                    {
                        foreach($rsdata as $rowdata)
                        {
                            $company_name       =   trim($rowdata['billing_company_name']);
                            $business_number    =   trim($rowdata['billing_business_number']);
                            $email              =   trim($rowdata['email']);
                            $password           =   null;
                            $first_name         =   trim($rowdata['first_name']);
                            //$middle_name        =   trim($rowdata['middle_name']);
                            $last_name          =   trim($rowdata['last_name']);
                            $phone              =   trim($rowdata['phone']);
                            $mobile             =   trim($rowdata['mobile']);
                            $address            =   trim($rowdata['address']);
                            //$address_2          =   trim($rowdata['address_2']);
                            $country_id         =   trim($rowdata['country_id']);
                            $state_id           =   trim($rowdata['state_id']);
                            $country            =   trim($rowdata['countryname']);
                            $state              =   trim($rowdata['state']);
                            $city               =   trim($rowdata['city']);
                            $zip                =   trim($rowdata['zip']);
                            //$dob                =   date("d-M-Y", strtotime($rowdata['dob']));
                            //$gender             =   trim($rowdata['gender']);
                            $ipadd              =   trim($rowdata['ipadd']);
                            $enter_date         =   date("d-M-Y", strtotime($rowdata['enter_date']));
                            //$send_notification  =   (int)$rowdata['send_notification'];
                            $is_verified        =   (int)$rowdata['is_verified'];
                            $allow_on_account   =   (int)$rowdata['allow_on_account'];
                            $status             =   (int)$rowdata['status'];
                        }
                    }
                                        
                } else {
                    $edit               =   0;
                    $user_id            =   0;
                    $company_name       =   '';
                    $business_number    =   '';
                    $email              =   '';
                    $password           =   $DB->GeneratePassword(6);
                    $first_name         =   '';
                    $middle_name        =   '';
                    $last_name          =   '';
                    $phone              =   '';
                    $mobile             =   '';
                    $address            =   '';
                    //$address_2          =   '';
                    $city               =   '';
                    $country_id         =   14;
                    $state              =   '';
                    $zip                =   '';
                    $dob                =   '';
                    $gender             =   '';
                    $ipadd              =   '';
                    $enter_date         =   '';
                    //$send_notification  =   505;
                    $is_verified        =   0;
                    $allow_on_account   =   0;
                    $status             =   707;
                }
                $_SESSION['tokencode']  =   $DB->generateToken();
            ?>
            <form name="addform" id="addform" method="post" action="registersave.php" enctype="multipart/form-data" target="_self">
                <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode']; ?>" />
                <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $user_id;?>" />
                  <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Company Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="company_name" id="company_name" value="<?php echo $company_name; ?>" class="form-control required" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Business Number</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="business_number" id="business_number" value="<?php echo $business_number; ?>" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Email<span class="text-danger">*</span></div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" class="form-control required" />
                                    <div id="emailinfo"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-4"><div class="text-right">First Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control required" />
                                </div>
                            </td>
                        </tr>
                        <?php /*
                        <tr>
                            <td class="col-md-4"><div class="text-right">Middle Name</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <?php echo $middle_name;?>
                                </div>
                            </td>
                        </tr>
                        */ ?>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Last Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" class="form-control required" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">Phone</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" class="form-control required" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                           <td class="col-md-4"><div class="text-right">Mobile<span class="text-danger">*</span></div></td>
                           <td class="col-md-8">
                               <div class="col-md-9">
                                   <input type="text" name="mobile" id="mobile" value="<?php echo $mobile; ?>" class="form-control required" />
                               </div>
                           </td>
                        </tr>
                     
                        <tr>
                            <td class="col-md-4"><div class="text-right">Address</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="address" id="address" value="<?php echo $address; ?>" class="form-control required" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">Country</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <select name="country_id" id="country_id" class="country form-control">
                                        <?php
                                            $sqlquery = $fpdo->from('tblcountries')
                                                             ->select(null)
                                                             ->select('tblcountries.id, tblcountries.countryname, tblcountries.status')
                                                             ->where("tblcountries.status = :status", array(":status" => 707))
                                                             ->orderBy("tblcountries.countryname");
                                            $rscountry = $sqlquery->fetchAll();
                                            if(!empty($rscountry)) {
                                                foreach($rscountry as $rowcountry) {
                                        ?>
                                        <option value="<?php echo $rowcountry['id']; ?>" <?php if ((int)$rowcountry['id'] == (int)$country_id) { echo "selected='selected'"; } ?>><?php echo $rowcountry['countryname']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">State</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="state" id="state" value="<?php echo $state; ?>" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">City</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="city" id="city" value="<?php echo $city; ?>" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">Pin Code</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="text" name="zip" id="zip" value="<?php echo $zip; ?>" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">Approve</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="checkbox" name="is_verified" id="is_verified" value="1" <?php if((int)$is_verified == 1) { echo "checked=\"checked\""; } ?> />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-4"><div class="text-right">Allow on Account</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <input type="checkbox" name="allow_on_account" id="allow_on_account" value="1" <?php if((int)$allow_on_account == 1) { echo "checked=\"checked\""; } ?> />
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><div class="text-right">Status</div></td>
                            <td>
                                <div class="col-md-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="707" <?php if ((int) $status == 707) { echo "selected=\"selected\""; } ?>>Enable</option>
                                        <option value="505" <?php if ((int) $status == 505) { echo "selected\"selected\""; } ?>>Disable</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        
                        <?php 
                        /*
                         <tr>
                            <td class="col-md-4"><div class="text-right">Gender</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <?php echo $gender; ?>
                                </div>
                            </td>
                        </tr>
                       
                         <tr>
                            <td class="col-md-4"><div class="text-right">DOB</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <?php echo $dob; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Send personalised emails/sms/newsletters on attractive deals available in the city.</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <?php
                                        if($send_notification == 707){
                                          echo "Yes";
                                        } else {
                                          echo "No";
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-4"><div class="text-right">Is verified ?</div></td>
                            <td class="col-md-8">
                                <div class="col-md-9">
                                    <?php
                                        if($is_verified == 707){
                                          echo "Yes";
                                        } else {
                                          echo "No";
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>   */ 
                        ?>
                        <tr>
                            <td><div class="text-right">Notify Customer</div></td>
                            <td class="col-md-8">
                                <div class="col-md-12">
                                    <label><input type="radio" name="verify_mail" id="verify_mail_1" value="1" class="approve" /> Send Verification Mail</label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="verify_mail" id="verify_mail_2" value="2" /> Send Disapproval Mail</label>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td>
                                <div class="col-md-6">
                                    <a href="displayregister.php" class="btn btn-warning"><i class="fa fa-undo"></i> Return</a>
                                    <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-large btn-primary">Submit <i class=" fa fa-arrow-right"></i></button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
              </form>
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
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>

<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css" />
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>


<script type="text/javascript" src="js/admin.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    Admin.Utils.Customer.initCustomer();
    Admin.Utils.Customer.validateCustomer();
});
</script>
</body>
</html>