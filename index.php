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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

<h1><?= PAGE_TITLE ?></h1>
<div class="container-fluid">
    <?php
    foreach ($syosetu_list as $ncode) {
        if (!$ncode) {
            continue;
        }
        list($allcount, $syosetu_info) = $narou->getSyosetuInfo(trim($ncode));
        $narou->putSyosetuInfo($syosetu_info);
    }
    ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
