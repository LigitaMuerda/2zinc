
<style>
	#sczWDy{
		position: fixed;
		bottom: 0;
		right: 0;
		z-index: 100;
	}
</style>

<!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cizWDy" style="z-index:100;position:absolute"></div><div id="sczWDy" style="display:inline"></div><div id="sdzWDy" style="display:none"></div><script type="text/javascript">var sezWDy=document.createElement("script");sezWDy.type="text/javascript";var sezWDys=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/0mn2g4pmbsysa1h337s7ym5dd6/safe-standard.js?ps_h=zWDy&ps_t="+new Date().getTime();setTimeout("sezWDy.src=sezWDys;document.getElementById('sdzWDy').appendChild(sezWDy)",1)</script><noscript><div style="display:inline"><a href="http://www.providesupport.com?messenger=0mn2g4pmbsysa1h337s7ym5dd6">Customer Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>
	function convertCource(direction){
		var btcCource = parseFloat($("#btcCource_BTCe").text());
		var usdValue = parseFloat($("#convertor #cUSD").val());
		var btcValue = parseFloat($("#convertor #cBTC").val());
		var result = 0;

    	switch(direction) {
    		case 'USD-BTC' :
    				result = usdValue / btcCource;
    				$("#convertor #cBTC").val(isNaN(result) ? 0 : result.toFixed(8));
    			break;
    		case 'BTC-USD' :
    				result = btcValue * btcCource;
    				$("#convertor #cUSD").val(isNaN(result) ? 0 : result.toFixed(2));
    			break;
    	}		
	}

	$(document).ready(function(){
		convertCource('USD-BTC');

		$("#convertor #cUSD").on('keyup', function(){
			convertCource('USD-BTC');
		});
		$("#convertor #cBTC").on('keyup', function(){
			convertCource('BTC-USD');
		});
	});
</script>

<div id="calculator_modal" style="display:none;">
	<div class="modal_head">
		<img src="images/calculator_icon.png" alt="calculator_icon">
		<div class="modal_title">
			{$LANG.general_text1}
		</div>
	</div>
	<div id="modal_error"></div>
	<div class="modal_body">
		<div class="invest">
			<ul class="invest_plans_calc">
				<li class="active">
					<div class="invest_percent">7%</div>
					<div class="invest_text">
						{$LANG.general_text2}
					</div>
					<div class="invest_input">
						<input class="invest_input_number" type="number" value="1000" data-percent="7" data-plan="1">
					</div>
					<div class="clear"></div>
				</li>
				<li>
					<div class="invest_percent">110%</div>
					<div class="invest_text">
						{$LANG.general_text2}
					</div>
					<div class="invest_input">
						<input class="invest_input_number" type="number" value="1000" data-percent="110" data-plan="2">
					</div>
					<div class="clear"></div>
				</li>
			</ul> 
		</div>
		<div class="invest_results">
			<div class="results_one">
				{$LANG.general_text3}
			</div>
			<div class="results_two">
				{$LANG.general_text4}
			</div>
		</div>
		<div class="clear"></div>
		<div class="invest_number">
			<div class="number_one" id="number_one">
				$177.59
			</div>
			<div class="number_two" id="number_two">
				$177.59
			</div>
		</div>
		<div class="total">
			{$LANG.general_text5}
		</div>
		<div class="clear"></div>
		<div class="total_number"> 
			<span class="blue"><span id="total_number_1">$1277</span>.</span><span id="total_number_2">59</span>
		</div>
	</div>
	<div class="modal_footer">
		<a href="">
			{$LANG.general_text6}
		</a>
	</div>
</div>