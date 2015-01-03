<?php
namespace cram\response;
class JsonResponse
{

    const DEFAULT_STATUS = 500;
    const DEFAULT_ERROR = 'Sorry, but a problem occurred.';

    const VALIDATION_STATUS = 400;
    const VALIDATION_MESSAGE = 'Sorry, but there was a problem with your input.';

    const UNAUTHORIZED_STATUS = 403;
    const UNAUTHORIZED_MESSAGE = 'Sorry, but you are not authorized to do that.';

    public static function success($data = null)
    {
        return Response::json([
            'error' => null,
            'success' => true,
            'data' => $data,
        ]);
    }

    public static function error($error = null, $status = 500)
    {
        if (!$error) {
            $error = self::DEFAULT_ERROR;
        }
        if (!$status) {
            $status = self::DEFAULT_STATUS;
        }
        return Response::json([
            'error' => is_array($error) ? $error : [$error],
            'success' => false,
            'data' => null,
        ], $status);
    }

    public static function validation($error = null)
    {
        if (!$error) {
            $error = self::VALIDATION_MESSAGE;
        }
        return self::error($error, self::VALIDATION_STATUS);
    }

    public static function unauthorized($error = null)
    {
        if (!$error) {
            $error = self::UNAUTHORIZED_MESSAGE;
        }
        return self::error($error, self::UNAUTHORIZED_STATUS);
    }

}