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

    /** @var string $_impression_no */
    private $_impression_no;

    /**
     * NarouImpression constructor.
     * @param string $impression_no
     */
    function __construct($impression_no)
    {
        $this->_impression_no = $impression_no;
    }

    public function getImpressionList()
    {
        // ToDo: 実装
        return ['hoge'];
    }
}