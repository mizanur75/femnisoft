<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        // return "index";
        $post_data = array();
        $post_data['total_amount'] = Auth::user()->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['user_id'] = Auth::user()->id;
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = Auth::user()->name;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = Auth::user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'user_id' => $post_data['user_id'],
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'created_at' => now()
            ]);
        // DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = Auth::user()->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = Auth::user()->name;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = Auth::user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'created_at' => now()
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        // echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
                $message = "Transaction is successfully Completed";
                if(Auth::user()->role->name == 'Pharmacy'){
                    return redirect()->route('pharmacy.dashboard')->with('success',$message);
                }elseif(Auth::user()->role->name == 'Doctor'){
                    return redirect()->route('doctor.dashboard')->with('success',$message);
                }elseif (Auth::user()->role->name == 'Pharma') {
                    return redirect()->route('pharma.dashboard')->with('success',$message);
                }else{
                    return redirect()->route('agent.dashboard')->with('success',$message);
                }
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                $message = "validation Fail";
                if(Auth::user()->role->name == 'Pharmacy'){
                    return redirect()->route('pharmacy.dashboard')->with('danger',$message);
                }elseif(Auth::user()->role->name == 'Doctor'){
                    return redirect()->route('doctor.dashboard')->with('danger',$message);
                }elseif (Auth::user()->role->name == 'Pharma') {
                    return redirect()->route('pharma.dashboard')->with('danger',$message);
                }else{
                    return redirect()->route('agent.dashboard')->with('danger',$message);
                }
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
            $message = "Transaction is successfully Completed";
                if(Auth::user()->role->name == 'Pharmacy'){
                    return redirect()->route('pharmacy.dashboard')->with('success',$message);
                }elseif(Auth::user()->role->name == 'Doctor'){
                    return redirect()->route('doctor.dashboard')->with('success',$message);
                }elseif (Auth::user()->role->name == 'Pharma') {
                    return redirect()->route('pharma.dashboard')->with('success',$message);
                }else{
                    return redirect()->route('agent.dashboard')->with('success',$message);
                }

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            $message = "Invalid Transaction";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            $message = "Transaction is Falied";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
            $message = "Transaction is already Successful";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('success',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('success',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('success',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('success',$message);
            }
        } else {
            $message = "Transaction is Invalid";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            $message = "Transaction is Cancel";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
            $message = "Transaction is already Successful";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('success',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('success',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('success',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('success',$message);
            }
        } else {
            $message = "Transaction is Invalid";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);
                    DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
                    $message = "Transaction is successfully Completed";
                    if(Auth::user()->role->name == 'Pharmacy'){
                        return redirect()->route('pharmacy.dashboard')->with('success',$message);
                    }elseif(Auth::user()->role->name == 'Doctor'){
                        return redirect()->route('doctor.dashboard')->with('success',$message);
                    }elseif (Auth::user()->role->name == 'Pharma') {
                        return redirect()->route('pharma.dashboard')->with('success',$message);
                    }else{
                        return redirect()->route('agent.dashboard')->with('success',$message);
                    }
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    $message = "validation Fail";
                    if(Auth::user()->role->name == 'Pharmacy'){
                        return redirect()->route('pharmacy.dashboard')->with('danger',$message);
                    }elseif(Auth::user()->role->name == 'Doctor'){
                        return redirect()->route('doctor.dashboard')->with('danger',$message);
                    }elseif (Auth::user()->role->name == 'Pharma') {
                        return redirect()->route('pharma.dashboard')->with('danger',$message);
                    }else{
                        return redirect()->route('agent.dashboard')->with('danger',$message);
                    }
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.
                DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 1]);
                $message = "Transaction is already successfully Completed";
                if(Auth::user()->role->name == 'Pharmacy'){
                    return redirect()->route('pharmacy.dashboard')->with('success',$message);
                }elseif(Auth::user()->role->name == 'Doctor'){
                    return redirect()->route('doctor.dashboard')->with('success',$message);
                }elseif (Auth::user()->role->name == 'Pharma') {
                    return redirect()->route('pharma.dashboard')->with('success',$message);
                }else{
                    return redirect()->route('agent.dashboard')->with('success',$message);
                }
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                $message = "Invalid Transaction";
                if(Auth::user()->role->name == 'Pharmacy'){
                    return redirect()->route('pharmacy.dashboard')->with('danger',$message);
                }elseif(Auth::user()->role->name == 'Doctor'){
                    return redirect()->route('doctor.dashboard')->with('danger',$message);
                }elseif (Auth::user()->role->name == 'Pharma') {
                    return redirect()->route('pharma.dashboard')->with('danger',$message);
                }else{
                    return redirect()->route('agent.dashboard')->with('danger',$message);
                }
            }
        } else {
            $message = "Invalid Data";
            if(Auth::user()->role->name == 'Pharmacy'){
                return redirect()->route('pharmacy.dashboard')->with('danger',$message);
            }elseif(Auth::user()->role->name == 'Doctor'){
                return redirect()->route('doctor.dashboard')->with('danger',$message);
            }elseif (Auth::user()->role->name == 'Pharma') {
                return redirect()->route('pharma.dashboard')->with('danger',$message);
            }else{
                return redirect()->route('agent.dashboard')->with('danger',$message);
            }
        }
    }

}
