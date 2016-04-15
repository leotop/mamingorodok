<script src="jquery-1.6.4.min.js"></script>
<script>
	var r=0;
	jQuery(document).ready(function($){
		$("#send").click(function(){
			$.ajax({
				url:"/parser/ajax.php",
				async:false,
				success: function(){
					setTimeout("next()",2000);
					r=0;
				},
				error:function(){
					if(r==3){
						setTimeout("next()",2000);
						r=0;
					}
					setTimeout("next()",2000);
					r++;
				}
			});
		});
	});
	function next(){
		$.ajax({
			url:"/parser/ajax.php",
			async:false,
			success: function(){
				setTimeout("next()",2000);
				r=0;
			},
			error:function(){
				if(r==3){
					setTimeout("next()",2000);
					r=0;
				}
				setTimeout("next()",2000);
				r++;
			}
		});
	}
</script>
<input type="button" id="send" value="poehali">

