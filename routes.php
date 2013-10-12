<?php

require __DIR__."/gump.class.php";
$gump = new GUMP();
// app routes
$app->get('/', function () use ($app) {
	$app->log->info("JIRA Attachments '/' route");
	// UI
	$flash = $app->view()->getData('flash');
	$errors = $flash['errors'];
	$app->view()->setData('errors', $errors);
	$app->view()->setData('title', sprintf('TupiLabs | %s', $app->getName()));
	$app->render('index.html');
});

$app->get('/gallery', function() use ($app, $gump) {
	$rules = array(
		'jiraUrl'    => 'required|valid_url|max_len,255|min_len,1',
		'issueNumber'    => 'required|max_len,25|min_len,2'
	);
	$filters = array(
		'jiraUrl'    => 'trim|sanitize_string',
		'issueNumber'    => 'trim|sanitize_string'
	);
	$get = $app->request()->get();
	$get = $gump->sanitize($get);
	$gump->validation_rules($rules);
	$gump->filter_rules($filters);
	$is_valid = $gump->run($get);
	if ($is_valid) {
		$jiraUrl = $app->request()->get('jiraUrl');
		$issueNumber = $app->request()->get('issueNumber');
		$app->log->info("Creating new gallery");
		$uri = sprintf("%s/rest/api/2/issue/%s?expand=changelog", $jiraUrl, $issueNumber);
		$response = \Httpful\Request::get($uri)->send();
		$changelog = (isset($response->body->changelog) ? $response->body->changelog : NULL);
		$imgs = array();
		$to_remove = array();
		if (!is_null($changelog) && isset($changelog->histories)) {
			foreach ($changelog->histories as $log) {
				if (isset($log->items) && !empty($log->items)) {
					foreach ($log->items as $log_item) {
						if ($log_item->field == 'Attachment' && 
							(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $log_item->toString)) || preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $log_item->fromString)) {
							$attachment = new stdClass();
							$attachment->name = $log_item->toString;
							$attachment->id = $log_item->to;
							if (isset($log_item->fromString) && !is_null($log_item->fromString)) {
								$to_remove[] = $log_item->fromString;
							}
							
							$existing_attachment = isset($imgs[$attachment->name]) ? $imgs[$attachment->name] : NULL;
							if (!isset($existing_attachment) || is_null($existing_attachment)) {  
								$imgs[$attachment->name] = $attachment;
							} elseif (((int) $existing_attachment->id) > ((int) $attachment->id)) {
								$imgs[$attachment->name] = $attachment;
							}
						}
					}
				}
			}
			
			// images removed
			foreach ($to_remove as $remove_me) {
				if (isset($imgs[$remove_me])) {
					unset($imgs[$remove_me]);
				}
			}
			
		}
		// UI
		$app->view()->setData('title', sprintf('TupiLabs | %s', $app->getName()));
		$app->view()->setData('imgs', $imgs);
		$app->view()->setData('jiraUrl', $jiraUrl);
		$app->view()->setData('issueNumber', $issueNumber);
		$app->flash('message','Gallery created!');
		$app->render('gallery.html');
	} else {
		$errors = $gump->get_readable_errors(true);
		$app->flash('errors', $errors);
		$app->redirect('/');
	}
});
