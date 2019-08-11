<?php
    
    use App\Models\ProductStatus;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    
    class ProductStatusTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            DB::table('products')->delete();
            factory(ProductStatus::class , 50)->create();
        }
    }
