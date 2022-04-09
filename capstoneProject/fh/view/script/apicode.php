<?php
require_once('../../../config/config.php');
?>
<?php
if(isset($_POST['apiUpdate'])){
    try{
        $apiCode = trim($_POST['apicode']);
        $apiPassword = trim($_POST['apipassword']);
        $sth = $connection->prepare("UPDATE `itexmo` SET `code` = ?, `password` = ? WHERE `id` = 1 ");
        $sth ->bindParam(1, $apiCode,PDO::PARAM_STR);
        $sth ->bindParam(2, $apiPassword,PDO::PARAM_STR);
        $sth->execute();
        $sth->nextRowset();
        header("Location:../sysconfig.php");
    }catch (PDOException $e) {
        echo ("Error: " . $e->getMessage());
    }
}

?>