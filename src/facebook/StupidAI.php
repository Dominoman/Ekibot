<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 21.
 * Time: 17:11
 */

namespace facebook;

use Ds\Set;


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
        $wordSet = new Set();
        $s = explode(" ", $input);
        foreach ($s as $word) {
            if (strlen($word) > 2) {
                $wordSet->add($word);
            }
        }
        $resultSet = new Set();
        foreach ($wordSet as $word) {
            foreach ($this->data as $line) {
                if (strpos($line->text, $word) !== false) {
                    $resultSet->add($line->filename);
                }
            }
        }
        if ($resultSet->count() == 0) {
            return $this->data[rand(0, count($this->data))]->filename;
        }
        return $resultSet->get(rand(0, $resultSet->count() - 1));
    }
}