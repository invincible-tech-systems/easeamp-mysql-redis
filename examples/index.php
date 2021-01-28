<?php 

require '../vendor/autoload.php';

//require 'EaseAmpMysql.php';

use \InvincibleTechSystems\EaseAmpMysql\EaseAmpMysql;
use \InvincibleTechSystems\EaseAmpRedis\EaseAmpRedis;
use \InvincibleTechSystems\EaseAmpMysqlRedis\EaseAmpMysqlRedis;


$dbHost = "127.0.0.1";
$dbUsername = "chatimmus_dbuser2";
$dbPassword = "khvyi68rtfhf65etdudfy8i";
$dbName = "chatimmus_db2";

$redisHost = 'tcp://localhost:6379';
$redisKeyNamespacePrefix = "MyFirstApp";
$redisKeyExpiryTimeInSeconds = 240;

$dbConn = new EaseAmpMysql($dbHost, $dbUsername, $dbPassword, $dbName);
$redisConn = new EaseAmpRedis($redisHost);

$mysqlRedisConn = new EaseAmpMysqlRedis($dbConn, $redisConn);



//Insert Query (insertWithIntegerAsPrimaryKey)
$query = "INSERT INTO `site_members`(`sm_firstname`, `sm_lastname`) VALUES (:sm_firstname,:sm_lastname)";

$values_array = array();
$values_array = array(':sm_firstname' => 'Raghu',':sm_lastname' => 'D');


//$preparedQuery = $mysqlRedisConn->prepareQuery($query);
//$queryResult = $mysqlRedisConn->runPreparedQuery($preparedQuery, $values_array, "insertWithIntegerAsPrimaryKey");

//$queryResult = $mysqlRedisConn->executeQuery($query, $values_array, "insertWithIntegerAsPrimaryKey");

//single record insert query into mysql and into redis
$queryResult = $mysqlRedisConn->insertSingleRecordMysqlRedis($query, $values_array, "insertWithIntegerAsPrimaryKey", $redisKeyNamespacePrefix, "site_members13322aaaassmmmmm", $redisKeyExpiryTimeInSeconds);


$values_array1 = array(':sm_firstname' => 'Raghu',':sm_lastname' => 'D');
$values_array2 = array(':sm_firstname' => 'krishna',':sm_lastname' => 'N');
$values_array3 = array(':sm_firstname' => 'Veera',':sm_lastname' => '');

$total_values_array = array($values_array1, $values_array2, $values_array3);

$redis_config_values_array1 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223a1q','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);
$redis_config_values_array2 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223b1w','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);
$redis_config_values_array3 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223c1e','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);

$total_redis_config_values_array = array($redis_config_values_array1, $redis_config_values_array2, $redis_config_values_array3);

//multiple records insert query into mysql and into redis
//$queryResult = $mysqlRedisConn->insertMultipleRecordsMysqlRedis($query, $total_values_array, "insertWithIntegerAsPrimaryKey", $total_redis_config_values_array);

echo "===============================================================================================================================================";

//Update Query
$query = "UPDATE `site_members` SET `sm_firstname`=:sm_firstname, `sm_lastname`=:sm_lastname WHERE `sm_memb_id`=:sm_memb_id";

$values_array = array();
$values_array = array(':sm_firstname' => 'RVGV',':sm_lastname' => '',':sm_memb_id' => 2);

//$preparedQuery = $mysqlRedisConn->prepareQuery($query);
//$queryResult = $mysqlRedisConn->runPreparedQuery($preparedQuery, $values_array, "update");

//$queryResult = $mysqlRedisConn->executeQuery($query, $values_array, "update");

//single record update query into mysql and into redis
//$queryResult = $mysqlRedisConn->updateSingleRecordMysqlRedis($query, $values_array, "update", $redisKeyNamespacePrefix, "site_members13322", $redisKeyExpiryTimeInSeconds);


$values_array1 = array(':sm_firstname' => 'Raghu1',':sm_lastname' => '',':sm_memb_id' => 2);
$values_array2 = array(':sm_firstname' => 'krishna1',':sm_lastname' => '',':sm_memb_id' => 3);
$values_array3 = array(':sm_firstname' => 'Veera1',':sm_lastname' => 'p',':sm_memb_id' => 6);

$total_values_array = array($values_array1, $values_array2, $values_array3);

$redis_config_values_array1 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223a1qa','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);
$redis_config_values_array2 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223b1ws','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);
$redis_config_values_array3 = array('namespace_prefix' => $redisKeyNamespacePrefix,'key_name' => 'site_members133223c1ed','expiry_time_def_in_Seconds' => $redisKeyExpiryTimeInSeconds);

$total_redis_config_values_array = array($redis_config_values_array1, $redis_config_values_array2, $redis_config_values_array3);

//multiple records update query into mysql and into redis
//$queryResult = $mysqlRedisConn->updateMultipleRecordsMysqlRedis($query, $total_values_array, "update", $total_redis_config_values_array);


echo "===============================================================================================================================================";
//GET Single Record from Redis:

//Select Query
$query = "SELECT * FROM `site_members` WHERE `sm_memb_id`=:sm_memb_id";

$values_array = array();
$values_array = array(':sm_memb_id' => 1);


$received_key_value = $mysqlRedisConn->getSingleRecordRedis($redisKeyNamespacePrefix, "site_members13322aaaassmmmmm", $query, $values_array, "selectSingle", $redisKeyExpiryTimeInSeconds);
echo "received_key_value: ";
var_dump($received_key_value);



echo "===============================================================================================================================================";

//DELETE Single Record from Redis:

//$key_deletion_result = $mysqlRedisConn->deleteSingleRecordRedis($redisKeyNamespacePrefix, "site_members13322aaaassmmmmm");
//echo "key_deletion_result: ";
//var_dump($key_deletion_result);


echo "===============================================================================================================================================";


//DELETE Single Record from mysql & Redis:

//Delete Query
$query = "DELETE FROM `site_members` WHERE `sm_memb_id`=:sm_memb_id";

$values_array = array();
$values_array = array(':sm_memb_id' => 11);


//single record delete query from mysql and from redis
$queryResult = $mysqlRedisConn->deleteSingleRecordMysqlRedis($redisKeyNamespacePrefix, "site_members13322aaaassmmmmm", $query, $values_array, "delete");




echo "===============================================================================================================================================";



echo "<pre>";
print_r($queryResult);
echo "\n****************************************\n";


?>