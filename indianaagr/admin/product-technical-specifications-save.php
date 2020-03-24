<?php
    set_time_limit(0);
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    $DB = new DBConfig();
    /*
    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: product.php");
        exit;
    }
    unset($_SESSION['tokencode']);
    */

    $edit                         =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $delete                       =   (!empty($_POST['delete'])) ? (int)$_POST['delete'] : 0;
    $title			 	          =   (!empty($_POST['title'])) ? trim($_POST['title']) : '';
    $tech_description 	          =   (!empty($_POST['tech_description'])) ? htmlentities($_POST['tech_description'],ENT_QUOTES,"utf-8") : '';
    $product_id                   =   (!empty($_POST['product_id'])) ? (int)$_POST['product_id'] : 0;
    $id			                  =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $status 	                  =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order		              =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0;
	$now   						  =	 date('Y-m-d H:i:s',strtotime('now'));
    if (!empty($product_id) && empty($edit)  && empty($delete)){
		
		$sqlquery = $fpdo->insertInto('tblproduct_tech_spec', array(
								 'product_id' => $product_id,
								 'title' => $title,
								 'tech_description' => $tech_description,
								 'status' => $status,
								 'sort_order' => $sort_order,
								 'created' => $now,
								 'modified' => $now
							 ));
		$sqlquery->execute();
		
		$action = 1;
		
    } else if (!empty($product_id) && !empty($edit) && !empty($id) && empty($delete)){
		$sqlquery = $fpdo->update('tblproduct_tech_spec')->set(array(
								 'product_id' => $product_id,
								 'title' => $title,
								 'tech_description' => $tech_description,
								 'status' => $status,
								 'sort_order' => $sort_order,
								 'modified' => $now
								))->where('id = ?',$id);
		$sqlquery->execute();
		
		$action = 2;
	} else if (!empty($product_id) && !empty($delete) && !empty($id)){
		$sqlquery = $fpdo->update('tblproduct_tech_spec')->set(array(
									'status' => 909,
									'modified' => $now
								))->where('id = ?',$id);
		$sqlquery->execute();
		
		$action = 3;
	}
    
    if ((int)$action == 1) {
        $_SESSION['technicalstatus'] =   "add";
        header("Location: product-technical-specifications.php?product_id=".$product_id."&edit=0");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['technicalstatus'] =   "update";
        header("Location: product-technical-specifications.php?product_id=".$product_id."&edit=0");
        exit;
    } elseif ((int)$action == 3) {
        $_SESSION['technicalstatus'] =   "deleted";
        header("Location: product-technical-specifications.php?product_id=".$product_id."&edit=0");
        exit;
    } else {
        $_SESSION['technicalstatus'] =   "invalid";
        header("Location: displayproduct.php");
        exit;
    }   
?>