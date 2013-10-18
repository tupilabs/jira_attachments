<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>JIRA Attachments Gallery</title>
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.css'); ?>" />
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap-responsive.css'); ?>" />
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
</head>
<body>

<div class="container-narrow">
        <div class="masthead">
            <ul class="nav nav-pills pull-right">
                <li><a href="http://tupilabs.com"><img src="<?php echo site_url('img/tupilabs_mascot.png'); ?>" width="40px" /></a></li>
            </ul>
            <h3 class="muted">JIRA Attachments Gallery</h3>
        </div>
		<hr>

      <div class="jumbotron">
        <h1>JIRA Attachments Gallery</h1>
        <p class="lead">Give this app a JIRA URL and an issue number, and it will create a gallery with the issue attachments 
        <a href='http://tupilabs.com/for_you'>for you</a>.</p>
        
        <?php echo validation_errors("<div class='alert'>", "</div>"); ?>
        <form method='get' action="gallery" class='form-horizontal well'>
        	<div class='control-group'>
            	<label class='control-label' for='jiraUrl'>JIRA URL</label>
                <div class='controls'>
                	<input type='text' id='jiraUrl' name='jiraUrl' placeholder='http://issues.project.org/jira' />
                </div>
            </div>
            <div class='control-group'>
                <label class='control-label' for='issueNumber'>Issue number</label>
                <div class='controls'>
                    <input type='text' id='issueNumber' name='issueNumber' placeholder='PRJ-1984' />
                </div>
            </div>
            <div class='form-actions'>
                <input type='submit' value='Create gallery' class='btn btn-primary' />
            </div>
        </form>
      </div>

      <hr/>

      <div class="footer">
        <p>&copy; <a href='http://tupilabs.com'>TupiLabs</a> &mdash; Page rendered in <strong>{elapsed_time}</strong> seconds</p>
      </div>
</body>
</html>