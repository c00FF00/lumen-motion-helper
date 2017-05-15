<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected $statusCode;

    public function getMediaRoot()
    {
    return env('MEDIA_UPLOAD_PATH');
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    
    protected function respondWithSuccess($message)
    {
        return response()->json([
                    'ok' => true,
                    'status_code' => $this->getStatusCode(),
                    'message' => $message
                ]
        );
    }

    protected function respondWithError($message)
    {
        return response()->json([
                    'ok' => false,
                    'status_code' => $this->getStatusCode(),
                    'message' => $message
                ]
        );
    }

    protected function respondWithData($data)
    {
        return response()->json([
            'ok' => true,
            'status_code' => $this->getStatusCode(),
            'data' => $data
        ]);
    }

    public function respondSuccessCreated()
    {
        return $this->setStatusCode('201')->respondWithSuccess('created');
    }

    public function respondSuccessUploaded()
    {
        return $this->setStatusCode('200')->respondWithSuccess('uploaded');
    }

    public function respondSuccessDeleted()
    {
        return $this->setStatusCode('200')->respondWithSuccess('deleted');
    }

    public function respondSuccessData($data)
    {
        return $this->setStatusCode('200')->respondWithData($data);
    }

    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode('404')->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode('500')->respondWithError($message);
    }
    
}
