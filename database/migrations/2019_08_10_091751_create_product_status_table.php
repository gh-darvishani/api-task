<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    class CreateProductStatusTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('product_status' , function(Blueprint $table){
                $table->bigIncrements('id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('status');
                
                $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade');
                
                $table->timestamps();
            });
        }
        
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('product_status');
        }
    }
