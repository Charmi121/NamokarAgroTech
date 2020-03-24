<?php
   
 require_once('main.php');
require("connect.inc.php");
require("config.php");
$DB = new DBConfig();
$DB->config();
   

    


    $name               =   (!empty($_POST['name'])) ? $_POST['name'] : "";
    $email                 =   (!empty($_POST['email'])) ? $_POST['email'] : "";
            
	
                    
                    $sqlquery = $fpdo->from('tblnewsletter_subscribers')->where("email",$email);
                    $rsdata   = $sqlquery->fetchAll();
                    if (count($rsdata) > 0) 
					{
					  echo 2;
					}
			        else{
			
							$sqlquery = $fpdo->insertInto('tblnewsletter_subscribers', array(
															'name' => $name,                                            
															'email' => trim($email)                                                                                  
														 ));
							$res=$sqlquery->execute();            
							if($res)
								echo 1;
							else
								echo 0;
            
					}
    
    
?>