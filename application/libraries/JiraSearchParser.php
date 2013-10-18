<?php
require_once('SearchParser.php');

if (!defined('BASEPATH')) exit('No direct script access allowed');

class JiraSearchParser implements \PatchesWelcome\SearchParser {

	protected $base_url;

	public function __construct() {

	}

	public function getBaseUrl() {
		return $this->base_url;
	}
	
	public function setBaseUrl($base_url) {
		$this->base_url = $base_url;
	}
	
	/**
	 * @param string $json
	 * @throws Exception if fails to parse the JSON string
	 */
	public function parse($json) {
		$results = array();
		$json_obj = @json_decode($json);

		if (!$json_obj)
			throw new Exception('Failed to parse JSON: ' . $json);

		$issues = $json_obj->issues;
		foreach ($issues as $issue) {
			$result = new \PatchesWelcome\SearchResult();
			$result->setId($issue->key);
			// building URL
			$url = sprintf('%sbrowse/%s', $this->base_url, $issue->key);
			$result->setUrl($url);
			$result->setProject($issue->fields->project->name);
			$result->setCreated($issue->fields->created);
			$result->setType($issue->fields->issuetype->name);
			$result->setTitle($issue->fields->summary);
			$result->setDescription($issue->fields->description);
			$result->setStatus($issue->fields->status->name);
			$results[] = $result;
		}

		return $results;
	}

}
