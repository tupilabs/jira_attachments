<?php
namespace PatchesWelcome;
if (!defined('BASEPATH')) exit('No direct script access allowed');

interface SearchParser {

	/**
	 * @param string $json
	 * @return \PatchesWelcome\SearchResult[]
	 */
	public function parse($json);

}

class SearchResult {

	protected $project = '';
	protected $id = '0';
	protected $title = '';
	protected $description = '';
	protected $created = '';
	protected $status = '';
	protected $type = '';
	protected $url;

	public function __construct() {}

	public function getProject() {
		return $this->project;
	}

	public function setProject($project) {
		$this->project = $project;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated($created) {
		$this->created = $created;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
	}
	
	public function __toString() {
		return $this->getId();
	}

}
