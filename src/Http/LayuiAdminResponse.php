<?php

namespace Moell\LayuiAdmin\Http;

use Illuminate\Http\Response;

trait LayuiAdminResponse
{
    /**
     * 201
     *
     * @author moell<moel91@foxmail.com>
     * @param string $content
     * @return Response
     */
    protected function created($content = '')
    {
        return new Response($content, Response::HTTP_CREATED);
    }

    /**
     * 202
     *
     * @author moell<moel91@foxmail.com>
     * @return Response
     */
    protected function accepted()
    {
        return new Response('', Response::HTTP_ACCEPTED);
    }

    /**
     * 204
     *
     * @author moell<moel91@foxmail.com>
     * @return Response
     */
    protected function noContent()
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * 400
     *
     * @author moell<moel91@foxmail.com>
     * @param $message
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message, array $headers = [], $options = 0)
    {
        return response()->json([
            'message' => $message
        ], Response::HTTP_BAD_REQUEST, $headers, $options);
    }

    /**
     * 401
     *
     * @author moell<moel91@foxmail.com>
     * @param string $message
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorized($message = '', array $headers = [], $options = 0)
    {
        return response()->json([
            'message' => $message ? $message : 'Token Signature could not be verified.'
        ], Response::HTTP_UNAUTHORIZED, $headers, $options);
    }

    /**
     * 403
     *
     * @author moell<moel91@foxmail.com>
     * @param string $message
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbidden($message = '', array $headers = [], $options = 0)
    {
        return response()->json([
            'message' => $message ? $message : 'Insufficient permissions.'
        ], Response::HTTP_FORBIDDEN, $headers, $options);
    }

    /**
     * 422
     *
     * @author moell<moel91@foxmail.com>
     * @param array $errors
     * @param array $headers
     * @param string $message
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unprocesableEtity(array $errors = [], array $headers = [], $message = '', $options = 0)
    {
        return response()->json([
            'message' => $message ? $message : '422 Unprocessable Entity',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY, $headers, $options);
    }

    /**
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message = '成功', array $data = [])
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($message = '失败', array $data = [])
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
            'data' => $data
        ]);
    }
}