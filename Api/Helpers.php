<?php

/**
 * Gera Token com liberade de caracteres e quantidade
 */
function Token($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ";
    $mi = "abcdefghijklmnopqrstuvyxwz";
    $nu = "0123456789";
    $si = "@#$%&*+";
    $se = null;

    if ($maiusculas){
        $se .= str_shuffle($ma);
    }

    if ($minusculas){
        $se .= str_shuffle($mi);
    }

    if ($numeros){
        $se .= str_shuffle($nu);
    }

    if ($simbolos){
        $se .= str_shuffle($si);
    }

    return substr(str_shuffle($se),0,$tamanho);
}

/**
 * Normatizar o Metodo PUT & DELETE
 */
function parse_raw_http_request(array &$a_data)
{
    // read incoming data
    $input = file_get_contents('php://input');

    // grab multipart boundary from content type header
    preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
    $boundary = $matches[1];

    // split content by boundary and get rid of last -- element
    $a_blocks = preg_split("/-+$boundary/", $input);
    array_pop($a_blocks);

    // loop data blocks
    foreach ($a_blocks as $id => $block)
    {
        if (empty($block))
            continue;

        // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

        // parse uploaded files
        if (strpos($block, 'application/octet-stream') !== FALSE)
        {
            // match "name", then everything after "stream" (optional) except for prepending newlines
            preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
        }
        // parse all other fields
        else
        {
            // match "name" and optional value in between newline sequences
            preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
        }
        $a_data[$matches[1]] = $matches[2];
    }
}