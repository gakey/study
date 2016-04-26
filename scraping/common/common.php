<?php
    /**
     * 共通機能
     *
     */

    require_once __DIR__ .'/../lib/simple_html_dom.php';

    /**
     * 指定されたページをsimple_html_domで解析する。
     *
     * @param string $url 解析するURL
     *
     * @return array 解析したページのHTMLエレメント情報
     */
function getHtmlDom($url)
{
    if (file_get_html($url, null, null, 0)) {
        $html = file_get_html($url, null, null, 0);
    } else {
        $html = false;
    }
    return $html;
}

    /**
     * URLの入力チェックとエスケープを行う。
     *
     * @param string $url URL
     *
     * @return string $url エスケープしたURL
     */
function chkUrl($url)
{
    if (preg_match('/\Ahttp:\/\//', $url)
		|| preg_match('/\Ahttps:\/\//', $url)) {
        $resultUrl = escapeChars($url);
    } else {
        $resultUrl = false;
    };
    return $resultUrl;
}

    /**
     * 文字列をエスケープする
     *
     * @param string $chars 文字列
     *
     * @return string $escapeChars エスケープした文字列
     */
function escapeChars($chars)
{
	$chars = trim($chars);
    return htmlspecialchars($chars, ENT_QUOTES, 'UTF-8');

}

    /**
     * 文字列のエスケープを解除する
     *
     * @param string $chars 文字列
     *
     * @return string $escapeDecodeChars エスケープ解除した文字列
     */
function escapeDecodeChars($chars)
{
	$chars = trim($chars);
    return htmlspecialchars_decode($chars, ENT_QUOTES);

}

