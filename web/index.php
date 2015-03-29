<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url_address'])) {
	
	$url = strip_tags(stripslashes((trim($_POST['url_address']))));
	$sitemap = new UAWebChallenge\SitemapGenerator\Generator($url);
	
	try {
		$sitemap->generateXmlFile();
	} catch(Exception $e) {
		$error = $e->getMessage();
	}  
	
	$downloadLink = $sitemap->isGenerated() ? $sitemap->getDownloadLink() : false;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>UWC Sitemap Generator</title>
		<style type="text/css">
			body{
				margin:0;
				padding:0;
				font-family:sans-serif
			}
			
			input{
				width: 100%;
				padding: 10px;
				margin: 10px 0 35px 0;
				border: 1px solid #cbcbcb;
				font-size: 16px
			}			
			input[type=submit]{
				width: 270px;
				background: linear-gradient(to bottom,#22abe9 5%,#36caf0 100%);
				color: #fff;
				cursor: pointer;
				float: right;
			}
			input[type=submit]:hover{ 
				background:linear-gradient(to bottom,#36caf0 5%,#22abe9 100%) 
			}

			.top-text {
				text-align: center;
				border-bottom: 1px solid #dedede;
				padding-bottom: 10px;
				margin-bottom: 50px;
			}
			.container {
				width: 900px;
				margin: 5% auto;
			}
			.left-col {
				float: left;
				width: 600px;
			}			
			.right-col {
				float: left;
				width: 300px;
			}
			.download-link {

			}
		</style>
	</head>
	<body>
		
		<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
			<div class="container">
				<h1 class="top-text">UAWebChallenge Sitemap Generator</h1>

				<label>Please enter your URL address (e.g. example.com):</label>
				<div class="left-col">
					<input name="url_address" placeholder="http://example.com" type="text" value="">
				</div>
				<div class="right-col">
					<input name="submit" type="submit" value="Generate">
				</div>
				<div class="download-link">
					<?php if (isset($error)): ?>
						<div style="color:#ff0000;">Generation error: <?php echo $error; ?></div>
					<?php endif; ?>
					
					<?php if (isset($downloadLink)): ?>
						Sitemap generation is completed. <br>
						Download <a href="<?=$downloadLink;?>">sitemap.xml (1.29Kb)</a>, <a href="#">sitemap.xml.gz (0.32Kb)</a> 
					<?php endif; ?>
				</div>
			
			</div>
		</form>
		
	</body>
</html>