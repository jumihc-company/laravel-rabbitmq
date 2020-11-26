<?php
/**
 * User: YL
 * Date: 2020/07/01
 */

namespace Jmhc\Rabbitmq;

use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Jmhc\Log\Log;

class JmhcServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 任务失败事件
        Queue::failing(function (JobFailed $event) {
            Log::dir('queue')
                ->name($this->getLogName($event->job, 'failed'))
                ->withDateToName()
                ->withMessageLineBreak()
                ->throwable(
                    $event->exception
                );
        });

        // 任务开始事件
        Queue::before(function (JobProcessing $event) {
            Log::dir('queue')
                ->name($this->getLogName($event->job, 'handle'))
                ->withDateToName()
                ->withMessageLineBreak()
                ->debug(
                    $event->job->getRawBody()
                );
        });
    }

    /**
     * 获取任务名称
     * @param Job $job
     * @param string $name
     * @return string
     */
    protected function getLogName(Job $job, string $name)
    {
        $payload = $job->payload();
        return (! empty($payload['displayName']) ? class_basename($payload['displayName']) . '.' : '') . $name;
    }
}
