<?php

declare(strict_types=1);

namespace InvincibleTechSystems\EaseAmpMysqlRedis;

use \Amp\Mysql;
use \InvincibleTechSystems\EaseAmpMysql\EaseAmpMysql;
use InvincibleTechSystems\EaseAmpRedis\EaseAmpRedis;

/*
* Name: EaseAmpMysqlRedis
*
* Author: Raghuveer Dendukuri
*
* Company: Invincible Tech Systems
*
* Version: 0.0.1
*
* Description: A very simple and safe PHP library that enables easy redis cache warmup from MySQL/MariaDB Database. This uses custom redis warmup class methods based on , 
* on top of EaseAmpMysql package, that wraps up the AmPHP related MySQL and Redis Packages to interact with MySQL/MariaDB database and Redis in-memory cache in an asynchronous & 
* non-blocking way.
*
* License: MIT
*
* @copyright 2020 Invincible Tech Systems
*/
class EaseAmpMysqlRedis {
	
	private $dbConn;
	private $dbStatement;
	private $dbQueryResponse;
	private $redisConn;

	public function __construct(EaseAmpMysql $dbConn, EaseAmpRedis $redisConn) {
		
		$this->dbConn = $dbConn;
		$this->redisConn = $redisConn;
		
    }
	
	public function insertSingleRecordMysqlRedis(string $query, array $valueArray, string $crudOperationType, string $redisKeyNamespacePrefix, string $redisKeyNameSuffix, int $expiryInSeconds) {
		
		
		try {
			
			$result = [];
			
			if (($crudOperationType == "insertWithIntegerAsPrimaryKey") || ($crudOperationType == "insertWithUUIDAsPrimaryKey")) {
				
				$this->dbQueryResponse = $this->dbConn->executeQuery($query, $valueArray, $crudOperationType);
			
				if ($this->dbQueryResponse != "") {
					
					$result["db_query_response"] = $this->dbQueryResponse;
					
					$collected_value_array = $this->createArrayFromArrayReplacingNullWithEmptyString($valueArray);
					
					$redis_mapset_result = $this->redisConn->mapSet($redisKeyNamespacePrefix, $redisKeyNameSuffix, $collected_value_array);
					
					$result["redis_mapset_result"] = $redis_mapset_result;
					
					$redis_expire_def_result = $this->redisConn->expire($redisKeyNamespacePrefix, $redisKeyNameSuffix, $expiryInSeconds);
					
					$result["redis_expire_def_result"] = $redis_expire_def_result;

				}
				
				return $result;
				
			} else {
				
				throw new \Exception("In-correct CRUD Operation Type Keyword inputed! \n");
				
			}
			
			
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	
	public function insertMultipleRecordsMysqlRedis(string $query, array $multiRecordValuesArray, string $crudOperationType, array $multiRecordRedisConfigValuesArray) {
		
		try {
			
			$result = [];
			
			$this->dbStatement = $this->dbConn->prepareQuery($query);
			
			if (count($multiRecordValuesArray) == count($multiRecordRedisConfigValuesArray)) {
				
				$i = 0;
			
				foreach ($multiRecordValuesArray as $singleRecordValuesArray) {
					
					$row_result = [];
					
					if (($crudOperationType == "insertWithIntegerAsPrimaryKey") || ($crudOperationType == "insertWithUUIDAsPrimaryKey")) {
				
						$this->dbQueryResponse = $this->dbConn->runPreparedQuery($this->dbStatement, $singleRecordValuesArray, $crudOperationType);
					
						if ($this->dbQueryResponse != "") {
							
							$row_result["db_query_response"] = $this->dbQueryResponse;
							
							$collectedSingleRecordValuesArray = $this->createArrayFromArrayReplacingNullWithEmptyString($singleRecordValuesArray);
								
							$redis_mapset_result = $this->redisConn->mapSet($multiRecordRedisConfigValuesArray[$i]["namespace_prefix"], $multiRecordRedisConfigValuesArray[$i]["key_name"], $collectedSingleRecordValuesArray);
							
							$row_result["redis_mapset_result"] = $redis_mapset_result;
							
							$redis_expire_def_result = $this->redisConn->expire($multiRecordRedisConfigValuesArray[$i]["namespace_prefix"], $multiRecordRedisConfigValuesArray[$i]["key_name"], $multiRecordRedisConfigValuesArray[$i]["expiry_time_def_in_Seconds"]);
							
							$row_result["redis_expire_def_result"] = $redis_expire_def_result;

						}
						
						
						$result[] = $row_result;
					
						
					} else {
						
						throw new \Exception("In-correct CRUD Operation Type Keyword inputed! \n");
						
					}
					
					$i++;
				}
				
			} else {
				
				throw new \Exception("Count of DB Query Values Array & Redis Config values Array are not matching, please check! \n");
				
			}
			
			return $result;
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	public function updateSingleRecordMysqlRedis(string $query, array $valueArray, string $crudOperationType, string $redisKeyNamespacePrefix, string $redisKeyNameSuffix, int $expiryInSeconds) {
		
		try {
			
			$result = [];
			
			if ($crudOperationType == "update") {
				
				$this->dbQueryResponse = $this->dbConn->executeQuery($query, $valueArray, $crudOperationType);
			
				if ($this->dbQueryResponse != "") {
					
					$result["db_query_response"] = $this->dbQueryResponse;
					
					$collectedValueArray = $this->createArrayFromArrayReplacingNullWithEmptyString($valueArray);
						
					$redis_mapset_result = $this->redisConn->mapSet($redisKeyNamespacePrefix, $redisKeyNameSuffix, $collectedValueArray);
					
					$result["redis_mapset_result"] = $redis_mapset_result;
					
					$redis_expire_def_result = $this->redisConn->expire($redisKeyNamespacePrefix, $redisKeyNameSuffix, $expiryInSeconds);
					
					$result["redis_expire_def_result"] = $redis_expire_def_result;

				} else {
					//Note: This error happens when the record doesnot exist or when data submitted is same as data in the database record		
					$result["db_query_response"] = "db-update-query-error";
					
					$result["redis_mapset_result"] = "operation-not-performed-now";
					
					$result["redis_expire_def_result"] = "operation-not-performed-now";
					
				}
				
				return $result;
				
			} else {
				
				throw new \Exception("In-correct CRUD Operation Type Keyword inputed! \n");
				
			}
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	public function updateMultipleRecordsMysqlRedis(string $query, array $multiRecordValuesArray, string $crudOperationType, array $multiRecordRedisConfigValuesArray) {
		
		try {
			
			$result = [];
			
			$this->dbStatement = $this->dbConn->prepareQuery($query);
			
			if (count($multiRecordValuesArray) == count($multiRecordRedisConfigValuesArray)) {
				
				$i = 0;
			
				foreach ($multiRecordValuesArray as $singleRecordValuesArray) {
					
					$row_result = [];
					
					if ($crudOperationType == "update") {
				
						$this->dbQueryResponse = $this->dbConn->runPreparedQuery($this->dbStatement, $singleRecordValuesArray, $crudOperationType);
					
						if ($this->dbQueryResponse != "") {
							
							$row_result["db_query_response"] = $this->dbQueryResponse;
							
							$collectedSingleRecordValuesArray = $this->createArrayFromArrayReplacingNullWithEmptyString($singleRecordValuesArray);
								
							$redis_mapset_result = $this->redisConn->mapSet($multiRecordRedisConfigValuesArray[$i]["namespace_prefix"], $multiRecordRedisConfigValuesArray[$i]["key_name"], $collectedSingleRecordValuesArray);
							
							$row_result["redis_mapset_result"] = $redis_mapset_result;
							
							$redis_expire_def_result = $this->redisConn->expire($multiRecordRedisConfigValuesArray[$i]["namespace_prefix"], $multiRecordRedisConfigValuesArray[$i]["key_name"], $multiRecordRedisConfigValuesArray[$i]["expiry_time_def_in_Seconds"]);
							
							$row_result["redis_expire_def_result"] = $redis_expire_def_result;

						} else {
							//Note: This error happens when the record doesnot exist or when data submitted is same as data in the database record
							$row_result["db_query_response"] = "db-update-query-error";
							
							$row_result["redis_mapset_result"] = "operation-not-performed-now";
							
							$row_result["redis_expire_def_result"] = "operation-not-performed-now";
							
						}
						
						$result[] = $row_result;
					
					} else {
						
						throw new \Exception("In-correct CRUD Operation Type Keyword inputed! \n");
						
					}
					
					$i++;
				}
				
			} else {
				
				throw new \Exception("Count of DB Query Values Array & Redis Config values Array are not matching, please check! \n");
				
			}
			
			return $result;
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
		
	}
	
	public function getSingleRecordRedis(string $redisKeyNamespacePrefix, string $redisKeyNameSuffix, string $query, array $valueArray, string $crudOperationType, int $expiryInSeconds) {
		
		try {
			
			if ($this->redisConn->exists($redisKeyNamespacePrefix,$redisKeyNameSuffix) === true) {
				echo "\n key value from REDIS CACHE\n";
				$received_record_value = $this->redisConn->get($redisKeyNamespacePrefix, $redisKeyNameSuffix);
				
			} else {
				echo "\n key value from REDIS CACHE, after populated from mysql\n";
				if ($crudOperationType == "selectSingle") {
					
					$result = [];
					
					$this->dbQueryResponse = $this->dbConn->executeQuery($query, $valueArray, $crudOperationType);
				
					if ($this->dbQueryResponse > 0) {
						
						$result["db_query_response"] = $this->dbQueryResponse;
						
						$collected_result = $this->createArrayFromArrayReplacingNullWithEmptyString($this->dbQueryResponse);
						
						$redis_mapset_result = $this->redisConn->mapSet($redisKeyNamespacePrefix, $redisKeyNameSuffix, $collected_result);
						
						$result["redis_mapset_result"] = $redis_mapset_result;
						
						$redis_expire_def_result = $this->redisConn->expire($redisKeyNamespacePrefix, $redisKeyNameSuffix, $expiryInSeconds);
						
						$result["redis_expire_def_result"] = $redis_expire_def_result;
						
						if ((count($result["db_query_response"]) > 0) && ($result["redis_mapset_result"] == 1) && ($result["redis_expire_def_result"]) && ($this->redisConn->exists($redisKeyNamespacePrefix,$redisKeyNameSuffix) === true)) {
							
							$received_record_value = $this->redisConn->get($redisKeyNamespacePrefix, $redisKeyNameSuffix);
							
						}

					} else {
						
						throw new \Exception("Error Receiving record data from database, data doesn't exist! \n");
						
					}
					
				} else {
					
					throw new \Exception("In-correct CRUD Operation Type Keyword inputed! \n");
					
				}
				
			}
			
			return $received_record_value;
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
		
	public function deleteSingleRecordMysqlRedis(string $redisKeyNamespacePrefix, string $redisKeyNameSuffix, string $query, array $valueArray, string $crudOperationType) {
		
		try {
			
			if (($this->redisConn->exists($redisKeyNamespacePrefix,$redisKeyNameSuffix) === true) && ($crudOperationType == "delete")) {
				
				$result = [];
					
				$this->dbQueryResponse = $this->dbConn->executeQuery($query, $valueArray, $crudOperationType);
				
				if ($this->dbQueryResponse === true) {
					
					$result["db_query_response"] = $this->dbQueryResponse;
					
					//Since method to execute Single Delete doesnot exist, EXPIRE method is being used temporarily, i.e. to expire the key in 1 second.
			
					$result["redis_delete_operation_result"] = $this->redisConn->expire($redisKeyNamespacePrefix, $redisKeyNameSuffix, 1);
						
					return $result;
					
				} else {
					
					throw new \Exception("Error with Delete Query/Record not Found! ");
					
				}
				
			} else {
				
				throw new \Exception("Delete operation cannot be performed. Key Submitted does not exist! ");
				
			}
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	public function deleteSingleRecordRedis(string $redisKeyNamespacePrefix, string $redisKeyNameSuffix) {
		
		try {
			
			if ($this->redisConn->exists($redisKeyNamespacePrefix,$redisKeyNameSuffix) === true) {
				
				//Since method to execute Single Delete doesnot exist, EXPIRE method is being used temporarily, i.e. to expire the key in 1 second.
			
				$redis_delete_operation_result = $this->redisConn->expire($redisKeyNamespacePrefix, $redisKeyNameSuffix, 1);
						
				return $redis_delete_operation_result;
				
			} else {
				
				throw new \Exception("Delete operation cannot be performed. Key Submitted doesnot exist! ");
				
			}
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	public function createArrayFromObjectReplacingNullWithEmptyString(object $inputedObject) {
		
		try {
			
			$collected_result = [];
						
			foreach ($inputedObject as $key=>$value) {
				
				if (is_null($value)) {
					$value = "";
				}	
				$collected_result[$key] = $value;
				
			}
			
			return $collected_result;
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	public function createArrayFromArrayReplacingNullWithEmptyString(array $inputedArray) {
		
		try {
			
			$collected_result = [];
						
			foreach ($inputedArray as $key=>$value) {
				
				if (is_null($value)) {
					$value = "";
				}	
				$collected_result[$key] = $value;
				
			}
			
			return $collected_result;
			
		} catch (\Exception $e) {
			
			throw new \Exception($e->getMessage(), (int)$e->getCode());
			
		}
		
	}
	
	//$this->pool->close();
}
?>