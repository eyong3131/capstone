<?php
require_once('../../../config/config.php');
?>
<?php
if(isset($_POST['updateApi'])){
    try{
        $apiCode = trim($_POST['apicode']);
        $apiPassword = trim($_POST['apipassword']);
        $sth = $connection->prepare("UPDATE `itexmo` SET `code` = ?, `password` = ? WHERE `id` = 1 ");
        $sql_sth ->bindParam(1, $apiCode);
        $sql_sth ->bindParam(2, $apiPassword);
        $sth->execute();
    }catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }

}

?>