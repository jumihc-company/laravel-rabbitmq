## 介绍

> 环境变量值参考：[env](docs/ENV.md)
>
> 详细使用说明查看：[README.md](https://github.com/vyuldashev/laravel-queue-rabbitmq/blob/master/README.md)

## 安装

使用以下命令安装：
```
$ composer require jmhc/laravel-rabbitmq
```

## 快速使用

- 配置环境变量
- 启用监听
- 书写业务代码

**启用监听:**
```shell script
php artisan queue:work rabbitmq
```

**业务代码：**
```php
// 任务类
use Jmhc\Rabbitmq\Jobs\BaseRabbitmq;

class CustomJob extends BaseRabbitmq
{
    // 自行实现逻辑
    public function handle()
    {
        // 调用任务时传递的数据为 msg
        // $this->msg->key === 'value';
    }
}

// 调用任务类
CustomJob::dispatch([
    'key' => 'value',
    ...
]);
```
