<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarsInfo;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customerName' => 'required',
                'contactno' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'user_id' => 'required',
                'modelname' => 'required',
                'insurancename' => 'required',
                'insurancexpdate' => 'required',
                'color' => 'required',
                'purchaseDate' => 'required',
                'comments' => '',
                'images' => 'mimes:jpg,png,jpeg,svg',
                'sellingPrice' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            }

           $file = $request->file('images');
           //dd($file);
           if(!empty($file)){
           $uploadPath = "car-post/images";
           $originalName = $file->getClientOriginalName();
           if($file->move($uploadPath, $originalName)){
            $fileMessage = 'file uploaded successfully';
           }
           }
            

            $post = new CarsInfo();
            $post->user_id = $request->user_id;
            $post->model_name = $request->modelname;
            $post->image = $originalName;
            $post->purchase_date = $request->purchaseDate;
            $post->color = $request->color;
            $post->registered_customer_name = $request->customerName;
            $post->contactno = $request->contactno;
            $post->address = $request->address;
            $post->city = $request->city;
            $post->state = $request->state;
            $post->country = $request->country;
            $post->zipcode = $request->zipcode;
            $post->insurance_name = $request->insurancename;
            $post->insurance_exp_date = $request->insurancexpdate;
            $post->comments = $request->comments;
            $post->selling_price = $request->sellingPrice;
            $post->save();

            $response = [
                'success' => true,
                'message' => 'Post Created Successfully!',
                'fileSuccess' => $fileMessage
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
