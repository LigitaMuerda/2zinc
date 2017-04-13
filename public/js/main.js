$(document).ready(function(){
    heightHtml();
    accordion();
    tabs();
    popup(".calculate"); 
    faqs();
    affiliates();
    calculator();
    mainb();
    
    $("#change_language li:not(.active):not(.inactive)").click(function(){
    	$("#change_language_form [name='lang']").val($(this).attr('data-lang')).parent().submit();
    });

    var columnCount = 3;
    var totalLanguages = $('#all_languages_popup #all_change_language li').length;
    var inactiveLanguages = $('#all_languages_popup #all_change_language .inactive').length;
    var activeLanguages = totalLanguages - inactiveLanguages;
    var langPerColumn = Math.ceil(totalLanguages / columnCount);

	$('#all_languages_popup #all_change_language').append($('#all_languages_popup #all_change_language .inactive'));

    for (var i = 0; i < columnCount; i++) {
    	$('#all_languages_popup #all_change_language').append('<div class="all_change_language_column"></div>');
    	$('#all_languages_popup #all_change_language .all_change_language_column').eq(i).append($('#all_languages_popup #all_change_language li').slice(0, langPerColumn));
    }


    /*$('#all_languages_popup #all_change_language li').each(function(){
	    if($(this).index() > 0){
	        if($(this).next().next().length > 0){
	        	$(this).next().next().insertBefore($(this));
	        }
	    }
	});*/

    $('#show_all_languages').click(function(){   	

    	//$('html').css('overflow', 'hidden');
    	$('#all_change_language_overlay').fadeIn(100);
    	$('#all_languages_popup').fadeIn(200);

    	$('#all_languages_popup').css({
    		'left'		: (($(window).width() - $('#all_languages_popup #all_change_language').width()) / 2) > 0 ? (($(window).width() - $('#all_languages_popup #all_change_language').width()) / 2) : 0 ,
    		'top'		: (($(window).height() - $('#all_languages_popup').height()) / 2) > 0 ? (($(window).height() - $('#all_languages_popup').height()) / 2) : 0,
    		'overflow' 	: (($(window).height() - $('#all_languages_popup').height()) / 2) > 0 ? 'auto' : 'scroll',
    		'height' 	: (($(window).height() - $('#all_languages_popup').height()) / 2) > 0 ? 'auto' : $(window).height()
    	});

    	$('#all_change_language li:not(.active):not(.inactive)').click(function(){
    		$("#change_language_form [name='lang']").val($(this).attr('data-lang')).parent().submit();
    	});

    	$('#all_change_language_overlay, #all_languages_popup_footer #close_button').click(function(){
    		$('#all_change_language_overlay').hide();
    		$('#all_languages_popup').hide();
    		//$('html').css('overflow', 'auto');
    	});
    });

	$("#slider ul").bxSlider({auto:true,mode:"fade",controls:false,speed:1000});

	var client = new ZeroClipboard( document.getElementById("my_referral_link_copy") ); 
	client.on( "ready", function( readyEvent ) { 
	 	client.on( 'copy', function(event) {
          	event.clipboardData.setData('text/plain', document.getElementById("my_referral_link").innerHTML);
        });
	  	client.on( "aftercopy", function( event ) {  
	    	alert("Copied!");
	  	});
	});

	$("a.disabled").click(function(){
		return false;
	});
});

function heightHtml(){
	var heightHtml = $("html").height();
    $(".wrap").css("min-height", heightHtml-82);
}

function popup(button){
	$(button).click(function(){
		$("body").prepend('<div id="popup_overflow"></div>');
		$("#calculator_modal").show();
		return false;
	});
	$("body").on("click", "#popup_overflow", function(){
		$("#popup_overflow").remove();
		$("#calculator_modal").hide();
	}); 
}

function accordion(){
	$(".accordion_block").on("click", ".accordion .title_accordion", function(){ 
		$(this).next(".accordion_text").slideToggle();
	});
}
function tabs(){
	$($(".tab_button.active a").attr("href")).show();

	$(".tab_button").click(function(){ 
		$(".tab_button").removeClass("active");
		$(this).addClass("active");	

		$(".tab_list li").hide();
		$($(this).find("a").attr("href")).fadeIn();	 

		return false;
	});
}



