<?php

class Application_Model_Dasboard
{ 
				function  gettables()
				{
								$db = Zend_Registry::get('db'); 
								$sql = "show tables";
								$stmt   = $db->query($sql);
								$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
								return $result;
				}
				function getcountrecords($tab_name)
				{
							$db = Zend_Registry::get('db'); 
							$sql = "select count(*) as count from ".$tab_name;
							$stmt   = $db->query($sql);
							$result = $stmt->fetch(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function getrecord($tab_name,$startpoint,$limit)
				{
							$db = Zend_Registry::get('db'); 
							if($startpoint == 0 && $limit == 0) {
							$sql = "select * from ".$tab_name." ORDER BY 1 DESC";
							}
							else {
							$sql = "select * from ".$tab_name." ORDER BY 1 DESC limit $startpoint,$limit"; 
							}
							$stmt   = $db->query($sql);
							$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function getstructure($tab_name)
				{
							$db = Zend_Registry::get('db'); 
							$sql = "desc ".$tab_name; 
							$stmt   = $db->query($sql);
							$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function getlastused()
				{
							$db = Zend_Registry::get('db'); 
						 $sql = "SHOW TABLE STATUS"; 
							$stmt   = $db->query($sql);
							$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function gettablerecords($table_name,$id_num, $id_name)
				{
						 $db = Zend_Registry::get('db'); 
						 $sql = "SELECT * FROM ".$table_name." where ".$id_name. "= ".$id_num; 
							$stmt   = $db->query($sql);
							$result = $stmt->fetch(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function getexportdetails($table_name,$id_num, $id_name)
				{
						 $db = Zend_Registry::get('db'); 
					  $sql = "SELECT * FROM ".$table_name." where ".$id_name. " in (".$id_num.")";  
							$stmt   = $db->query($sql);
							$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function deletetablerecords($table_name,$id_num, $id_name)
				{
							$db = Zend_Registry::get('db'); 
					  $sql = "DELETE FROM ".$table_name." where ".$id_name. "= ".$id_num;  
							$stmt   = $db->query($sql);
							if($stmt)
							{
							 $sql = "Insert into history(detail,table_name,table_id) values('".$id_num ." id has been deleted from ".$table_name."','".$table_name."','".$id_num."')"; 
									$stmt   = $db->query($sql);
							  return true;
							}				
							else { return false; }
				}
		 	function inserttablerecord($keys, $values, $tab_name)
				{
								$db = Zend_Registry::get('db'); 
								$sql = "Insert into ".$tab_name."(".$keys.") values('".implode("','",$values)."')"; 
								$stmt   = $db->query($sql);
								$return_id = $db->lastInsertId();
								if($stmt){
									 $sql = "Insert into history(detail,table_name,table_id) values('".$db->lastInsertId() ." A new row has been inserted in ".$tab_name."','".$tab_name."','".$db->lastInsertId()."')"; 
											$stmt   = $db->query($sql);
												return $return_id;
								}
								return false;
				}
			 function updatetablerecord($tab_name, $string, $condition)
				{
					 $db = Zend_Registry::get('db'); 
						$key=array_keys($condition);
		    $value=implode($condition);
				  $sql = "update ". $tab_name ." set ".$string." where ".$key[0]." = ".$value; 
					 $stmt   = $db->query("update ". $tab_name ." set ".$string." where ".$key[0]." = ".$value); 
					 if($stmt){
						 $sql = "Insert into history(detail,table_name,table_id) values('".$value ."has been modified in ".$tab_name."','".$tab_name."','".$value ."')"; 
								$stmt   = $db->query($sql);
					  return true;
					 }
					  return false;
				}
				function getHistoryoftablerecords($tab_name,$limit_start,$limit_end)
				{
				   $db = Zend_Registry::get('db'); 
						 $sql = "SELECT * FROM history where table_name= '".$tab_name."' ORDER BY history.id DESC  limit $limit_start, $limit_end";  
							$stmt   = $db->query($sql);
							$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
							return $result;
				}
				function filterrecords($tab_name, $details,$limit_start,$limit_end)
				{
				  $db = Zend_Registry::get('db'); 
						//print_r($details);
						$keys = array_keys($details);
						$values = array_values($details);
						$sql = "select * from ". $tab_name ." where ";
						for($i=0;$i<count($keys); $i++)
						{ 
								$last_value = count($keys)-1;
						  if($i != $last_value)
								{
								$sql .= $keys[$i]. " = '". $values[$i] . "' and ";
								}
								else 
								{
									$sql .= $keys[$i]. " = '". $values[$i]. "' limit $limit_start, $limit_end ";
								}
						}
					 $stmt   = $db->query($sql); 
						$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
						return $result;
				}
				function filterrecords_query($tab_name,$query,$limit_start,$limit_end)
				{
				    $db = Zend_Registry::get('db'); 
				   	$sql = "select * from ". $tab_name ." where ";
								$fields = $this->getstructure($tab_name);
								for($i=0;$i<count($fields);$i++)
								{
								   $keys[] = $fields[$i]['Field'];
								}
								for($k=0;$k<count($keys);$k++)
								{
							     	$last_value = count($keys)-1;
													if($k != $last_value)
													{
													$sql .= $keys[$k]. " LIKE '%". $query . "%' or ";
													}
													else 
													{
													$sql .=  $keys[$k]. " LIKE '%". $query . "%' limit $limit_start, $limit_end";
													}
								}
								//echo $sql; exit;
						 $stmt   = $db->query($sql); 
						$result = $stmt->fetchAll(Zend_Db::FETCH_ASSOC); //Fething the array and hydrating it in to clean associated array 
						return $result;
				}
}

