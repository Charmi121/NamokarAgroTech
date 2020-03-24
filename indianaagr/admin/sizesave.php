<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: size.php");
        exit;
    }
    unset($_SESSION['tokencode']);

    $edit        =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id          =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $size_name   =   (!empty($_POST['size_name']) ) ? $DB->removeTags($_POST['size_name']) : null;
    $status      =   (!empty($_POST['status'])) ? (int)$DB->removeTags($_POST['status']) : 707;
    $sort_order  =   (!empty($_POST['sort_order'])) ? (int)$DB->removeTags($_POST['sort_order']) : 1;
    $now         =   date("Y-m-d H:i:s", strtotime('now'));
    $action      =   0;

    if (isset($edit) && !empty($size_name)){
      if ((int)$edit == 0){

        $sqlquery = $fpdo->insertInto('tblsizes', array('size_name' => $size_name, 'status' => $status, 'sort_order' => $sort_order, 'created' => $now, 'modified' => $now));
        $result   = $sqlquery->execute();
        $action     =  1;
      } else {
          
      $sqlquery = $fpdo->update('tblsizes')
                         ->set(array(
                                'size_name'   => $size_name,
                                'status'      => $status,
                                'sort_order'  => $sort_order,
                                'modified'    => $now,
                            ));
        $sqlquery->where('id = ?', $id);
        $result = $sqlquery->execute();
        $action     =  2;
      }
    }
   
    if ((int)$action == 1) {
        $_SESSION['size_status'] =   "add";
        header("Location: displaysizes.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['size_status'] =   "update";
        header("Location: displaysizes.php");
        exit;
    } else {
        $_SESSION['size_status'] =   "invalid";
        header("Location: size.php");
        exit;
    }
?>