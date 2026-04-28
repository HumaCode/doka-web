<?php

if (!function_exists('jsonSuccess')) {
    function jsonSuccess($message = 'Berhasil', $data = [], $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('jsonError')) {
    function jsonError($message = 'Terjadi kesalahan sistem', $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
