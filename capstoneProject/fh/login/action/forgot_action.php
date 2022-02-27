<?php
//##########################################################################
// ITEXMO SEND SMS API - PHP - CURL METHOD
// Visit www.itexmo.com/developers.php for more info about this API
//##########################################################################

function itexmo($number,$message,$apicode,$passwd){
    $ch = curl_init();
    $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
    curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
              http_build_query($itexmo));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec ($ch);
    curl_close ($ch);
  }
  //##########################################################################
  
?>
<?php 
    session_start();
    require_once('../../../config/config.php');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['forgot'])){
            /** Itextmo */ 
            $sth_itexmo = $connection->prepare("SELECT * FROM `itexmo` WHERE 1");
            $sth_itexmo->execute();
            $apiItexmo = $sth_itexmo->fetch(PDO::FETCH_ASSOC);
            $sth_itexmo->nextRowSet();
            /********/
            $sth=$connection->prepare("SELECT * FROM `admin` WHERE email=:email");
            $sth->execute(array(':email'=>htmlspecialchars($_POST['email'])));
            $row=$sth->fetch(PDO::FETCH_ASSOC);
            $sth->nextRowset();
            
            $username = trim(htmlspecialchars($row['email']));
            $new_password = htmlspecialchars(random_str(8, '1234567890asdfghjkpqwertyuopzxcvbn'));
            $encrypt = password_hash($new_password,PASSWORD_DEFAULT);

            $sth=$connection->prepare("UPDATE `admin` SET `temp_password` = ? WHERE email=? ");
            $sth->bindParam(1,$encrypt,PDO::PARAM_STR);
            $sth->bindParam(2,$username,PDO::PARAM_STR);

            try{
                $sth->execute();
                $sth->nextRowset();
              }catch(Exception $e){
                //echo "<script>console.log('". $e ."')</script>";
              }
            
            //$number = "09653926662";
            //$apicode = "TR-MAYET926662_XEQA1";
            //$passwd = "k]46l#8&#p";
            $number = trim($row['contact']);
            $message = "Your Code is: " . $new_password;
            $apicode = $apiItexmo['code'];
            $passwd = $apiItexmo['password'];


            itexmo($number,$message,$apicode,$passwd);

            $_SESSION['msg']= "Verification Code has been sent to your mobile number";
            header('Location:../update.php');
        }
    }
?>

<?php 
/**
 * Generate a random string, using a cryptographically secure 
 * pseudorandom number generator (random_int)
 *
 * This function uses type hints now (PHP 7+ only), but it was originally
 * written for PHP 5 as well.
 * 
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 * 
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
?>