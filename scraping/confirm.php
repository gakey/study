<?php
/**
* 入力したサイトのURL確認画面
*
*/

require_once __DIR__ .'/common/common.php';
require_once(__DIR__ .'/scrap.php');
require_once(__DIR__ .'/validate.php');

$scrapApp = new \ScrapApp\Scrap();
$scrapApp->setScrapingUrl(escapeChars($_POST['scraping_url']));

$scrapValApp = new \ScrapApp\Validate();
$scrapValApp->checkScrapConfirmError($scrapApp->getScrapingUrl());

$errMes = $scrapValApp->getErrorMessage();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>確認画面</title>
</head>
<?php if (isset($errMes)) : ?>
	<?= $errMes ?>
<?php else : ?>
<form name="submit" action="finish.php" method="POST">
	<table><tbody>
	<tr>
		<td><input type="text" name="scraping_url" value ='<?= escapeDecodeChars($scrapApp->getScrapingUrl()); ?>' readonly="readonly" size="100" /></td>
		<td>のリンクを検索します。</td>
	</tr>
	<tr>
		<td><a href="" onclick="document.back.submit();return false;">入力画面へ戻る</a></td>
		<td align="right"><input type="submit" value ="実行" /></td>
	</tr>
	</tbody></table>
	<input type="hidden" name="page" value="1" />
</form>
<form name="back" action="input.php" method="POST">
	<input type="hidden" name="scraping_url" value="<?= escapeDecodeChars($scrapApp->getScrapingUrl()); ?>" />
</form>
<?php endif; ?>
</html>
