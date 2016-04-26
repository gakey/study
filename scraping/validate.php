<?php

namespace ScrapApp;

require_once __DIR__ .'/common/html.inc';

class Validate {
	private $message;

	public function __construct() {

	}

	public function setErrorMessage($message){
		$this->message = $message;
	}

	public function getErrorMessage(){
		return $this->message;
	}

	public function checkScrapConfirmError($scraping_url) {
		if (!isset($scraping_url)) {
			$this->setErrorMessage(getHtmlError('URLを入力してください。', '入力画面へ戻る'));
		} else {
			$scraping_url = chkUrl($scraping_url);
			if (!$scraping_url) {
				$this->setErrorMessage(getHtmlError('入力されたURLが不正です。', '入力画面へ戻る'));
			}
		}
	}
}
?>