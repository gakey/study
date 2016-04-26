<?php
/**
* 取得したリンク情報の結果画面
*
*/

session_start();
require_once __DIR__ .'/common/html.inc';
require_once __DIR__ .'/common/common.php';
require_once(__DIR__ .'/scrap.php');
require_once(__DIR__ .'/validate.php');
define('PAGE_CNT', 10);

$html = "";

$page = (isset($_POST['page'])) ? htmlspecialchars($_POST['page']) : 1;
$scraping_url = escapeChars($_POST['scraping_url']);
if (!isset($scraping_url)) {
        $html .= getHtmlError('入力されたURLが不正です。', '確認画面へ戻る');
        print ($html);
        exit;
}

$scrapArray = array();
if (isset($_SESSION[$scraping_url]['SCRAPLIST'])) {
	$scrapArray = $_SESSION[$scraping_url]['SCRAPLIST'];
} else {
	$rootHtml = @getHtmlDom($scraping_url);
    if (!$rootHtml) {
        $html .= getHtmlError('入力されたサイトは存在しません。', '確認画面へ戻る');
        print ($html);
        exit;
    } else {
    	$_SESSION[$scraping_url]['GET_TIME'] = date('Y/m/d G:i');
        $linkCount = count($rootHtml->find('body a'));

    	$aIndex = 0;
        for ($i = 0; $i < $linkCount; $i++) {
            $aTag = $rootHtml->find('body a', $i);
            if ($aTag) {
                $aTag_url = $aTag->href;
                $nestHtml = getHtmlDom($aTag_url);

                if ($nestHtml) {
                	$nestHtmlCnt = count($nestHtml->find('title'));
                	if ($nestHtmlCnt > 0) {
                        $aTag_title = $nestHtml->find('title', 0)->plaintext;
                        $scrapArray[$aIndex] = array(
                            'LINK_URL' => $aTag_url,
                            'TITLE' => $aTag_title,
                        );
                        $aIndex++;
                    }
                }

            } else {
                break;
            }
        }
        $_SESSION[$scraping_url]['SCRAPLIST'] = $scrapArray;
    }
    $rootHtml->clear();
}

if (!isset($_COOKIE['PHPSESSID'])) {   // 初めてのアクセスでセッションがない場合
    $_SESSION[$scraping_url]['GET_TIME'] = date('Y/m/d G:i');
}

$linkCount = count($scrapArray);

$_SESSION[$scraping_url]['LAST_PAGE']
    = ($linkCount % PAGE_CNT) ? ceil($linkCount / PAGE_CNT) : ($linkCount / PAGE_CNT);

$start_num = PAGE_CNT * ($page - 1);
$end_num = $start_num + PAGE_CNT;

if ($end_num >= $linkCount) {
	$end_num = $linkCount;
}

$linkArray = array();
for ($i = $start_num; $i < $end_num; $i++) {
    $linkArray[$i] = array(
             'LINK_URL' => $scrapArray[$i]['LINK_URL'],
              'TITLE' => $scrapArray[$i]['TITLE'],
    );
}
$_SESSION[$scraping_url][$page] = $linkArray;

$gettime = $_SESSION[$scraping_url]['GET_TIME'];

$html .=
<<<HTML1_END
<h4>【 $scraping_url 】の取得日時  :  $gettime</h4><br />
HTML1_END;

$protocol  = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$url = $protocol .$_SERVER['HTTP_HOST'] .$_SERVER['SCRIPT_NAME'];

if  ($page > 1) {
    $before_page = $page - 1;
    $html .=
<<<HTML2_END
    <a href="" onclick="document.before.submit();return false;">前の10件へ</a>
    <form name="before" action="finish.php" method="POST">
        <input type="hidden" name="scraping_url" value="$scraping_url" />
        <input type="hidden" name="page" value=$before_page />
    </form>
HTML2_END;
}

if ($page < $_SESSION[$scraping_url]['LAST_PAGE']) {
    $next_page = $page + 1;
    $html .=
<<<HTML3_END
    <a href="" onclick="document.next.submit();return false;">次の10件へ</a>
    <form name="next" action="finish.php" method="POST">
        <input type="hidden" name="scraping_url" value="$scraping_url" />
        <input type="hidden" name="page" value=$next_page />
    </form>
HTML3_END;
}

$html .=
<<<HTML4_END
    <br />
    <table border="1" width="80%" cellspacing="0" cellpadding="5">
    <tbody><tr><th>ページタイトル</th><th>リンクURL</th></tr>
HTML4_END;

foreach ($_SESSION[$scraping_url][$page] as $linkInfo) {
        $aTag_url   = escapeChars($linkInfo['LINK_URL']);
        $aTag_title = escapeChars($linkInfo['TITLE']);
        $html .=
<<<HTML5_END
    <tr><td>$aTag_url</td><td>$aTag_title</td><tr>
HTML5_END;
}

$html .=
<<<HTML6_END
    </tbody></table>
    <br />
HTML6_END;
$html .=
<<<HTML6_END
    <a href="" onclick="document.back.submit();return false;">確認画面へ戻る</a>
HTML6_END;
$html .=
<<<HTML6_END
    <form name="back" action="confirm.php" method="POST">
        <input type="hidden" name="scraping_url" value="$scraping_url" />
    </form>
HTML6_END;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>結果画面</title>
</head>

<?php
print ($html);
?>

</html>