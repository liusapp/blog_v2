<?php
if (! defined ( 'APP_PATH' ))
	exit ( 'Access denied!' );
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="<?php echo $tplData->get('blog_keywords'); ?>">
<meta name="description" content="<?php echo $tplData->get('search_abouts'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $tplData->get('title'); ?></title>
<!-- Bootstrap -->
<link href="<?php echo $tplData->get('public_context'); ?>/css/bootstrap.min.css"
	type="text/css" rel="stylesheet" />
<script type="text/javascript"
	src="<?php echo $tplData->get('public_context'); ?>/js/jquery1.11.2.min.js"></script>
<script type="text/javascript"
	src="<?php echo $tplData->get('public_context'); ?>/js/bootstrap.min.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="<?php echo $tplData->get('public_context'); ?>/js/html5shiv3.7.2.min.js"></script>
      <script src="<?php echo $tplData->get('public_context'); ?>/js/respond1.4.2.min.js"></script>
<![endif]-->
<link href="<?php echo $tplData->get('blogCsspath'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript"
	src="<?php echo $tplData->get('public_context'); ?>/js/blog.js"></script>
<script type="text/javascript">
var blogInfo=<?php echo $tplData->get('blogInfo'); ?>;// 存储博客的基本信息和登录状态
$(document).ready(function(){
	/*设置导航条初始位置*/
	blogInit(<?php echo $tplData->get('nIndex'); ?>);
})
</script>
</head>
<body>
	<div id="main_div" class="container-fluid">
		<div class="container">
			<div id="blog_header" class="row">
				<div id="touxiang" class="col-md-2">
					<img class="img-thumbnail" src="<?php echo $tplData->get('touxiang_img'); ?>" alt="头像"/>
				</div>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-5">
							<h2 id="blogname"><?php echo $tplData->get('blogname'); ?></h2>
						</div>
					</div>
					<!-- /.row -->
					<div class="row">
						<div class="col-md-7">
							<h3 id="description"><?php echo $tplData->get('description'); ?></h3>
						</div>
					</div>
					<!-- /.row -->
					<div class="row">
						<div class="col-md-10">
							<!-- 导航条 -->
							<div id="main_navbar">
							<a href="<?php echo $tplData->get('blogIndexUrl'); ?>">博客首页</a>
							<a href="<?php echo $tplData->get('blogListUrl'); ?>">文章一览</a>
							<a href="<?php echo $tplData->get('blogTypesUrl'); ?>">文章类别</a>
							<a href="<?php echo $tplData->get('blogArchsUrl'); ?>">文章归档</a>
							<a href="<?php echo $tplData->get('blogLiuyanUrl'); ?>">在线留言</a>
							<a href="<?php echo $tplData->get('blogAboutUrl'); ?>">关于本站</a>
							</div>
						</div>
						<div class="col-md-2 dropdown">
							<button id="user_area" type="button" class="btn btn-default">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								博主登录
							</button>
						</div>
					</div>
					<!-- /.row -->
				</div>
			</div>
			<!-- /#blog_header -->
			<div class="row">
				<div id="blog_center" class="col-md-10"><?php echo $tplData->get('blog_center'); ?></div>
				<!-- 右侧  -->
				<div id="blog_right" class="col-md-2"><?php echo $tplData->get('blog_right'); ?></div>
			</div>
			<div class="row">
			<!-- links -->
				<div class="col-md-12">
					<div class="panel panel-default">
					  <div class="panel-heading">友情链接</div>
					  <div id="blog_links" class="panel-body">
					  <?php echo $tplData->get('links'); ?>
					  </div>
					</div>
				</div>
			</div><!-- end row -->
		</div>
	</div>
	<div class="container-fluid">
		<div class="row" id="blog_footer"><?php echo $tplData->get('blog_bottom'); ?></div>
	</div>
	<!-- go top -->
	<div class="go_top"></div>
</body>
</html>