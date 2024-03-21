<?php

namespace GeminiD\PltCommon\RPC\User;

use GeminiD\PltCommon\Constant\OAuthType;
use JetBrains\PhpStorm\ArrayShape;

interface UserInterface
{
    public const NAME = 'UserUserInterface';

    public function ping(): bool;

    #[ArrayShape(['id'=>'int'])]
    public function firstByCode(string $code, string $appid, int|OAuthType $type = OAuthType::WECHAT_MINI_APP):array;

}