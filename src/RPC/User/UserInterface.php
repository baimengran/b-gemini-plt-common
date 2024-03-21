<?php

namespace GeminiD\PltCommon\RPC\User;

use GeminiD\PltCommon\Constant\OAuthType;

interface UserInterface
{
    public const NAME = 'UserUserInterface';

    public function ping(): bool;

    public function firstByCode(string $code, string $appid, int|OAuthType $type = OAuthType::WECHAT_MINI_APP);

}