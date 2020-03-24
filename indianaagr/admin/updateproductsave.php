<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    
    $DB = new DBConfig();    

    $hdnproducts = (!empty($_POST['hdnproduct'])) ? $_POST['hdnproduct'] : array();
    $chkproducts = (!empty($_POST['chkproduct'])) ? $_POST['chkproduct'] : array(); 
    $status = 505;
    $modified = date("Y-m-d H:i:s", strtotime("now"));
    $action = 0;
    
    if(!empty($hdnproducts)) {
        foreach($hdnproducts as $hdnproduct){
            
            $status = (empty($_POST["chkproduct_".$hdnproduct.""])) ? 505 : 707;
            
            $sqlquery = $fpdo->update('tblproducts')->set(array(
                                        'status' => $status,
                                        'modified' => $modified
                                   ));
            $sqlquery->where('tblproducts.id = ?', $hdnproduct);
            $sqlquery->execute();
            
            $action = 2;
                
        }        
    }
    
    if ((int)$action == 1) {
        $_SESSION['productstatus'] = "add";
        header("Location: displayproduct.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['productstatus'] = "update";
        header("Location: displayproduct.php");
        exit;
    } else {
        $_SESSION['productstatus'] = "invalid";
        header("Location: displayproduct.php");
        exit;
    }
?>