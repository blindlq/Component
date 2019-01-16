<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 15:47
 */

namespace JunhaiServer\Workflow;

class Transition
{
    //过渡名
    private $name;
    //过渡起始位置（状态）
    private $froms;
    //过渡终点位置
    private $to;

    /**
     * Transition constructor.
     * @param string $name
     * @param $froms
     * @param $tos
     */
    public function __construct(string $name, $froms, $tos)
    {
        $this->name = $name;
        $this->froms = (array) $froms;
        $this->tos = (array) $tos;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getFroms()
    {
        return $this->froms;
    }

    /**
     * @return array
     */
    public function getTos()
    {
        return $this->tos;
    }


}