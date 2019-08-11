<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    
    class ProductStatus extends Model
    {
        const STATUS_InStock = 1;
        const STATUS_OutOfStock = 0;
        
        const Status = [
            1 => 'In Stock' ,
            0 => 'Out Of Stock' ,
        ];
        
        protected $table = 'product_status';
        protected $guarded = [];
        
        public function getStatusNameAttribute()
        {
            return self::Status[$this->status];
        }
        
    }
