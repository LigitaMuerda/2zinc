$(document).ready(function() {
	statsPagination();
	selectList(); 
	heightHtml();
	fileStyle();

	$(".select_invest .btn").click(function(){
		if(!$(this).hasClass("clicked")){
			$(this).addClass("clicked").siblings().removeClass("clicked"); 
			$(".select_invest_list").hide();
			$("#"+$(this).attr("href")).fadeIn();  
			$("input[name='action']").val($(this).attr("href"));
		}
		return false; 
	}); 
});

function selectList(){
	$(".select_list li").click(function(){
		if (!$(this).hasClass("selected")) { 
			$(this).addClass("selected").siblings().removeClass("selected");
			$("input[name='"+$(this).parent().attr("data-name")+"']").val($(this).attr("data-value"));
		};
	}); 
}
function statsPagination(){
	$(".pagination li").click(function(){
		if(!$(this).find("span").hasClass("current")){
			$("#pagpage").val($(this).find("span").attr("data-page"));
			$("#opts").submit();
		}
	});
}

// function heightHtml(){
// 	var heightHtml = $("html").height();
//     $(".page_wrap").css("min-height", heightHtml-300);
// }

function fileStyle(){ 
	var innerHtml = '<span id="fileSelectLink">Attach a transaction Screen Shot file</span><span id="fileSelectExt">+ (JPEG, PNG)</span>'; 

	$("#fileSelectBlock").append('<div id="fileSelectInfo"></div>');
	$("#fileSelectInfo").html(innerHtml);

	$("#fileSelectBlock").on("click", "#fileSelectLink, #fileSelectName, #fileSelectReatach", function(){ 
		$("input[name='wirescreen']").click();
	});
	$("input[name='wirescreen']").change(function(){
		var ext = $(this).val().split(".");
		ext = ext.pop().toLowerCase();
		if(ext == "png" || ext == "jpg" || ext == "jpeg"){
			$("#fileSelectInfo").html('<span id="fileSelectName">'+$(this).val()+'</span><span id="fileSelectReatach">reatach</span>'); 
		}
		else{
			alert("Unsuported extension. Please select image in .png or .jpg (.jpeg)");
			$("#fileSelectInfo").html(innerHtml);
			$(this).val("");
		}
	});
} 
