<?php
/**
 * リンク情報を取得するサイトのURL入力画面
 *
 */

require_once(__DIR__ .'/common/common.php');
require_once(__DIR__ .'/scrap.php');

$scrapApp = new \ScrapApp\Scrap();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>入力画面</title>
</head>
	<form action="confirm.php" method="POST">
		<table>
		<tbody>
			<tr><td width="50">URL:</td><td><input type="text" name="scraping_url" size="100" value='<?= escapeDecodeChars($scrapApp->getScrapingUrl()); ?>' /></td></tr>
			<tr><td></td></tr>
			<tr><td></td><td align="right"><input type="submit" value="確認" /></td></tr>
		</tbody>
		</table>
</form>
</body>
</html>

