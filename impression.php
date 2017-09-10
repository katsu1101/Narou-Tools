<?php
/**
 * Created by PhpStorm.
 * User: KATSU
 * Date: 2017/09/10
 * Time: 21:53
 */

const PAGE_TITLE = 'なろうツール・感想一覧取得';

include 'App/NarouImpression.php';

use App\NarouImpression;

$n_no = $_GET['n'];
$narouImpression = new NarouImpression($n_no);

$impressionList = $narouImpression->getImpressionList();
?>
<html>
<head>
    <title><?= PAGE_TITLE ?></title>
</head>
<body>
<h1><?= PAGE_TITLE ?></h1>
<div>
<?php
foreach ($impressionList as $impression) {
    print_r($impression);
}
?>
</div>
</body>
</html>

