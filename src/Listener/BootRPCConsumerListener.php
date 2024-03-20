<?php

declare(strict_types=1);

namespace GeminiD\PltCommon\Listener;

use GeminiD\PltCommon\RPC\User\UserInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Stringable\StrCache;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use function Hyperf\Support\env;

#[Listener]
class BootRPCConsumerListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    protected function getConsumer(string $interface, string $host, int $port): array
    {
        $key = strtoupper('RPC_'.StrCache::studly('plt-user','_'));
        $value = env($key);
        if($value){
            [$host,$port] = explode(':',$value);
        }

        return [
            'name' => $interface::NAME,
            'service' => $interface,
            'id' => $interface,
            'protocol' => \Hyperf\RpcMultiplex\Constant::PROTOCOL_DEFAULT,
            'load_balancer' => 'random',
            // 这个消费者要从哪个服务中心获取节点信息，如不配置则不会从服务中心获取节点信息
            'registry' => [
                'protocol' => 'consul',
                'address' => 'http://127.0.0.1:8500',
            ],
            'nodes' => [
                ['host' => $host, 'port' => $port],
            ],
            'options' => [
                'connect_timeout' => 5.0,
                'recv_timeout' => 5.0,
                'settings' => [
                    // 包体最大值，若小于 Server 返回的数据大小，则会抛出异常，故尽量控制包体大小
                    'package_max_length' => 1024 * 1024 * 2,
                ],
                // 重试次数，默认值为 2
                'retry_count' => 2,
                // 重试间隔，毫秒
                'retry_interval' => 100,
                // 多路复用客户端数量
                'client_count' => 4,
                // 心跳间隔 非 numeric 表示不开启心跳
                'heartbeat' => 30,
            ],
        ];


    }

    public function listen(): array
    {
        return [
            BootApplication::class
        ];
    }

    public function process(object $event): void
    {
        $interfaces = [
            UserInterface::class => ['plt-user', 9502]
        ];
        $consumers = [];
        foreach ($interfaces as $interface => [$host, $port]) {
            $consumers[] = $this->getConsumer($interface, $host, $port);
        }
        var_dump($consumers);
    }
}
