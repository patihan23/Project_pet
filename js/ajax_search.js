$(function () {
	$("#btnSearch").click(function () {
		$.ajax({
			url: "search1_action.php",
			type: "post",
			data: {name_org: $("#name_org").val()},
			beforeSend: function () {
				$(".loading").show();
			},
			complete: function () {
				$(".loading").hide();
			},
			success: function (data) {
				$("#list-data").html(data);
			}
		});
	});

	$("#searchform").on("keyup keypress",function(e){
		var code = e.keycode || e.which;
		if(code==13){
			$("#btnSearch").click();
			return false;
		}
	});
});

