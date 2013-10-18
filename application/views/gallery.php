<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>JIRA Attachments Gallery</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Give this app a JIRA URL and an issue number, and it will create a gallery with the issue attachments.">
<meta name="author" content="TupiLabs">
<!-- Le styles -->
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.css'); ?>" />
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap-responsive.css'); ?>" />
	<link rel="stylesheet" href="<?php echo site_url('css/lightbox.css'); ?>" />
<style>
body {
    padding-top: 20px;
    padding-bottom: 40px;
}

/* Custom container */
.container-narrow {
    margin: 0 auto;
    max-width: 700px;
}

.container-narrow>hr {
    margin: 30px 0;
}

/* Main marketing message and sign up button */
.jumbotron {
    margin: 60px 0;
    text-align: center;
}

.jumbotron h1 {
    font-size: 72px;
    line-height: 1;
}

.jumbotron .btn {
    font-size: 21px;
    padding: 14px 24px;
}

/* Supporting marketing content */
.marketing {
    margin: 60px 0;
}

.marketing p+h4 {
    margin-top: 28px;
}
.error-message {
display: block;
}
</style>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Fav and touch icons -->
</head>
<body>
	<div class='container-fluid'>
        <div class="masthead">
            <ul class="nav nav-pills pull-right">
                <li><a href="http://tupilabs.com"><img src="<?php echo site_url('img/tupilabs_mascot.png'); ?>" width="40px" /></a></li>
            </ul>
            <h3 class="muted"><a href="<?php echo site_url('/'); ?>">JIRA Attachments Gallery</a></h3>
        </div>
		<hr>
        <div class='row-fluid'>
        	<div id='grid' class='span12'>
            	<p class='muted'>Attachments gallery for 
            	<a href='<?php echo sprintf("%s/browse/%s", $jiraUrl, $issueNumber); ?>'><?php echo $issueNumber; ?></a></p>
            	<?php $i = 0; ?><script src="<? echo site_url('js/bootstrap-lightbox.js'); ?>"></script>
            	<?php foreach ($imgs as $img): ?>
            		<?php if (isset($img->name) && !empty($img->name)): ?>
            		<div class='span3'>
            			<?php $img_link = sprintf("%s/secure/attachment/%s/%s", $jiraUrl, $img->id, $img->name); ?>
            			<a data-lightbox="<?php echo $issueNumber; ?>" href='<?php echo $img_link; ?>'>
            				<img src="<?php echo $img_link; ?>" />
            			</a>
            		</div>
            			<?php if ($i == 2): ?>
            			<hr class='span12' />
            				<?php $i = 0;?>
            			<?php else: ?>
            				<?php $i = $i + 1; ?>
            			<?php endif; ?>
            		<?php endif; ?>
            	<?php endforeach; ?>
            </div>
        </div>
        <div class="footer">
            <p>&copy; <a href='http://tupilabs.com'>TupiLabs</a></p>
        </div>
    </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<? echo site_url('js/jquery.js'); ?>"></script>
    <script src="<? echo site_url('js/bootstrap.min.js'); ?>"></script>
    <script src="<? echo site_url('js/lightbox-2.6.min.js'); ?>"></script>
</body>
</html>