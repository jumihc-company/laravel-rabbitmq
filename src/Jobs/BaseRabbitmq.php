<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Rabbitmq\Jobs;

use Jmhc\Support\Utils\Collection;
use Jmhc\Support\Utils\LogHelper;

abstract class BaseRabbitmq extends BaseJob
{
    /**
     * @var Collection
     */
    protected $msg;

    public function __construct(array $msg)
    {
        // 链接名称
        $this->connection = 'rabbitmq';
        // 队列名称
        $this->queue = env('RABBITMQ_QUEUE', 'default');
        // 消息
        $this->msg = new Collection($msg);

        LogHelper::dir('queue')
            ->debug(
                $this->getClassBaseName('.send'),
                $this->msg->toJson(JSON_UNESCAPED_UNICODE)
            );
    }

    /**
     * 获取类名称
     * @param string $name
     * @return string
     */
    public function getClassBaseName(string $name = '')
    {
        return class_basename(get_called_class()) . $name;
    }
}
