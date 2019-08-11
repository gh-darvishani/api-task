<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    
    class Product extends Model
    {
        protected $guarded = [];
        
        public function product_status()
        {
            return $this->hasOne(ProductStatus::class,'product_id');
        }
    }
