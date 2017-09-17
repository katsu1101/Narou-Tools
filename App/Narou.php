<?php
/**
 * Created by PhpStorm.
 * User: KATSU
 * Date: 2017/09/10
 * Time: 20:28
 */

namespace App;

include_once 'const.php';

class Narou
{
    const SYOSETU_URL = 'http://ncode.syosetu.com/';
    const IMPRESSION_LIST_URL = 'http://novelcom.syosetu.com/impression/list/ncode/';
    const NOVEL_REVIEW_LIST_URL = 'http://novelcom.syosetu.com/novelreview/list/ncode/';
    const NAROU_API = 'http://api.syosetu.com/novelapi/api/';
    const NCODE_LIST_FILE_PATH = HOME_DIR . '/Storage/ncode_list.txt';
    const SYOSETU_INFO_DIR = HOME_DIR . '/Storage/Syosetu/';

    public function getSyosetuList()
    {
        if (file_exists(self::NCODE_LIST_FILE_PATH)) {
            return explode("\n",
                trim(file_get_contents(self::NCODE_LIST_FILE_PATH)));
        } else {
            return [];
        }
    }

    /**
     * 小説情報が保存されていれば取得
     * 保存されていなければ、サイトにアクセスして取得してきて、保存
     * @param string $ncode
     * @return array|null
     */
    public function getSyosetuInfo($ncode)
    {
        $syosetu_file_path = self::SYOSETU_INFO_DIR . $ncode . '.json';

        if (file_exists($syosetu_file_path)) {
            // 小説情報が保存されているので、読み込んで返す
            return json_decode(file_get_contents($syosetu_file_path), true);
        }

        // データが保存されていないのでサイトにアクセスして取得してくる。
        $page = file_get_contents(self::NAROU_API . '?out=json&ncode=' . $ncode);

        // 保存
        file_put_contents($syosetu_file_path, $page);

        return json_decode($page, true);
    }

    /**
     * Nコードから感想ページ用のNコード（数値）に変換する
     * @param string $ncode Nコード「N[%d]{4}[a-z]{2}」
     * @return int 数値のNコード。ただしNコードの形式が正しくない場合は０を返す
     */
    public static function getImpressionNo($ncode)
    {
        $n1 = substr($ncode, 1, 4);
        $n2 = substr($ncode, 5, 1);
        $n3 = substr($ncode, 6, 1);

        if (empty($n1) || empty($n2) || empty($n3)) {
            return 0;
        }

        return intval($n1) + ((ord($n2) - ord('A')) * 26 * 9999)
            + ((ord($n3) - ord('A')) * 9999);
    }

    public function putSyosetuInfo($syosetu_info)
    {
        $impression_no = self::getImpressionNo($syosetu_info['ncode']);
        ?>
        <table class="table">
            <tr>
                <th>Nコード</th>
                <td><?= $syosetu_info['ncode'] ?></td>
            </tr>
            <tr>
                <th>小説名</th>
                <td><?= $syosetu_info['title'] ?></td>
            </tr>
            <tr>
                <th>作者名</th>
                <td><?= $syosetu_info['writer'] ?>(<?= $syosetu_info['userid'] ?>)</td>
            </tr>
            <tr>
                <th>小説のあらすじ</th>
                <td>
                    <pre><?= $syosetu_info['story'] ?></pre>
                </td>
            </tr>
            <tr>
                <th>感想ページ</th>
                <td>
                    <a href="<?= self::IMPRESSION_LIST_URL . $impression_no ?>" target="_blank">
                        感想ページ
                    </a>
                </td>
            </tr>
            <tr>
                <th>レビューページ</th>
                <td>
                    <a href="<?= self::NOVEL_REVIEW_LIST_URL . $impression_no ?>" target="_blank">
                        レビューページ
                    </a>
                </td>
            </tr>
            <tr>
                <th>キーワード</th>
                <td><?= $syosetu_info['keyword'] ?></td>
            </tr>
        </table>
        <?php
    }
}