<?php

class IndexController extends Zend_Controller_Action
{
   public function init()
   {
        /* Initialize action controller here */
    }
   public function indexAction()
   {
        // action body
								$dashboard = new Application_Model_Dasboard();
								$res = $dashboard->gettables();
								$this->view->assign('res',$res);
							 $lastused = $dashboard->getlastused();
								$this->view->assign('lastused',$lastused);		
					/*	echo "<pre>";
								print_r($lastused);
								echo "</pre>"; */
    }
			public function tabdetailsAction()
			{
							$dashboard = new Application_Model_Dasboard();
							$tab_name = $this->_request->getParam('table'); 
							$desc =  $dashboard->getstructure($tab_name);
						/*	echo "<pre>";
									print_r($res_data);
									echo "</pre>"; exit; */
										$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 7;
    	$startpoint = ($page * $limit) - $limit;
						 if($this->getRequest()->getMethod() == 'POST') 
							{
							$data = $_POST;
							$tab_name = $_POST['table_name'];
															if($data['query'] != "")
															{
																		$res_data = $dashboard->filterrecords_query($tab_name,$data['query'],$startpoint,$limit);		
															}
															else {
																		unset($_POST['table_name']);
																		unset($_POST['query']);
																		$details = $_POST;
																		$res_data = $dashboard->filterrecords($tab_name, $details,$startpoint,$limit);
																}
						 }
							else {
								$res_data = $dashboard->getrecord($tab_name,$startpoint,$limit);
							}
							//	print_r($res_data); exit;
							$this->view->assign('res_data',$res_data);
							$this->view->assign('desc',$desc);
				}
			public function addnewAction()
			{
			   	$dashboard = new Application_Model_Dasboard();
							$tab_name =$this->_request->getParam('table'); 
							$desc =  $dashboard->getstructure($tab_name);
							for($i= 0; $i<count($desc); $i++){
									$test = array_search("auto_increment",$desc[$i]);
									if($test != ''){  break; }
							}
						$id_name = $desc[$i]['Field'];
						//	echo $test = array_search("PRI",$desc[10]);
							 if($this->getRequest()->getMethod() == 'POST') {	
								$data = $_POST;
								//print_r($_POST); exit;
								unset($_POST['_add_another']);
								unset($_POST['_add_edit']);
								unset($_POST['_save']);
								unset($_POST['_continue']);
								unset($_POST['table_name']);
							 $keys = array_keys($_POST);
								$values = array_values($_POST);
								$insert_keys = implode(',',$keys);
								$res_insert = $dashboard->inserttablerecord($insert_keys,$values,$tab_name);
										
								if(isset($data['_add_another'])) 
											{
											$this->_redirect('/index/addnew/table/'.$tab_name.'?add=succ');
											}
								if(isset($data['_add_edit']))
											{
											$this->_redirect('/index/edit/table/'.$tab_name.'/id/'.$res_insert.'/id_name/'.$id_name.'?add=succ');
											}
								if(isset($data['_save']))
											{
												$this->_redirect('/index/tabdetails/table/'.$tab_name.'?add=succ');
											}
								if(isset($data['_continue']))
										{ 
											$this->_redirect('/index/tabdetails/table/'.$tab_name.'?add=cancel');
										}
     }
							$res = $dashboard->gettables();
							$this->view->assign('res',$res);
							$tab_name = $this->_request->getParam('table'); 
							$res_data = $dashboard->getrecord($tab_name,'0','0');
							$desc =  $dashboard->getstructure($tab_name);
							/*	echo "<pre>";
										print_r($res_data);
										echo "</pre>"; exit;*/
							$this->view->assign('res_data',$res_data);
							$this->view->assign('desc',$desc);
			
			}
			public function exportAction()
			{
						$dashboard = new Application_Model_Dasboard();
						$tab_name = $this->_request->getParam('table'); 
					/*	if(isset($_REQUEST['type']) && $_REQUEST['type']=="export" )
						{
							 	 $tab_name = $_REQUEST['tab_name'];
									 $id_values = $_REQUEST['arr']; 
									//print_r($id_values);
									 $id_names= $_REQUEST['idname']; 
						    $result =  $dashboard->getexportdetails($tab_name,$id_values, $id_names);
						}
						else {
									$result = $dashboard->getrecord($tab_name ,'0','0');
						}*/
							
						$desc =  $dashboard->getstructure($tab_name);
						$this->view->assign('desc',$desc);
					 if($this->getRequest()->getMethod() == 'POST') 
						{
					 	 $data = $_POST;
							//	print_r($_POST); 
					 //	print_r($_POST);  exit;
									unset($_POST['send_data']);
									unset($_POST['xml']);
									unset($_POST['csv_options']);
									unset($_POST['csv_options_skip_header']);
									unset($_POST['csv_options_generator_col_sep']);
									unset($_POST['json']);
									unset($_POST['csv']);
									unset($_POST['id_names']);
									unset($_POST['id_values']);
									// $data['id_values'];
									// $data['id_names']; 
									if($data['id_values'] != ""){
									 $result =  $dashboard->getexportdetails($tab_name,$data['id_values'], $data['id_names']);
									}
									else {
										$result = $dashboard->getrecord($tab_name ,'0','0');
									}
								//	print_r($result); exit;
							if(isset($_POST['_continue']))
							{
							   	$this->_redirect('/index/tabdetails/table/'.$tab_name);
							}
					
						 //	echo json_encode($_POST); exit;
						/*************************************************Xml Download Option*******************************************************************************/
							if(isset($data['xml'])) {
														$output = '<?xml version="1.0" encoding="UTF-8"?><'.$tab_name.'s>';
														$keys = array_keys($_POST);
											  //		print_r($result); exit;
														if(count($_POST)>0)
														{
																	foreach($result as $key=>$value) 
																	{
																				foreach($value as $key1 => $value1)
																				{
																				   if(isset($_POST[$key1])) {
																							$output .= sprintf('<'.$tab_name.'><'.$key1.'>%s</'.$key1.'></'.$tab_name.'>',$value1);	
																							$output .= "\n";
																							}
																				}
 																}	
														} 
														$output .= '</'.$tab_name.'s>';
														file_put_contents('/file.xml', $output);
														$filename = "/file.xml"; 
							}
						/*************************************************JSON Download Option*******************************************************************************/
						if(isset($data['json'])) {
													foreach($result as $key=>$value) 
																	{
																				foreach($value as $key1 => $value1)
																				{		
																				  if(isset($_POST[$key1])) 
																						{
																			   	$res_json[][$key1] = $value1;
																						}
																				}	
																		}
																	//	print_r($res_json); exit;
															$output =  json_encode($res_json);
														file_put_contents('/file.json', $output);
														$filename = "/file.json"; 
							}
							/*************************************************CSV Download Option*******************************************************************************/
								if(isset($data['csv'])) {
								$header_row = true;
								$col_sep = ",";
								$row_sep = "\n";
								$qut = '"';	
								$tmp = '';
								$output='';
						//print_r($_POST); exit;
								foreach ($result as $key => $val)
								{
										foreach($val as $key1 => $val1)
										{
										// Escaping quotes.
													if(isset($_POST[$key1])) {
																	$key1 = str_replace($qut, "$qut$qut", $key1);
																	$output .= "$col_sep$qut$key1$qut";
													}
										}
								}	
					   $output = substr($output, 1)."\n";
								    // print_r($tmp);
								foreach ($result as  $cell_key => $cell_val)
								{
												foreach($cell_val as $key1 => $val1)
												{
															if(isset($_POST[$key1])) {
																			$val1 = str_replace($qut, "$qut$qut", $val1);
																			$tmp .= "$col_sep$qut$val1$qut";
															}
												}
							 }
											 $output .= substr($tmp, 1).$row_sep;
											 file_put_contents('/file.csv', $output);
											 $filename = "/file.csv"; 	
 						}
				   if(ini_get('zlib.output_compression'))
				   ini_set('zlib.output_compression', 'Off');
				   $file_extension = strtolower(substr(strrchr($filename,"."),1));
			   	if( $filename == "" ) 
				   {
				    echo "<html><title>eLouai's Download Script</title><body>ERROR: download file NOT SPECIFIED. USE force-download.php?file=filepath</body></html>";
				    exit;
				  } 
		switch( $file_extension )
				{
				  case "pdf": $ctype="application/pdf"; break;
				  case "exe": $ctype="application/octet-stream"; break;
				  case "zip": $ctype="application/zip"; break;
				  case "doc": $ctype="application/msword"; break;
				  case "xls": $ctype="application/vnd.ms-excel"; break;
				  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
				  case "gif": $ctype="image/gif"; break;
				  case "png": $ctype="image/png"; break;
				  case "jpeg":
				  case "jpg": $ctype="image/jpg"; break;
				  default: $ctype="application/force-download";
				}
				@header("Pragma: public"); // required
				@header("Expires: 0");
				@header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				@header("Cache-Control: private",false); // required for certain browsers 
				@header("Content-Type: $ctype");
				// change, added quotes to allow spaces in filenames, by Rajkumar Singh
				@header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
				@header("Content-Transfer-Encoding: binary");
				@header("Content-Length: ".filesize($filename));
				readfile($filename);
			//	unlink($filename);
				exit(); 
						}
			}
			public function historyAction()
			{
			 	$dashboard = new Application_Model_Dasboard();
				 $tab_name = $this->_request->getParam('table'); 
					$desc =  $dashboard->getstructure($tab_name);
					//print_r($desc);
					$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
				 $this->view->assign('desc',$desc);
				 $history_details =	$dashboard->getlastused();
				 $tab_history_details = $dashboard->getHistoryoftablerecords($tab_name ,$startpoint,$limit);
			//	echo "<pre>";
			//	print_r($tab_history_details);
				 $this->view->assign('histor_details',$tab_history_details);
				//print_r($tab_history_details); exit;
			}
			public function showAction()
			{
						   $dashboard = new Application_Model_Dasboard();
						 	 $tab_name = $this->_request->getParam('table'); 
							 	$id_value = $this->_request->getParam('id');
								 $id_name = $this->_request->getParam('id_name'); 
							 	$result = $dashboard->gettablerecords(	$tab_name, 	$id_value, $id_name);
									$this->view->assign('result',$result);
			}
			public function editAction()
			{
			    $dashboard = new Application_Model_Dasboard();
							$tab_name = $this->_request->getParam('table'); 
							$id_value = $this->_request->getParam('id');
							$id_name = $this->_request->getParam('id_name');
						 $result = $dashboard->gettablerecords(	$tab_name, 	$id_value, $id_name);
							$this->view->assign('result',$result);
							$desc =  $dashboard->getstructure($tab_name);
							$this->view->assign('desc',$desc);
						 if($this->getRequest()->getMethod() == 'POST') 
							{	
													//	print_r($_POST); exit;
														$data = $_POST;
													 $condition[$id_name] = $id_value;
														unset($_POST['_add_another']);
														unset($_POST['_add_edit']);
														unset($_POST['_save']);
														unset($_POST['_continue']);
														unset($_POST['table_name']);
														$keys = array_keys($_POST);
														$values = array_values($_POST);
														for($i=0;$i<count($keys);$i++) 
														{              
																		$newarr[]=$keys[$i]."='".$values[$i]."'"; 
														}  
									    	$str=join(',',$newarr);
														$insert_keys = implode(',',$keys);
														$res_insert = $dashboard->updatetablerecord( $tab_name,$str, $condition);
														if(isset($data['_add_another'])) 
														{
												  	 //	echo '/index/delete/table/'.$tab_name.'/id/'.$id_value.'/id_name/'.$id_name
												   //$this->_redirect('/index/delete/table/'.$tab_name.'/id/'.$id_value.'/id_name/'.$id_name);
													    	$this->_redirect('/index/addnew/table/'.$tab_name.'?edit=succ');
												  //$this->_redirect(array( 'controller' => 'index', 'action' => 'delete','table' => $tab_name,'id' => $id_value,'id_name' => $id_name));
														}
														if(isset($data['_add_edit']))
														{
														    $this->_redirect('/index/edit/table/'.$tab_name.'/id/'.$id_value.'/id_name/'.$id_name.'?edit=succ');
 													}
														if(isset($data['_save']))
														{ 
															   $this->_redirect('/index/show/table/'.$tab_name.'/id/'.$id_value.'/id_name/'.$id_name.'?edit=succ');
														}
														if(isset($data['_continue']))
														{ 
															  $this->_redirect('/index/show/table/'.$tab_name.'/id/'.$id_value.'/id_name/'.$id_name.'?edit=cancel');
														}
   			 }
			}
			public function deleteAction()
			{
			    $dashboard = new Application_Model_Dasboard();
							$tab_name = $this->_request->getParam('table'); 
							$id_value = $this->_request->getParam('id');
							$id_name = $this->_request->getParam('id_name');
							if(isset($_POST['type']) && $_POST['type']=="delete")
							{
										//echo $tab_name; exit;
										$tab_name = $_POST['tab_name'];
										$id_values = $_POST['id']; 
										$id_names= $_POST['id_name']; 
							 		$result = $dashboard->deletetablerecords($tab_name, $id_values, $id_names); 
										if($result) 
										{
														echo "1";
														exit;
										}
										else {
															echo "0";
															exit;
										}
							}
							if($this->getRequest()->getMethod() == 'POST') 
							{	
											if($_POST['_continue'] == "yes") 
											{
														$result = $dashboard->deletetablerecords(	$tab_name, 	$id_value, $id_name);
														$this->_redirect('/index/tabdetails/table/'.$tab_name);
						     }
											else 
											{
													$this->_redirect('/index/tabdetails/table/'.$tab_name);
											}
						}
			}
			public function filterAction()
			{
			    $dashboard = new Application_Model_Dasboard();
						 if($this->getRequest()->getMethod() == 'POST') 
							{
          // print_r($_POST); exit;	
										$tab_name = $_POST['table_name'];
										unset($_POST['table_name']);
										unset($_POST['query']);
										$details = $_POST;
										$results = $dashboard->filterrecords($tab_name, $details);
						 }
			}

}

