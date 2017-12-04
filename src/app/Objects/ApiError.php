<?php
/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 12:41 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class ApiError
{
    use ActionObjects;

    public $category;
    public $description;
    public $http_code;
    public $error_code;
    public $request_id;

    /**
     * ApiError constructor.
     * @param \OpenpayApiError $e
     */
    public function __construct(\OpenpayApiError $e)
    {
        $this->category = $e->getCategory();
        $this->description = __('openpay::errors.'.$e->getErrorCode());
        $this->http_code = $e->getHttpCode();
        $this->error_code = $e->getErrorCode();
        $this->request_id = $e->getRequestId();
    }


}