<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">*{margin:0;padding:0;border:0;font:inherit;vertical-align:baseline}body{line-height:1;padding:60px;background:#fafafa;font:13px/15px normal Lucida Grande,Verdana,sans-serif}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:'';content:none}table{border-collapse:collapse;border-spacing:0}::selection{background-color:#E13300;color:#fff}::-moz-selection{background-color:#E13300;color:#fff}.container{width:100%;max-width:700px;margin:0 auto;background:#fff;box-shadow:0 0 20px rgba(0,0,0,.2)}.heading{background-color:#b00f08;color:#fff;padding:12px}.heading>h1{font-size:1.3em;padding:0;margin:0;font-weight:400}.content{padding:15px}.footer{padding:12px;background-color:#eee;text-align:center}p+p{margin-top:15px}a:link,a:visited{color:#731217;text-decoration:none}a:active,a:focus,a:hover{color:#b00f08;text-decoration:underline}</style>
</head>
<body>
	<div class="container">
		<div class="heading"><h1><?php echo $heading; ?></h1></div>
		<div class="content">
			<?php echo $message; ?>
		</div>
		<div class="footer"><a href="<?php echo config_item('base_url'); ?>">&laquo; <?php echo config_item('site_name') ?: 'Back'; ?></a></div>
	</div>
</body>
</html>
