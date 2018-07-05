<?php
	if ( isset( $data )) {	?> 
	<script type="text/javascript">
		schnelleReporter(<?php echo "\"".$data."\""; ?>, "/");
	</script>
<?php	}	?>