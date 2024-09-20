<?php

declare(strict_types=1);

namespace Sigmie\Http;

use Adbar\Dot;
use ArrayAccess;
use GuzzleHttp\Psr7\Response;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Sigmie\Http\Contracts\JSONResponse as JSONResponseInterface;

class JSONResponse extends Response implements ArrayAccess, JSONResponseInterface
{
    protected null|Dot $decoded;

    public static function fromPsrResponse(ResponseInterface $responseInterface): static
    {
        return new static(
            $responseInterface->getStatusCode(),
            $responseInterface->getHeaders(),
            $responseInterface->getBody(),
            $responseInterface->getProtocolVersion(),
            $responseInterface->getReasonPhrase()
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->json());
    }

    /**
     * @return string
     */
    public function body()
    {
        return (string) $this->getBody();
    }

    public function json(null|int|string $key = null): int|bool|string|array|null|float
    {
        if (!isset($this->decoded)) {
            $this->decoded = dot(json_decode($this->body(), true));
        }

        return $this->decoded->get($key);
    }

    public function psr(): ResponseInterface
    {
        return $this;
    }

    /**
     * Get a header from the response.
     *
     * @return string
     */
    public function header(string $header)
    {
        return $this->getHeaderLine($header);
    }

    public function failed(): bool
    {
        return $this->serverError() || $this->clientError();
    }

    public function clientError(): bool
    {
        return $this->code() >= 400 && $this->code() < 500;
    }

    public function code(): int
    {
        return (int) $this->getStatusCode();
    }

    public function serverError(): bool
    {
        return $this->code() >= 500;
    }

    /**
     * Determine if the given offset exists.
     */
    public function offsetExists(mixed $offset): bool
    {
        return !is_null($this->json($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  string  $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->json($offset);
    }

    /**
     * Set the value at the given offset.
     *
     * @throws LogicException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }

    /**
     * Unset the value at the given offset.
     *
     * @throws LogicException
     */
    public function offsetUnset($offset): void
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }
}
