<?php
/**
 * Created by PhpStorm.
 * User: KATSU
 * Date: 2017/09/10
 * Time: 20:20
 */

const PAGE_TITLE = 'なろうツール（仮）';

include 'App/Narou.php';

use App\Narou;

$narou = new Narou();

$syosetu_list = $narou->getSyosetuList();

?>
<html>
<head>
    <title><?= PAGE_TITLE ?></title>
</head>
<body>
<h1><?= PAGE_TITLE ?></h1>
<div>
    <?php
    foreach ($syosetu_list as $ncode) {
        $syosetu_info = $narou->getSyosetuInfo($ncode);
        echo "$ncode<br>";
        echo "タイトル：{$syosetu_info['title']}<br>\n";
        //print_r($syosetu_info);
        echo '<a href="impression.php?n=' . $syosetu_info['n_no'] . '">感想一覧を取得</a>';
    }
    ?>
</div>
</body>
</html>
