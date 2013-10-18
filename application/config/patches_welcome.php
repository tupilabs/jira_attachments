<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['search_urls'] = array(
		"Jenkins" => "https://issues.jenkins-ci.org/rest/api/2/search?maxResults=100&jql=status%20in%20(Open%2C%20%22In%20Progress%22%2C%20Reopened)%20AND%20text%20~%20%22%5C%22patches%20welcome%5C%22%22",
		"Apache" => "https://issues.apache.org/jira/rest/api/2/search?maxResults=100&jql=status%20in%20(Open%2C%20%22In%20Progress%22%2C%20Reopened)%20AND%20text%20~%20%22%5C%22patches%20welcome%5C%22%22"
);