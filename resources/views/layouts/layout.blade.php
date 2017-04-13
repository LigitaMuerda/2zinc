<!doctype html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="" lang="en"> <!--<![endif]-->
<head>
	<!--[if lte IE 8]>
	<script src="{{ asset('/js/libs/html5.js') }}"></script>
	<link rel="stylesheet" href="css/ie7-8.css">
	<![endif]-->

	<!--[if lte IE 7]>
	<link rel="stylesheet" href="{{ asset('/css/ie7.css') }}">
	<![endif]-->

	<meta charset="utf-8">
	
	<title>Zinc7 </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon" />
 @include ('external.includes.css')
 @include ('external.includes.js')
	
</head> 
<body>
@include ('external.sections.before_header')

<div class="page_wrap account_bg">
		@include ('external.sections.lang_block')
		@include ('external.sections.header')
		@include ('external.sections.top_line_full')
		
		<div class="page">
		@include ('external.sections.sidebar')

{literal}
<script>
	$("#mainform").submit(function(){
		if ($.trim($("#mainform [name='username']").val())=='') {
			alert("{/literal}{$LANG.login_text6}{literal}");
			$("#mainform [name='username']").focus();
			return false;
		}
		if ($.trim($("#mainform [name='password']").val())=='') {
			alert("{/literal}{$LANG.login_text7}{literal}");
			$("#mainform [name='password']").focus();
			return false;
		}
	}); 
</script>
{/literal}