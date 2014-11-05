<script type="text/javascript">
	var strMsg = "<?php echo str_replace(array("\n",'"'),array('\n','\"'),$strMsg)?>";
	if(strMsg != ""){
		alert(strMsg);
	}
	window.location = "<?php echo $strUrl?>";
</script>