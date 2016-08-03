<?php 
//print_r($indv_results);
if($userCounts == 0){
	echo "<h1>Oop's! Their are no users To analyze. </h1>";
}else {
foreach ($indv_results as $user_id  => $indv) { 

?>
	<div style="height: 10px;"></div>
	<div class="panel panel-info" style="width:70%; margin: 0 auto;">
<?php 
	echo '<div class="panel-heading" ><h3>#'.$user_id.'</h3></div>';
	?>
	<div class="media"  style="margin: 10px;">
  			<a class="pull-left" href="#">
    				<img class="media-object" src="<?php echo SF_PLUGIN_URL; ?>/images/head.gif" alt="...">
  			</a>
  		<div class="media-body">
    		<h4 class="media-heading">Created Date: <?php echo $indv[0]['date_created']?><br />Modified Date: <?php echo $indv[0]['date_created']?></h4>
   				<ul class="list-group">
  				<li class="list-group-item">
					<span class="badge descriptive"><h4>Descriptive answer</h4></span>
    					<span class="badge"><h4>Answers</h4></span>
    				<span style="width:60%"><h4>Questions</h4></span>
  					</li>

	<?php 
		foreach ($indv as $qa){ 
			if($qa['extra_ans']=='true')
			{
			$qa['extra_ans']='';
			}
			?>
					<li class="list-group-item">
					<span class="badge descriptive"><?php echo $qa['extra_ans']; ?></span>
    					<span class="badge"><?php echo $qa['answer']; ?></span>
    				<?php echo $qa['question']; ?>
  					</li>
			<?php 
		}
	?>
			</ul>
		</div>
	</div>
	</div>
	<?php 	
	
}
?>
<ul class="pagination">


<?php 
	
$pages = ceil($userCounts/10);
if($pages > 1){
	for($i=1; $i <= $pages ; $i++){
		echo '<li><a href="#" onclick="get_indv_result('.$i.')">'.$i.'</a></li>';
	}
	}
?>
</ul>

<?php 
}
?>
