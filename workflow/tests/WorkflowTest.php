<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 18:24
 */

namespace JunhaiServer\Workflow;


use Think\Exception;

class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @throws Exceptions\NoFromException
     * @throws Exceptions\NoPlaceException
     * @throws Exceptions\NoToException
     * @throws Exceptions\ErrorTransitionException
     */
    public function testWorkflowServerProviderReturn()
    {
        $subject = new \stdClass();
        $wofkflow = new Workflow([
            'draft',
            'review',
            'rejected',
            'published',
        ],
             [
        'to_review'=> [//过渡名
            'form' => 'draft',//过渡起始状态（位置）
            'to' => 'review',//过渡终点位置
        ],
        'publish'=> [
            'form' => 'review',
            'to' => 'published',
        ],
        'reject'=> [
            'form' => 'review',
            'to' => 'rejected',
        ],
    ],'step'
        );

        $subject->step = 'draft';
        $this->assertObjectHasAttribute('state',$wofkflow);
        $this->assertTrue($wofkflow->can($subject,'to_review'));
        $this->assertFalse($wofkflow->can($subject,'reject'));

        $this->assertEquals('review',$wofkflow->apply($subject,'to_review')->step);


    }
}