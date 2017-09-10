<?php
/**
 * Created by PhpStorm.
 * User: KATSU
 * Date: 2017/09/10
 * Time: 21:57
 */

namespace App;


class NarouImpression
{
    const IMPRESSION_URL = 'http://novelcom.syosetu.com/impression/list/ncode/';

    /** @var string $_n_no */
    private $_n_no;

    /**
     * NarouImpression constructor.
     * @param string $n_no
     */
    function __construct($n_no)
    {
        $this->_n_no = $n_no;
    }

    public function getImpressionList()
    {
        // ToDo: 実装
        return ['hoge'];
    }
}