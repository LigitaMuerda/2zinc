<div class="sidebar">
				<div class="block left_menu">
					<ul class="side_nav">

						<li><a href="/">{ $LANG->general_text7 }}</a></li>
					{if $loggedin}
						<li><a href="/account" class="current">{$LANG.general_text8}</a></li>
					{else}
						<li><a href="/signup" {if $controllers.0 == "signup"}class="active"{/if}>{$LANG.general_text9}</a></li>
					{/if}
						<li><a href="/investment_plans" {if $controllers.0 == "investment_plans"}class="active"{/if}>{$LANG.general_text10}</a></li>
						<li><a href="/security" {if $controllers.0 == "security"}class="active"{/if}>{$LANG.general_text11}</a></li>
						<li><a href="/about" {if $controllers.0 == "about"}class="active"{/if}>{$LANG.general_text12}</a></li>
		                <li style="clear: both; border: 0"></li>
					</ul>

					<a class="support_li" href="/support">{$LANG.general_text13}</a>
					<a class="faq_li" href="/faq">{$LANG.general_text14}</a>
					<div class="clear"></div>
					<!-- <div class="site_lang">
						<img src="/images/globe.png" alt="">
						Website Language
						<a href="">English</a>
					</div> -->
				</div>
				
				<div class="block login_block">
					<p class="h">{$LANG.general_text20}</p>
					<form method="post" id="mainform" action="/login">
						<div class="username">
							<input type="text" name="username" placeholder="{$LANG.general_text21}" class="keyboardInput"
								 {if $loggedin}disabled{/if}>
						</div>
						<div class="password">
							<input type="password" name="password" placeholder="{$LANG.general_text22}" class="keyboardInput"
								 {if $loggedin}disabled{/if}>
						</div>
						<input type="submit" value="{$LANG.general_text23}" {if $loggedin}disabled{/if}>
						<a href="/signup" class="signup_link {if $loggedin}disabled{/if}">{$LANG.general_text24}</a>
					</form>
					<a class="forgot_link" href="/forgot_password">{$LANG.general_text25}</a>
					<!-- <a href="/login?username=demo&password=demo" class="demo_link">TRY DEMO PROFILE FOR FREE</a> -->
					<p class="incog">
						* {$LANG.general_text26} + <span style="color:#f22d2e;">{$LANG.general_text27}</span>
						<img src="/images/ock.png" alt="">
					</p>
				</div>
				<a class="block signup_btn" href="/signup">{$LANG.general_text28}</a>
				<div class="latest_news">
					<div class="h">{$LANG.general_text29} <a href="/news">{$LANG.general_text30}</a></div> 
					{if isset($nonews) && $nonews}
						{$LANG.general_text31}
				    {else}
				        {foreach $newslist as $news}
				        <div class="mini_news">
				        	<hr>
							<div class="h">{$news.news_title}</div>
							<p>{if $news.id == 12}{$news.short_news_text|substr:0:38}{else}{$news.short_news_text|substr:0:140}{/if}</p>
							<span class="date">{$news.news_date}</span>
							<a href="{$CONFIG.DomainAutoDetect}news?newsid={$news.id}" class="read_full">{$LANG.general_text32}</a>
				        </div>
				        {/foreach}
				    {/if}
				    <!--
					<div class="mini_news">
						<hr>
						<div class="h">5th Month Additions</div>
						<p>NEW Affiliate Offer: A lucrative 7.7% from Thursday 7PM until Saturday 7PM as per site time. New SLOTS feature: now we allow over 7 slots.</p>
						<span class="date">21/10/15</span>
						<a href="" class="read_full">Read the full news</a>
					</div>
					<div class="mini_news">
						<hr>
						<div class="h">5th Month Additions</div>
						<p>NEW Affiliate Offer: A lucrative 7.7% from Thursday 7PM until Saturday 7PM as per site time. New SLOTS feature: now we allow over 7 slots.</p>
						<span class="date">21/10/15</span>
						<a href="" class="read_full">Read the full news</a>
					</div>
					<div class="mini_news">
						<hr>
						<div class="h">5th Month Additions</div>
						<p>NEW Affiliate Offer: A lucrative 7.7% from Thursday 7PM until Saturday 7PM as per site time. New SLOTS feature: now we allow over 7 slots.</p>
						<span class="date">21/10/15</span>
						<a href="" class="read_full">Read the full news</a>
					</div> 
					--> 
				</div>
				
				<div class="btc_panel">
					<div class="block_info btc_price">
						<div class="title">BITCOIN PRICE</div>
						<div class="content_list">
							<div class="line">
								<div class="name f_left">BTC-e</div>
								<div class="name_value f_left red">$ <span id="btcCource_BTCe">{$CONFIG.CourceBtcE}</span></div>
								<div class="clear"></div>
							</div>

							<div class="line">
								<div class="name f_left">BitStamp</div>
								<div class="name_value f_left blue">$ <span id="btcCource_BitStamp">{$CONFIG.CourceBitStamp}</span></div>
								<div class="clear"></div>
							</div>
							
							<div class="line">
								<div class="name f_left">OkCoin</div>
								<div class="name_value f_left blue">$ <span id="btcCource_OkCOin">{$CONFIG.CourceOkCoin}</span></div>
								<div class="clear"></div>
							</div>
							
							<div class="line">
								<div class="name f_left">BitFinex</div>
								<div class="name_value f_left blue">$ <span id="btcCource_BitFinex">{$CONFIG.CourceBitFinex}</span></div>
								<div class="clear"></div>
							</div>
						</div>
					</div>

					<div class="block_info btc_convertor">
						<div class="title">Convert Bitcoin</div>
						<div class="content_list" id="convertor">
							<div class="input_line">
								<div class="name_input f_left">USD</div>
								<input type="text" value="1000" name="" id="cUSD" class="f_right">
								<div class="clear"></div>
							</div>
							
							<div class="input_line">
								<div class="name_input f_left">BTC</div>
								<input type="text" value="0" name="" id="cBTC" class="f_right">
								<div class="clear"></div>
							</div>
						</div>
					</div>

					<div class="block_info list_link choose_wall">
						<div class="title">Choose Wallet</div>
						<div class="content_list">
							<div class="line_link">
								<a href="https://blockchain.info" target="_blank" class="">BlockChain.info</a>
							</div>
							
							<div class="line_link">
								<a href="https://copay.io" target="_blank" class="">Copay.io</a> <span class="blue">Privacy choise</span>
							</div>

							<div class="line_link">
								<a href="https://www.circle.com" target="_blank" class="">Circle.com</a> <span class="">User-Frendly</span>
							</div>
						</div>
					</div>

					<div class="block_info list_link buy_sell">
						<div class="title">Buy & sell bitcoin</div>
						<div class="content_list">
							<div class="line_link">
								<a href="https://btc-e.com" target="_blank" class="">BTC-e</a>
							</div>
							
							<div class="line_link">
								<a href="https://localbitcoins.com" target="_blank" class="">LocalBitcoins</a> <span class="blue">Easy Access</span>
							</div>

							<div class="line_link">
								<a href="https://cex.io" target="_blank" class="">CEX.io</a> <span class="">User-Frendly</span>
							</div>
						</div>
					</div>
				</div>

				<div class="get_started">GET STARTED WITH BITCOIN AT <a href="https://bitcoin.org" target="_blank" class="blue">BITCOIN.ORG</a></div>
				<!-- <div id="latest_joined">
					<div class="joined_about">
						<div class="left pull_left">
							<p>
								NickDioo Last Joined
							</p>
							<span>{$stat.activeinvestors}</span>
							<p>
								Investors worldwide
							</p>
						</div>
						<div class="right pull_left">
							<img src="images/joined_icon.png" alt="joined_icon">
						</div>
					</div>
					<div>
						<a href="/signup" class="btn">SIGN UP FOR FREE TODAY</a>
					</div>
				</div> -->
			</div>