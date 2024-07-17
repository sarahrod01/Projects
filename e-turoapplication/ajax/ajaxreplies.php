<?php
	include_once'../class/classdisplay.php';
	$d=new Display();
					
?>
	<form method="POST">
		<div class="d-flex">
				<input type="text" name="cmtid"  hidden value="<?=$_GET['commentid']?>" >
				<input type="text" name="cntid" hidden value="<?=$_GET['contentid']?>">
				<div class="col-md-12"  >
				<div class="box " style="margin-left: 40px; margin-top: 10px;">
					<textarea type="text" id="reply" placeholder="enter your comment..."  class="form-control txt font-size: 10px;"></textarea>
				<?php if (isset($inappropriateMessage)) : ?>
					<p style="color: red; font-size: 14px; margin-top: 10px;"><?= $inappropriateMessage ?></p>
				<?php endif; ?>
				<h1><button type="button" class=" ms-1  inline-btn" onclick="myreply(&quot;<?=$_GET['id']?>&quot;,&quot;<?=$_GET['userid']?>&quot;,&quot;<?=$_GET['contentid']?>&quot;,&quot;<?=$_GET['commentid']?>&quot;)">reply</button></h1>
				</div>	
			</div>	
		</div>
	</form>
	
<style>
.negative-margin2{
		margin-left: -15px;
	}
</style>