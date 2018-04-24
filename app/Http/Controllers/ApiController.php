<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use Auth;
use Illuminate\Support\Facades\Schema;

class ApiController extends Controller
{
    //
    public function unitOfMeasurment($table_name)
    {
        $unitOfMeasurment = DB::table($table_name)->select('id','name')->get();
        return Response::json($unitOfMeasurment,200);
    }

    public function apiDropDown($table_name)
    {
        $response = DB::table($table_name)->select('id','name')->get();
        return Response::json($response);
    }

    public function products($table_name,Request $request)
    {
        $query = DB::table($table_name);
        if(Schema::hasTable($table_name))
        {
            $data = $request->except('_token');
            foreach($data as $id => $value) {

                if(Schema::hasColumn($table_name, $id))
                {
                    $query->where($id,$value);

                    }

            }
        }


       $response = $query->get();
       echo Response::json($response,200);
    }


    public function hasColumn($table, $column)
    {
        $schema = $this->connection->getDoctrineSchemaManager();

        return $schema->listTableDetails($table)->hasColumn($column);
    }


   /* public function unitOfMeasurment()
    {
        $unitOfMeasurment = DB::table('unit_of_measurement')->select('id','name')->get();
        echo Response::json($unitOfMeasurment,200);
    }*/

    public function itemAdd(Request $request){

        $name = $request->name;
        DB::table('items')->insert(
            ['name' => $name]
        );
        return Response::json(array('status'=>'success','message'=>'Item add Successful!',  'name'=>$name), 320);
    }

    public function productAdd(Request $request){

        $name = $request->name;
        $item_id = $request->item_id;
        $item_name = $request->item_name;
        $mrp = $request->mrp;
        $stock_quantity = $request->stock_quantity;
        $unit_of_measurement_id = $request->unit_of_measurement_id;
        $unit_of_measurement_name = $request->unit_of_measurement_name;


        $id=DB::table('products')->insertGetId(
            [   'name' => $name,
                'item_id'=> $item_id,
                'item_name' => $item_name,
                'mrp' => $mrp,
                'stock_quantity'=> $stock_quantity,
                'unit_of_measurement_id' => $unit_of_measurement_id,
                'unit_of_measurement_name'=> $unit_of_measurement_name,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
                ]
        );

        DB::table('stocks')->insert(
            [   'item_id'=> $item_id,
                'item_name' => $item_name,
                'product_id'=> $id,
                'product_name' => $name,
                'stock_quantity'=> $stock_quantity,
                'sale_quantity'=> '0.00',
                'remain_quantity'=> $stock_quantity,
                'unit_of_measurement_id' => $unit_of_measurement_id,
                'unit_of_measurement_name'=> $unit_of_measurement_name,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
        return Response::json(array('status'=>'success','message'=>'Product add Successful!',  'last_insert_id' => $id), 320);
    }

    public function stockEdit(Request $request){


        $user = Auth::user();
        echo $user->name;
        $product_id = $request->product_id;
        $sale_quantity = $request->sale_quantity;
        $stock_quantity = $request->stock_quantity;
        $remain_quantity = $stock_quantity - $sale_quantity;
        $unit_of_measurement_id = $request->unit_of_measurement_id;
        $unit_of_measurement_name = $request->unit_of_measurement_name;

        DB::table('stocks')
            ->where('product_id', $product_id)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('stock_quantity' => $stock_quantity,
                'sale_quantity'=> $sale_quantity,
                'remain_quantity' => $remain_quantity,
                'unit_of_measurement_id'=>$unit_of_measurement_id,
                'unit_of_measurement_name'=>$unit_of_measurement_name,
                'updated_at' => \Carbon\Carbon::now()));  // update the record in the DB.

        return Response::json(array('status'=>'success','message'=>'Stock Update Successful!',  'id' => $product_id), 320);
    }


    public function saleAdd(Request $request){

        $sale_date = $request->sale_date;
        $item_id = $request->item_id;
        $item_name = $request->item_name;
        $product_id = $request->product_id;
        $product_name = $request->product_name;
        $unit_price= $request->unit_price;
        $quantity1 = $request->quantity1;
        $unit_of_measurement1 = $request->unit_of_measurement1;
        $total_amount = $request->total_amount;
        if($unit_of_measurement1=='Kilogram')
        {
            $quantity2= $quantity1*1000;
            $unit_of_measurement2 = 'Gram';

        }
        else if($unit_of_measurement1=='Litre')
        {
            $quantity2= $quantity1*1000;
            $unit_of_measurement2 = 'Milliliter';

        }
        else
        {
            $quantity2=  $quantity1;
            $unit_of_measurement2 = $unit_of_measurement1;
        }


        $id=DB::table('sales')->insertGetId(
            [   'sale_date' => $sale_date,
                'item_id'=> $item_id,
                'item_name' => $item_name,
                'product_id' => $product_id,
                'product_name'=> $product_name,
                'unit_price' => $unit_price,
                'quantity1'=> $quantity1,
                'unit_of_measurement1'=> $unit_of_measurement1,
                'quantity2' => $quantity2,
                'unit_of_measurement2'=> $unit_of_measurement2,
                'total_amount'=> $total_amount,
                'created_by'=> Auth::user()->name,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        $response = DB::table('stocks')->select('stock_quantity','sale_quantity','remain_quantity','unit_of_measurement_name')->where('product_id',$product_id)->first();

             if($response->unit_of_measurement_name == 'Kilogram' && $unit_of_measurement1=='Gram'||$response->unit_of_measurement_name == 'Litre' && $unit_of_measurement1=='Milliliter')
             {
                 $sale_quantity = $response->sale_quantity +  $quantity1/1000;

             }
             else if($response->unit_of_measurement_name == 'Gram' && $unit_of_measurement1=='Kilogram'||$response->unit_of_measurement_name == 'Milliliter' && $unit_of_measurement1=='Litre')
             {
                 $sale_quantity = $response->sale_quantity +  $quantity1/(.001);
             }
             else if($response->unit_of_measurement_name == $unit_of_measurement1)
             {
                 $sale_quantity = $response->sale_quantity +  $quantity1;
             }
             else
             {
                 $sale_quantity = $response->sale_quantity +  $quantity2;
             }


             $remain_quantity = $response->stock_quantity - $sale_quantity ;

        DB::table('stocks')
            ->where('product_id', $product_id)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array(
                'sale_quantity'=> $sale_quantity,
                'remain_quantity' => $remain_quantity,
                ));  // update the record in the DB.

        return Response::json(array('status'=>'success','message'=>'Sales add Successful!',  'last_insert_id' => $id), 320);
    }

}
