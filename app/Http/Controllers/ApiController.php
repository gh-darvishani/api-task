<?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Response;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    class ApiController extends Controller
    {
        protected $statusCode = Response::HTTP_OK;
        
        public function limit($min = 3 , $max = 50)
        {
            $limit = (int)request()->input('limit') ? : $min;
            
            if($limit > $max)
            {
                $limit = $max;
            }
            
            if($limit < $min)
            {
                $limit = $min;
            }
            
            return $limit;
        }
        
        public function responseNotFound($message = 'Not Found!')
        {
            return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
        }
        
        public function respondWithError($message)
        {
            return $this->respond([
                'error' => [
                    'message' => $message ,
                    'status_code' => $this->getStatusCode() ,
                ] ,
            ]);
        }
        
        public function respond($data , $headers = [])
        {
            return response()->json($data , $this->getStatusCode() , $headers);
        }
        
        /**
         * Gets the value of statusCode.
         *
         * @return mixed
         */
        public function getStatusCode()
        {
            return $this->statusCode;
        }
        
        /**
         * Sets the value of statusCode.
         *
         * @param mixed $statusCode the status code
         *
         * @return self
         */
        protected function setStatusCode($statusCode)
        {
            $this->statusCode = $statusCode;
            return $this;
        }
        
        public function respondInvalidRequest($message = 'Invalid Request!')
        {
            return $this->setStatusCode(422)->respondWithError($message);
        }
        
        public function respondInternalError($message = 'Internal Error')
        {
            return $this->setStatusCode(500)->respondWithError($message);
        }
        
        public function responseCreated($message = '')
        {
            return $this
                ->setStatusCode(Response::HTTP_CREATED)
                ->respond([
                    'message' => $message ,
                ]);
        }
        
        public function responseUpdate($message = '')
        {
            return $this
                ->setStatusCode(Response::HTTP_OK)
                ->respond([
                    'message' => $message ,
                ]);
        }
        
        public function responseDeteted()
        {
            return $this->setStatusCode(Response::HTTP_NO_CONTENT)->respond([]);
        }
        
        public function respondWithMessage($message = 'All is well.')
        {
            return $this->respond([
                'response' => [
                    'message' => $message ,
                    'status_code' => $this->getStatusCode() ,
                ] ,
            ]);
        }
        
        protected function respondWithPagination(LengthAwarePaginator $dataPagination , array $data)
        {
            $data = [
                'items' => $data ,
                'paginator' => [
                    'total_count' => $dataPagination->total() ,
                    'total_pages' => ceil($dataPagination->total() / $dataPagination->perPage()) ,
                    'current_page' => $dataPagination->currentPage() ,
                    'limit' => (int)$dataPagination->perPage() ,
                ] ,
            ];
            return $this->respond($data);
        }
    }
