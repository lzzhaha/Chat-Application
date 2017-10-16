<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Chat</title>

<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">

<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link rel="alternate icon" href="assets/i/favicon.ico">
<link rel="stylesheet" href="assets/css/amazeui.min.css">
<link rel="stylesheet" href="assets/css/app.css">

<!-- umeditor css -->
<link href="umeditor/themes/default/css/umeditor.css" rel="stylesheet">

<style>
.title {
	text-align: center;
}

.chat-content-container {
	height: 29rem;
	overflow-y: scroll;
	border: 1px solid silver;
}
</style>
</head>
<body>
	<!-- title start -->
	<div class="title">
		<div class="am-g am-g-fixed">
			<div class="am-u-sm-12">
				<h1 class="am-text-primary">Chat</h1>
			</div>
		</div>
	</div>
	<!-- title end -->

	<!-- chat content start -->
	<div class="chat-content">
		<div class="am-g am-g-fixed chat-content-container">
			<div class="am-u-sm-12">
				<ul id="message-list" class="am-comments-list am-comments-list-flip"></ul>
			</div>
		</div>
	</div>
	<!-- chat content start -->

	<!-- message input start -->
	<div class="message-input am-margin-top">
		<div class="am-g am-g-fixed">
			<div class="am-u-sm-12">
				<form class="am-form">
					<div class="am-form-group">
						<script type="text/plain" id="myEditor"
							style="width: 100%; height: 8rem;"></script>
					</div>
				</form>
			</div>
		</div>
		<div class="am-g am-g-fixed am-margin-top">
			<div class="am-u-sm-6">
				<div id="message-input-nickname"
					class="am-input-group am-input-group-primary">
					<span class="am-input-group-label"><i class="am-icon-user"></i></span>
					<input id="nickname" type="text" class="am-form-field"
						placeholder="Please enter nickname" />
				</div>
			</div>
			<div class="am-u-sm-6">
				<button id="send" type="button" class="am-btn am-btn-primary">
					<i class="am-icon-send"></i> Send
				</button>
			</div>
		</div>
	</div>
	<!-- message input end -->

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="assets/js/jquery.min.js"></script>
	<!--<![endif]-->
	<!--[if lte IE 8 ]>
    <script src="http://labfile.oss.aliyuncs.com/jquery/1.11.1/jquery.min.js"></script>
    <![endif]-->

	<!-- umeditor js -->
	<script charset="utf-8" src="umeditor/umeditor.config.js"></script>
	<script charset="utf-8" src="umeditor/umeditor.min.js"></script>
	<script src="umeditor/lang/zh-cn/zh-cn.js"></script>

	<script>
		$(function() {
			var um = UM.getEditor('myEditor');
			$('#nickname')[0].focus();

			//Create a mew WebSocket Object
			var socket = new WebSocket(
					'ws://${pageContext.request.getServerName()}:${pageContext.request.getServerPort()}${pageContext.request.contextPath}/websocket');

			socket.onmessage = function(event) {
				addMessage(event.data);
			};

			//Actions performed whent the send button is pressed
			$('#send')
					.on(
							'click',
							function() {
								var nick_name = $('#nickname').val();

								if (!um.hasContents()) { //Check whether the editor is empty
									//focus on the editor with shaking effects

									um.focus();
									$('.edui-container').addClass(
											'am-animation-shake');

									//remove shaking effects after 1 second
									setTimeout(
											"$('.edui-container').removeClass('am-animation-shake')",
											1000);

								} else if (nick_name = "") { //Check whether the nick name is empty
									//focus on the nick name box with shaking effects

									$('#nickname')[0].focus();
									$('#message-input-nickname').addClass(
											'am-animation-shake');

									//remove shaking effects after 1 second
									setTimeout(
											"$('#message-input-container').removeClass('am-animation-shake')))",
											1000);

								} else {

									socket.send(JSON.stringify({
										content : um.getContent(),
										nickname : nick_name
									}));

									//empty the messagebox
									um.setContent("");
									um.focus();
								}
							});

			//Append the message to Chat-Content
			function addMessage(message) {

				message = JSON.parse(message);

				var messageItem = '<li class="am-comment'
						+ (message.isSelf ? 'am-comment-flip' : 'am-comment')
						+ '">'
						+ '<a href="javascript:void(0)"><img src="assets/images/'
						+ (message.isSelf ? 'self.png' : 'others.jpg')
						+ '" alt="" class="am-comment-avatar" width="48" height="48"/></a>'
						+ '<div class="am-comment-main"><header class="am-comment-hd"><div class="am-comment-meta">'
						+ '<a href="javascript:void(0)" class="am-comment-author">'
						+ message.nickname + '</a> <time>' + message.date
						+ '</time></div></header>'
						+ '<div class="am-comment-bd">' + message.content
						+ '</div></div></li>';
				$(messageItem).appendTo('#message-list');

				//Scroll to the bottom
				$(".chat-content-container").scrollTop(
						$(".chat-content-container")[0].scrollHeight);
			}
		});
	</script>
</body>
</html>
