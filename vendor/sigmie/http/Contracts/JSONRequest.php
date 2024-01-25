<?php

declare(strict_types=1);

namespace Sigmie\Http\Contracts;

use Psr\Http\Message\RequestInterface;

interface JSONRequest extends RequestInterface
{
    public function body(): null|array;
}
