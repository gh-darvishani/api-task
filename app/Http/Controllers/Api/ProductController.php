<?php
    
    namespace App\Http\Controllers\Api;
    
    use App\Http\Controllers\ApiController;
    use App\Models\Product;
    use App\Transformers\ProductTransformer;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    
    class ProductController extends ApiController
    {
        /**
         * @var ProductTransformer
         */
        private $productTransformer;
        
        /**
         * ProductController constructor.
         *
         * @param ProductTransformer $productTransformer
         */
        public function __construct(
            ProductTransformer $productTransformer
        )
        {
            $this->productTransformer = $productTransformer;
        }
        
        /**
         * list Product
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function listProduct(Request $request)
        {
            $product = Product::with([ 'product_status' ]);
            
            $product->when($request->has('status') , function($q) use ($request){
                /** @var \Illuminate\Database\Eloquent\Builder $q */
                $q->whereHas('product_status' , function($q) use ($request){
                    /** @var \Illuminate\Database\Eloquent\Builder $q */
                    $q->where('status' , $request->status);
                });
            });
            
            $product->when($request->has('name') , function($q) use ($request){
                /** @var \Illuminate\Database\Eloquent\Builder $q */
                $q->where('name' , 'like' , '%' . $request->name . '%');
            });
            
            $product = $product->paginate( $this->limit());
            
            return $this->respondWithPagination($product ,
                $this->productTransformer->transformCollection($product->items())
            );
            
        }
        
        /**
         * Create Product
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            if($this->validation())
            {
                return $this->validation();
            }
            
            /** @var Product $product */
            $product = Product::create([
                'name' => $request->name ,
                'price' => $request->price ,
            ]);
            
            $product->product_status()->insert([
                'product_id' => $product->id ,
                'status' => $request->status ,
            ]);
            
            return $this->responseCreated('Product successfully created');
        }
        
        private function validation()
        {
            
            if(!request()->name || !request()->price || request()->status==null || !in_array(request()->status , [ 0 , 1 ]))
            {
                return $this
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->respondWithError('Parameter failed validation for a product.');
            }
            else
            {
                return false;
            }
        }
        
        /**
         * Update Product
         *
         * @param Request $request
         *
         * @param int     $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request , $id)
        {
            if($this->validation())
            {
                return $this->validation();
            }
            
            $product = Product::find($id);
            
            if(!$product)
            {
                return $this->responseNotFound('Product does not exist.');
            }
            
            /** @var Product $product */
            $product->update([
                'name' => $request->name ,
                'price' => $request->price ,
            ]);
            
            $product->product_status()->update([
                'product_id' => $product->id ,
                'status' => $request->status ,
            ]);
            
            
            return $this->responseCreated('Product successfully updated');
        }
        
        /**
         * delete Product
         *
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $product = Product::find($id);
            
            if(!$product)
            {
                return $this->responseNotFound('Product does not exist.');
            }
            
            $product->delete();
    
            return $this->responseDeteted();
        }
    }
