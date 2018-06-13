<div id="gallery">
<?php
	foreach ($data as $value) { ?>
		<div class="container" id="<?php echo $value['pictId']; ?>">
			<img src="<?php echo $value['file_path']; ?>">
			<div><?php echo $value['username']; ?></div>
			<div><?php echo $value['date_create']; ?></div>
			<div><?php echo $value['likes']; ?></div>
			<div><?php echo $value['dislikes']; ?></div>
		</div>
<?php	}	?>
</div>
<script type="text/javascript" src="/js/gallery.js"></script>