function affiliates() {
	$(".affiliates_list_title .affiliates_list_tab").click(function(){
		if(!$(this).hasClass("active")){
			$(this).addClass("active").siblings().removeClass("active");
			$(".affiliates_list").hide();
			$("#" + $(this).attr("data-list")).fadeIn();
		}
	});
	$(".affiliates_search form").submit(function(){ 
		var searchStr = $.trim($(".affiliates_search form #search_text").val()).toLowerCase();
		var result = [];

		if(searchStr.length >= 2){
			$(".affiliates_list").hide();
			$("#searchaff").fadeIn();			
			$(".affiliates_list_tab").removeClass("active");
		
			$("#allaff li").each(function(){
				var li = $(this).clone();
				if(li.find(".referral_name").text().toLowerCase().search(searchStr) != -1){ 
					var pos = li.find(".referral_name").text().search(searchStr);
					var inits = li.find(".referral_name").text();

					var res = inits.slice(0, -(inits.length-pos)) + '<span class="shighlight">' + searchStr + '</span>' + inits.slice(searchStr.length + pos);
					li.find(".referral_name").html(res);
					 
				} 
				if(li.find(".referral_mail a").text().toLowerCase().search(searchStr) != -1){ 
					var pos = li.find(".referral_mail a").text().search(searchStr);
					var inits = li.find(".referral_mail a").text();

					var res = inits.slice(0, -(inits.length-pos)) + '<span class="shighlight">' + searchStr + '</span>' + inits.slice(searchStr.length + pos);
					li.find(".referral_mail a").html(res);
					 
					result.push(li);
				} 

				if((li.find(".referral_name").text().search(searchStr) != -1) || (li.find(".referral_mail a").text().search(searchStr) != -1))
					result.push(li);
			});
		}


		if(result.length > 0){
			$("#searchaff").html("");
			$.each(result, function(){
				$("#searchaff").append($(this));
			});
		}else{
			$("#searchaff").html('<li style="text-align:center;">No search results</li>');
		}

		return false;
	});
}



