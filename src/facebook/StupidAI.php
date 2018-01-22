<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 21.
 * Time: 17:11
 */

namespace facebook;

/**
 * Class StupidAI
 * @package facebook
 */
class StupidAI {
    private $data;

    /**
     * StupidAI constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName) {
        $this->data = json_decode(file_get_contents($fileName));
    }

    public function parse(string $input): string {
        $i = rand(0, count($this->data));
        return $this->data[$i]->filename;
    }
}