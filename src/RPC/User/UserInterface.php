<?php

namespace GeminiD\PltCommon\RPC\User;

interface UserInterface
{
    public const NAME = 'UserUserInterface';
    public function ping():bool;


}