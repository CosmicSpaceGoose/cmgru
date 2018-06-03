<script type="text/javascript">
var arr;
var xhrq = new XMLHttpRequest;
xhrq.onreadystatechange = function(){
	if (xhrq.readyState === 4 && xhrq.status === 200) {
		arr = JSON.parse(xhrq.responseText);
		console.log(arr);
	}
};
xhrq.open('POST', 'php/mysql_get_data.php', true);
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send(JSON.stringify(["*", "users", "email = 'lol@com.ua'"]));	
</script>