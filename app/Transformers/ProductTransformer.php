<?php
    
    namespace App\Transformers;
    
    class ProductTransformer extends Transformer
    {
        public function transform($item)
        {
            return [
                'id' => $item->id ,
                'name' => $item->name ,
                'price' => $item->price ,
                'status' => $item->product_status->status_name ,
            ];
        }
    }
