<?php

namespace ScrapApp;


class Scrap {
	private $url;

	public function __construct() {

	}

	public function setScrapingUrl($url){
		$this->url = $url;
	}

	public function getScrapingUrl(){
		return $this->url;
	}

	public function getFeedList(){

	}
}
?>