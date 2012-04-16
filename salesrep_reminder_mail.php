<?php
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$return = menu_execute_active_handler();
$success = 1;
$headers = array(
    			'MIME-Version'              => '1.0',
			    'Content-Type'              => 'text/html; charset=UTF-8; format=flowed; delsp=yes',
			    'Content-Transfer-Encoding' => '8Bit',
			    'X-Mailer'                  => 'Drupal',
				'From'                      => 'admin@m2msearch.com',  
				'Reply-to'                  => 'admin@m2msearch.com',
				'CC'						=> 'm2msearch@qualcomm.com'  
	 );
global $base_path;
$sql_com="select c.nid, c.field_company_value,n.created from {content_field_company} c, {node} n where c.nid=n.nid AND n.type IN ('device', 'router', 'connectivity_module') AND n.status='0' AND n.mailstatus='0' order by n.nid ASC";	 
$res_com=db_query($sql_com); 
while($row_com=db_fetch_object($res_com)){
	
	$oneDayTime  = $row_com->created + (1 * 24 * 60 * 60);
	$currentTime = time();
	if($currentTime>=$oneDayTime){
		$dev_com[]=array($row_com->nid => $row_com->field_company_value);
	}
}

foreach($dev_com as $key => $value){
	 foreach($value as $key1=>$val1){
		 $sql="select u.name, u.mail , u.uid , n.title from {content_field_company} c, {node} n, {users} u where c.field_company_value='$val1' AND c.nid=n.nid AND n.type='profile' AND n.uid=u.uid";
		 $res=db_query($sql);
		  while($row=db_fetch_object($res)){
			 $user_info=user_load($row->uid);
			 if($user_info->roles[3]=='Sales Rep') $user_email[]=$row->name."//".$row->mail."//".$key1;
		 }
	}
}

$user_email1=array_unique($user_email);
foreach($user_email1 as $key =>$val){
	$arr_res=explode("//",$val);
	$node_info=node_load($arr_res[2]);
	
	$user_info=user_load($node_info->uid);
	$company_name='';
	foreach($node_info->field_company as $com_key=>$com_val) { $company_name .= rtrim(implode(", ",$com_val),", ") .", ";}
	$company_name = rtrim($company_name,", ");
	//echo "<pre>";print_r($node_info->field_company);echo "</pre>";
	$subject = "M2M Search REMINDER: New Module Awaiting Approval"; 
	global $base_url;
	$login_url=$base_url."/user/login";
   // $node_url="http://".$_SERVER['HTTP_HOST']."/node/".$node_info->nid."/publish?destination=manage/owndevice";
	$node_url=$base_url."/manage/owndevice";
	$message ="Dear $arr_res[0],<br><bR>

This is your final reminder notifying you that <b>$company_name</b> has uploaded a new module, <b>$node_info->title</b>, to the online M2M module database. It requires your verification and approval for it to post publically; to review the module, Please <a href='".$login_url."'> Login </a> into the site to approve the devices waiting your approval. <br><br><br>

Thank you,<br>
M2M Search Admin";

	//mail($row->mail, $subject, $message) or die("error in mail function");
	 drupal_mail_send(array('to'=>$arr_res[1], 'body' => $message, 'subject' => $subject, 'headers' => $headers));
	 //echo "UPDATE {node} SET mailstatus =1 WHERE nid=$node_info->nid";
	 db_query("UPDATE {node} SET mailstatus =1 WHERE nid=$node_info->nid");
}
