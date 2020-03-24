<?php
error_reporting(E_ALL);
include_once ("FluentPDO/FluentPDO.php");
try {
    $pdo = new PDO('mysql:host=localhost;dbname=indiaagr_agro19', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    $fpdo = new FluentPDO($pdo);
    //~ $fpdo->debug = true;
} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
?>
    <div style="font-family:calibri; margin:0 auto; text-align: center; margin-top:10em;">
        <h2>Website Under Maintenance</h2>
        <p>Hi, our website is currently undergoing scheduled maintenance, Please check back very soon.</p>
        <p><strong>Sorry for the inconvinence!</strong></p>
    </div>
<?php
    exit;
}
?>
