<?php
    /**
     * HTML定義
     *
     */

    /**
     * HTMLのエラー部を返却する。
     *
     * @param string $message　エラーメッセージ
     * @param string $backmsg　リンクメッセージ
     *
     * @return string HTML記述
     */
function getHtmlError($message, $linkmsg)
{
    $html = "<table><tbody><tr><td>$message</td></tr></tbody></table><br /><a href=\"javascript:history.back();\">$linkmsg</a>";

    return $html;
}

