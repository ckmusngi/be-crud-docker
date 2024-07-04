<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function handleCreate(Request $request) {
        try {
            $request->validate(['email_address' => 'required|email|unique:customers']);

            $customer = Customer::create ([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email_address' => $request->email_address,
                'contact_number' => $request->contact_number,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Item successfully added!',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function handleUpdateById(Request $request, $id) {
        try {

            if (!$request->email_address) {
                throw new Exception('Customer email address is required', 400);    
            }

            $customer = Customer::find($id);
            if (!$customer) {
                throw new Exception('Customer not found!', 404);
            }

            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email_address = $request->email_address;
            $customer->contact_number = $request->contact_number;
            $customer->save();

            return response()->json([
                'status' => 200,
                'message' => 'Customer successfully updated!',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
    public function handleDeleteById(Request $request, $id) {
        try {
            if ($customer = Customer::find($id)) {
                $customer->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Customer successfully deleted!'
                ], 200);
            }

            throw new Exception('Customer not found!', 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function handleGetAll(Request $request) {
        try {
            $customers = Customer::paginate(10);
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function handleGetById(Request $request, $id) {
        try {
            $customer = Customer::find($id);
            if (!$customer){
                throw new Exception('Customer not found', 404);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}
