<?php
require_once('../../../config/config.php');
?>
<?php
if(isset($_POST['illnessUpdate'])){
    try{
        $P_actions = $_POST['illnessActions'];
        $P_illness = $_POST['illnessType'];
        /********/
        $sth = $connection->prepare("SELECT id FROM `illness_desc` WHERE illness_desc.illness_type LIKE CONCAT('%', ? , '%');");
        $sth->bindparam(1,$P_illness,PDO::PARAM_STR);
        $sth->execute();
        $illness_id = $sth->fetch(PDO::FETCH_ASSOC);
        $id = (int)$illness_id['id'];
        if ($illness_id == NULL){
            $sql_sth = $connection->prepare("INSERT INTO `illness_desc`(`illness_type`,`actions`)VALUES(?,?);");
            $sql_sth ->bindParam(1, $P_illness,PDO::PARAM_STR);
            $sql_sth ->bindParam(2, $P_actions,PDO::PARAM_STR);
            $sql_sth ->execute();
            $sql_sth->nextRowset();
        }else{
            $sql_sth = $connection->prepare("UPDATE `illness_desc` SET `actions` = ? WHERE `id` = ? ");
            $sql_sth ->bindParam(1, $P_actions,PDO::PARAM_STR);
            $sql_sth ->bindParam(2, $id,PDO::PARAM_STR);
            $sql_sth ->execute();
            $sql_sth ->nextRowset();
        }
        header("Location:../sysconfig.php");
        }catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}
?>
