<?php

namespace ThowsenMedia\Flattery\HTTP;

class Response {

    public static function make(string $content = '', int $statusCode = 200): self
    {
        $response = new static();
        $response->setContent($content);
        $response->setStatusCode($statusCode);
        return $response;
    }

    public static function json(array $data, int $statusCode = 200): static
    {
        $response = new static();
        $response->setContent(json_encode($data));
        $response->setStatusCode($statusCode);
        $response->setHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function redirect(string $to): static
    {
        $response = new static();
        $response->setHeader('Location', url($to));
        $response->setHeader('Status-code', '303');
        return $response;
    }
    
    public static function redirectBack(): static
    {
        $response = new static();
        $response->setHeader('Location', $_SERVER['HTTP_REFERER']);
        $response->setStatusCode(303);
        return $response;
    }
    
    private array $headers = [];

    private $content;
    
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function back(): static
    {
        $this->setHeader('Location', $_SERVER['HTTP_REFERER']);
        return $this;
    }

    public function setStatusCode(int $code)
    {
        $this->setHeader('Status-code', $code);
        return $this;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function send()
    {
        foreach($this->headers as $key => $value) {
            if ($key == 'Status-code') {
                http_response_code($value);
            }else {
                header($key .': ' .$value);
            }
        }
        
        echo $this->content;
    }

    public function with(string $flashKey, mixed $flashMessage): self
    {
        session()->set('flash.' .$flashKey, $flashMessage);
        return $this;
    }

    public function withMessage(mixed $flashMessage): self
    {
        session()->put('flash.message', $flashMessage);
        return $this;
    }

}