function faqs() { 
	$("#faq_search form").submit(function(){ 
		var searchStr = $.trim($("#faq_search form #faq_search_input").val()).toLowerCase();
		var result = [];

		if(searchStr.length >= 2){
			$(".tab_list li").hide();
			$("#faq_search_result").fadeIn();			
			$(".faq_menu .tab_button").removeClass("active");
		
			$(".tab_list .accordion").each(function(){
				var block = $(this).clone();
				if($.trim(block.find(".title_accordion").text().toLowerCase()).search(searchStr) != -1){ 
					var inits = $.trim(block.find(".title_accordion").text());
					var pos = inits.toLowerCase().search(searchStr);

					var res = inits.slice(0, -(inits.length-pos)) + '<span class="shighlight">' + inits.slice(pos, pos+(searchStr.length)) + '</span>' + inits.slice(searchStr.length + pos);
					block.find(".title_accordion").html(res);
					 
 					result.push(block);
				} 
				if($.trim(block.find(".accordion_text").text().toLowerCase()).search(searchStr) != -1){ 
					var inits = $.trim(block.find(".accordion_text").text());
					var pos = inits.toLowerCase().search(searchStr);

					var res = inits.slice(0, -(inits.length-pos)) + '<span class="shighlight">' + inits.slice(pos, pos+(searchStr.length)) + '</span>' + inits.slice(searchStr.length + pos);
					block.find(".accordion_text").html(res);
					 
					result.push(block);
				}  
			});
		} 
 
		if(result.length > 0){
			$("#faq_search_result").fadeIn().find(".accordion_block").html("");
			$.each(result, function(){
				$("#faq_search_result > .accordion_block").append($(this));
			});
			$("#faq_search_result .accordion_text").show();
		}else{
			$("#faq_search_result > .accordion_block").html('<p style="text-align:center;">No search results</p>');
		}

		return false;
	}); 

	$(".tab_button").click(function(){
		$("#faq_search_result").hide().find(".accordion_block").html("");
	});
}
function calculator(){
	function calculate(){
		var invest = parseInt($.trim($(".invest_plans_calc > li.active .invest_input_number").val()));
		var percent = parseInt($.trim($(".invest_plans_calc > li.active .invest_input_number").data("percent"))) / 100;
		var plan = parseInt($.trim($(".invest_plans_calc > li.active .invest_input_number").data("plan")));
		$(".modal_footer a").css('margin-top', 40);

		if(invest != NaN && invest >= 25 && ((invest <= 250000 && plan == 1) || (invest <= 10000 && plan == 2))){
			var daily /*= percent * invest*/;
			var montly /*= daily * 22*/;
			var total /*= daily * 10*/; 

			if(plan == 1){
				$(".modal_body .results_two").text('Monthly Profit');
				daily = percent * invest; 
				montly = daily * 22;
				total = daily * 22 - invest;
			}
			if(plan == 2){
				$(".modal_body .results_two").text('Weekly Profit');
				daily = percent * invest / 7;
				montly = percent * invest;
				total = percent * invest - invest;
			}



			total = total.toFixed(2).toString().split(".");
			$("#number_one").text(daily.toFixed(2));
			$("#number_two").text(montly.toFixed(2));
			$("#total_number_1").text(total[0]);
			$("#total_number_2").text(total[1]);
			$("#modal_error").text("");
		}else{
			$("#number_one").text(0); 
			$("#number_two").text(0);
			$("#total_number_1").text(0);
			$("#total_number_2").text(0);
		}
		if (invest < 25) {
			$("#modal_error").text("Error! Minimum amount 25$");
			$(".modal_footer a").css('margin-top', 26);
		}; 
		if (invest > 250000 && plan == 1) {
			$("#modal_error").text("Error! Maximum amount 250000$");
			$(".modal_footer a").css('margin-top', 26);
		}
		if (invest > 10000 && plan == 2) {
			$("#modal_error").text("Error! Maximum amount 10000$");
			$(".modal_footer a").css('margin-top', 26);
		}
	}
	calculate();
	$(".invest_plans_calc > li").click(function(){
		if(!$(this).hasClass("active")){
			$(this).addClass("active").siblings().removeClass("active");
			calculate();
		}
	});
	$(".invest_input_number").change(function(){
		calculate();
	});
	$(".invest_input_number").bind('keyup',function(){
		calculate();
	}); 
}

function mainb(){
	$("#stats_block_btn").click(function(){
		if(!$("#stats_block").hasClass("opened")){
			$(this).find("i").removeClass("fa-chevron-left").addClass("fa-chevron-right");
			$("#stats_block").animate({
				right: 0
			},200,function(){
				$(this).addClass("opened");
			});
		}else{ 
			$(this).find("i").removeClass("fa-chevron-right").addClass("fa-chevron-left");
			$("#stats_block").animate({
				right: -200
			},200,function(){
				$(this).removeClass("opened");
			});
		}
	});

	$("#left_side_btn").click(function(){
		if(!$("#left_side").hasClass("opened")){
			$(this).find("i").removeClass("fa-chevron-right").addClass("fa-chevron-left");
			$("#left_side").animate({
				left: 0
			},200,function(){
				$(this).addClass("opened");
			});
		}else{ 
			$(this).find("i").removeClass("fa-chevron-left").addClass("fa-chevron-right");
			$("#left_side").animate({
				left: -200
			},200,function(){
				$(this).removeClass("opened");
			});
		}
	});
}

$(function(){ 
	if($("#slide_text").length > 0)
		$('#slide_text').marquee({
		    //speed in milliseconds of the marquee
		    duration: 15000,
		    //gap in pixels between the tickers
		    gap: 50,
		    //time in milliseconds before the marquee will start animating
		    delayBeforeStart: 0,
		    //'left' or 'right'
		    direction: 'left',
		    //true or false - should the marquee be duplicated to show an effect of continues flow
		    duplicated: true
		});
}); 