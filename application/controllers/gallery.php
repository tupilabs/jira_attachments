<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'httpful.phar';

class Gallery extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()	{
		$_POST = $_GET;
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('jiraUrl', 'JIRA URL', 'required|xss_clean|trim');
		$this->form_validation->set_rules('issueNumber', 'Issue number', 'required|xss_clean|trim');

		if ($this->form_validation->run()) {
			$jiraUrl = $this->form_validation->set_value('jiraUrl');
			$issueNumber = $this->form_validation->set_value('issueNumber');
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
			$data = array();
			$data['imgs'] = $imgs;
			$data['jiraUrl'] = $jiraUrl;
			$data['issueNumber'] = $issueNumber;
			$this->load->view('gallery', $data);
		} else {
			$data = array();
			$this->load->view('welcome_message', $data);
		}
		/*
			
		*/
	}
}

