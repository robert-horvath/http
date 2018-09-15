<?php
namespace RHo\Http;

interface ResponseBuilderInterface
{

    function withBody(string $body): ResponseBuilderInterface;

    function withHeader(string $header, string $value): ResponseBuilderInterface;

    function build(): ResponseInterface;
}