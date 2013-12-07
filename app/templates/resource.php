<?php

namespace Api;

use \Exception;

try {
    // Prevent displaying errors
    ob_start();

    $response = array();
    $min = 0;
    $max = 10;
    $allowedMethods = array('GET');
    $allowedHeaders = array();

    $https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] === 'on';
    $port = intval($_SERVER['SERVER_PORT']);
    $url = 'http' . ($https ? 's' : '') . '://' . $_SERVER['SERVER_NAME']
        . ($https && $port !== 443 || !$https && $port !== 80 ? ":$port" : '')
        . $_SERVER['REQUEST_URI'];

    // Handle OPTIONS method
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Allow: ' . implode(', ', $allowedMethods));
        header('Access-Control-Allow-Methods: ' . implode(', ', $allowedMethods));
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Request-Headers: ' . implode(', ', $allowedHeaders));
        exit();
    }

    // Reject if method is not allowed
    if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
        throw new Exception(
            'Only ' . implode(', ', $allowedMethods)
            . (count($allowedMethods) === 1 ? ' method is' : ' methods are')
            . ' allowed',
            405
        );
    }

    // Get headers and normalize them
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    }
    else {
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (preg_match('/^HTTP_(.*)$/', $name, $matches)) {
                $headers[str_replace('_', '-', $matches[1])] = $value;
            }
        }
    }
    foreach ($headers as $name => $value) {
        unset($headers[$name]);
        $headers[ucwords(strtolower($name))] = $value;
    }

    // Reject if not acceptable
    if (!array_key_exists('Accept', $headers) || $headers['Accept'] !== 'application/json') {
        throw new Exception('Only application/json is acceptable');
    }

    /**
     * -------------------------------------------------------------------------
     * /resource/{id}
     * -------------------------------------------------------------------------
     */
    if (isset($_GET['id'])) {
        if (!preg_match('/^[0-9]+$/', $id = $_GET['id'])) {
            throw new Exception('Resource id must be a positive integer', 400);
        }
        if (($id = intval($id)) < $min || $id > $max) {
            throw new Exception("Resource with id $id does not exist", 404);
        }
        $response = array_merge($response, array(
            'id' => $id,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Sed non risus. Suspendisse lectus tortor, dignissim sit amet,'
                . ' adipiscing nec, ultricies sed, dolor.',
        ));
    }
    /**
     * -------------------------------------------------------------------------
     * /resource
     * -------------------------------------------------------------------------
     */
    else {
        $response['resources'] = array();
        for ($i = $min; $i <= $max; $i++) {
            array_push($response['resources'], array(
                'id' => $i,
                'name' => "Resource $i",
                'href' => preg_match('/\.php$/', $url) ? "$url?id=$i" : "$url/$i",
            ));
        }
    }

    // Catch non-exception errors
    $output = ob_get_clean();
    if ($output !== '') {
        throw new Exception(trim($output), 500);
    }

    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo json_encode($response);
}
catch(Exception $e) {

    $response = array(
        'status' => $e->getCode(),
        'statusText' => null,
        'description' => $e->getMessage(),
        'stack' => $e->getTrace(),
    );

    switch ($response['status']) {
        case 400:
            $response['statusText'] = 'Bad Request';
            break;
        case 404:
            $response['statusText'] = 'Not Found';
            break;
        case 405:
            $response['statusText'] = 'Method Not Allowed';
            break;
        case 405:
            $response['statusText'] = 'Not Acceptable';
            break;
        default:
            $response['statusText'] = 'Internal Server Error';
            $response['status'] = 500;
            break;
    }

    header('HTTP/1.1 ' . $response['status'] . ' ' . $response['statusText']);
    header('Content-Type: application/json');
    echo json_encode($response);
}
