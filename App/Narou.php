<?php
/**
 * Created by PhpStorm.
 * User: KATSU
 * Date: 2017/09/10
 * Time: 20:28
 */

namespace App;


class Narou
{
    const SYOSETU_URL = 'http://ncode.syosetu.com/';
    const NCODE_LIST_FILE_PATH = __DIR__ . '/../Storage/ncode_list.txt';
    const SYOSETU_INFO_DIR = __DIR__ . '/../Storage/Syosetu/';

    public function getSyosetuList()
    {
        if (file_exists(self::NCODE_LIST_FILE_PATH)) {
            return explode("\n",
                file_get_contents(self::NCODE_LIST_FILE_PATH));
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

        $page = file_get_contents(self::SYOSETU_URL . $ncode);
        $syosetu_info = $this->analysis($page);

        // 保存
        $this->saveSyosetuInfo($syosetu_file_path, $syosetu_info);

        return $syosetu_info;
    }

    private function analysis($page)
    {
        // n6451cr
        // タイトル
        $title = [];
        if (preg_match('(<title>(.*?)<\/title>)', $page, $matches)) {
            // <title>時空魔法で異世界と地球を行ったり来たり</title>
            $title = $matches[1];
        }

        // NNo（感想、レビュー用No）
        $n_no = '';
        if (preg_match('(<li><a href="http://novelcom.syosetu.com/impression/list/ncode/([0-9]*?)/">感想</a></li>)', $page, $matches)) {
            // <li><a href="http://novelcom.syosetu.com/impression/list/ncode/696382/">感想</a></li>
            $n_no = $matches[1];
        }

        // 作者
        $user_id = '';
        $user_name = '';
        if (preg_match('(作者：<a href="http://mypage.syosetu.com/([0-9]*?)/">(.*?)</a>)', $page, $matches)) {
            // 作者：<a href="http://mypage.syosetu.com/11839/">かつ</a>
            $user_id = $matches[1];
            $user_name = $matches[2];
        }

        // あらすじ
        $ex = '';
        if (preg_match('(<div id="novel_ex">(.*?)</div>)s', $page, $matches)) {
            /*
<div id="novel_ex">召喚先の異世界でスキルをもらったけど、王様の態度がムカついたので、お姫様をさらって地球に帰って来ちゃった。<br />
もらったスキルで異世界と地球を行ったり来たりしながら、さらってきたお姫様と妹と３人で楽しく暮らしていきます。<br />
さらに奴隷少女を貰って、二人目の妹にしました。<br />
※２０１７年８月末、３巻が発売されました。<br />
　レーベル：モンスター文庫<br />
　イラスト：DSマイル<br />
　価格：\630</div>
            */
            $ex = $matches[1];
        }

        return [
            'title' => $title,
            'n_no' => $n_no,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'ex' => $ex,
        ];
    }

    /**
     * @param string $syosetu_file_path
     * @param array $syosetu_info
     */
    private function saveSyosetuInfo($syosetu_file_path, $syosetu_info)
    {
        file_put_contents($syosetu_file_path, json_encode($syosetu_info));
    }
}