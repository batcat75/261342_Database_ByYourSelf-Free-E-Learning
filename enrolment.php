<?php
	$user_id = $_GET['user_id'];
	$course_name = $_GET['course_name'];
	$c = oci_connect("TEST", "New25377", "localhost/XE");
	//Find course id
	$s = oci_parse($c, "select course_id
						from course
						where course_name like '$course_name'");
	$r = oci_execute($s);
	$Result = oci_fetch_array($s);
	//Check pre-course
	$s_pre = oci_parse($c, "select pre_course_id
						from pre_course
						where course_id = $Result[0]");
	$r_pre = oci_execute($s_pre);
	$Result_pre = oci_fetch_array($s_pre);
	if($Result_pre > 0){
		$s_check = oci_parse($c, "select *
							from enrollment
							where course_id=$Result_pre[0]
							and mem_id=$user_id
							and flag_pass=1");
		$r_check = oci_execute($s_check);
		$Result_check = oci_fetch_array($s_check);
		if($Result_check>0){
			//Enrolment
			$s = oci_parse($c, "INSERT INTO ENROLLMENT Values ($user_id,$Result[0],0,sysdate)");
			$r = oci_execute($s);
			if(!isset($_GET['test'])){
				//Jump
				if(!isset($_GET['content_name'])){
					$s = oci_parse($c, "select ctn.content_id,ctn.name,ctn.detail
										from  course crs, content ctn
										where  crs.course_id=ctn.course_id
										AND crs.course_name='$course_name'
										order by ctn.content_id");
					$r = oci_execute($s);
					$Result = oci_fetch_array($s);
					$content_name=$Result[1];
				}else{
					$content_name=$_GET['content_name'];
				}
				header("location:content.php?content_name=$content_name&course_name=$course_name");
			}else{
				header("location:test.php?course_name=$course_name");
			}
		}else{
			header("location:course.php?course_name=$course_name&course_id=$Result[0]&pre=1");
		}
	}else{
		//Enrolment
		$s = oci_parse($c, "INSERT INTO ENROLLMENT Values ($user_id,$Result[0],0,sysdate)");
		$r = oci_execute($s);
		if(!isset($_GET['test'])){
			//Jump
			if(!isset($_GET['content_name'])){
				$s = oci_parse($c, "select ctn.content_id,ctn.name,ctn.detail
									from  course crs, content ctn
									where  crs.course_id=ctn.course_id
									AND crs.course_name='$course_name'
									order by ctn.content_id");
				$r = oci_execute($s);
				$Result = oci_fetch_array($s);
				$content_name=$Result[1];
			}else{
				$content_name=$_GET['content_name'];
			}
			header("location:content.php?content_name=$content_name&course_name=$course_name");
		}else{
			header("location:test.php?course_name=$course_name");
		}
	}
	
	
?>