<?php

namespace KsfSuperglobals;

class Request
{
    public function getPath(): string { return ''; }
    public function getMethod(): string { return 'GET'; }
    public function getQuery(string $key, $default = null) { return $default; }
    public function getJsonBody(): ?array { return null; }
    public function getPostBody(): ?array { return null; }
}