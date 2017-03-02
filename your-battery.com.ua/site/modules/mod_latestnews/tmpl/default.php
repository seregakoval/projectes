<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<ul class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
		<font style="color: #990000;"><?php echo $item->date; ?></font><br /><a style="color: #990000;" href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php echo $item->text; ?></a><br/>
            <font style="color: #000000;font-size:12px;"><?php echo $item->body; ?></font>
	</li>
<?php endforeach; ?>
</ul>