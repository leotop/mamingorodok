<html>
<head>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
<script>
	$(document).ready(function () {
		$("form").submit(function () {

			var data1 = $('form #selection1').val();
			var data2 = $('form #selection2').val();

			data = data1 + '-' + data2;
			alert(data);

			return false;
		});
	});
</script>
<form>
	<label> selection 1
		<select name="selection1" id="selection1">
			<option value="aaa">aaa</option>
			<option value="bbb">bbb</option>
			<option value="ccc">ccc</option>
		</select>
	</label>
	<label> selection 2
		<select name="selection2" id="selection2">
			<option value="aaa">aaa</option>
			<option value="bbb">bbb</option>
			<option value="ccc">ccc</option>
		</select>
	</label>
	<input type="submit"/>
</form>

</body>
</html>