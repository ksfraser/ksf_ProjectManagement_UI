<?php

namespace KsfSuperglobals;

class Response
{
    public function json(array $data, int $status = 200): void {}
    public function error(string $message, int $status = 500): void {}
    public function notFound(): void {}
    public function methodNotAllowed(): void {}
}