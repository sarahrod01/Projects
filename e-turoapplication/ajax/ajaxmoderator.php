<?php
	$_GET['name'];
	include_once'../class/classuser.php';
	$u=new Cuser();
	
	$data=$u->searchModerator($_GET['name']);
		if($data->num_rows<=0){
			echo '<tr>
					<td colspan=5 class="text-center"><h4>No Data Found!</h4></td>
				</tr>';
			}else{
				while($row=$data->fetch_assoc()){
					$name= $row['firstname'].' '.$row['lastname'];
					
					if($u->getStatus($row['userid'])=='active'){
						$chk='checked';
						}else{
						$chk='';
						}
					echo'
						<tr>
						  <td  data-toggle="modal" data-target="#editinfo" onclick="editinfo(&quot;'.$row['userid'].'&quot;,&quot;'.$row['lastname'].'&quot;,&quot;'.$row['firstname'].'&quot;,&quot;'.$row['middlename'].'&quot;,&quot;'.$row['email'].'&quot;,&quot;'.$row['address'].'&quot;,&quot;'.$row['contact'].'&quot;,&quot;'.$row['coursename'].'&quot;)"><h4>'.$row['userid'].'</h4></td>
						  <td><h4>'.$name.'</h4></td>
						  <td><h4>'.$row['contact'].'</h4></td>
						  <td><h4>'.$row['address'].'</h4></td>
						  <td class="text-center negative-right-margin"><h3><input class="form-check-input negative-right-margin"  onclick="updateStatus(this,&quot;'.$row['userid'].'&quot;)" '.$chk.' type="checkbox" value="'.$row['userid'].'" class="mt-2 ms-4"></h3>
						  </td>
						</tr>
							';
				}
			}

?>
<script>
	function updateStatus(ths,userid){
		var userid=ths.value;
		var stat=ths.checked;
		if(ths.checked==true){
			stat='active';
		}else{
			stat='blocked';
		}
		var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			alert (this.responseText);
			}
		  };
		  xhttp.open("GET", "../ajax/ajaxstatus.php?userid="+userid+"&&stat="+stat, true);
		  xhttp.send();
		
		
	}
</script>