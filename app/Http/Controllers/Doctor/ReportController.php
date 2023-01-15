<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AppInvoice;
use App\Model\Donate;
use App\Model\Expend;
use App\Model\InvoiceDetails;
use App\Model\Miscellaneous;

class ReportController extends Controller
{
    public function index(){
        $title = "Total";
        $start = '';
        $finish = '';


        $consult_invoice = AppInvoice::select('amount')->get();
        $consult_amount = 0;
        foreach ($consult_invoice as $amount) {
            $consult_amount += $amount->amount;
        }
        $donates = Donate::select('amount')->get();
        $donate_amount = 0;
        foreach ($donates as $amount) {
            $donate_amount += $amount->amount;
        }

        $lab_invoices = InvoiceDetails::select('linetotal')->get();
        $lab_amount = 0;
        foreach ($lab_invoices as $amount) {
            $lab_amount += $amount->linetotal;
        }
        $miscellaneous = Miscellaneous::select('amount')->get();
        $miscellaneous_amount = 0;
        foreach ($miscellaneous as $amount) {
            $miscellaneous_amount += $amount->amount;
        }

        $salary = Expend::where('cost_name_id',1)->select('amount')->get();
        $salary_amount = 0;
        foreach ($salary as $amount) {
            $salary_amount += $amount->amount;
        }

        $diagnostics = Expend::where('cost_name_id',2)->select('amount')->get();
        $diagnostics_amount = 0;
        foreach ($diagnostics as $amount) {
            $diagnostics_amount += $amount->amount;
        }

        $others = Expend::where('cost_name_id',3)->select('amount')->get();
        $others_amount = 0;
        foreach ($others as $amount) {
            $others_amount += $amount->amount;
        }
        return view('view.reports.report', compact('lab_amount','donate_amount','consult_amount','miscellaneous_amount','salary_amount','diagnostics_amount','others_amount','title','start','finish'));
    }

    public function today($date){
        $title = "Today";
        $start = '';
        $finish = '';
        $consult_invoice = AppInvoice::where('created_at', 'LIKE','%'. $date .'%')->get();
        $invoices = Donate::where('created_at', 'LIKE','%'. $date .'%')->get();
        $reports = InvoiceDetails::where('created_at', 'LIKE','%'. $date .'%')->get();
        return view('view.reports.report', compact('reports','donate_amount','consult_amount','title','start','finish'));
    }

    public function yesterday($date){
        $title = "Yesterday";
        $start = '';
        $finish = '';
        $consult_invoice = AppInvoice::where('created_at', 'LIKE','%'. $date .'%')->get();
        $invoices = Donate::where('created_at', 'LIKE','%'. $date .'%')->get();
        $reports = InvoiceDetails::where('created_at', 'LIKE','%'. $date .'%')->get();
        return view('view.reports.report', compact('reports','donate_amount','consult_amount','title','start','finish'));
    }


    public function weekly(){
        $title = "Weekly";
        $start = '';
        $finish = '';
        $consult_invoice = AppInvoice::where('created_at','>', now()->subWeek()->startOfWeek())
                        ->where('created_at','>', now()->subWeek()->endOfWeek())
                        ->get();
        $invoices = Donate::where('created_at','>', now()->subWeek()->startOfWeek())
                        ->where('created_at','>', now()->subWeek()->endOfWeek())
                        ->get();
        $reports = InvoiceDetails::where('created_at','>', now()->subWeek()->startOfWeek())
                        ->where('created_at','>', now()->subWeek()->endOfWeek())
                        ->get();
        return view('view.reports.report', compact('reports','donate_amount','consult_amount','title','start','finish'));
    }

    public function monthly($date){
        $title = "Monthly";
        $start = '';
        $finish = '';
        $consult_invoice = AppInvoice::where('created_at', 'LIKE','%'. $date .'%')->get();
        $invoices = Donate::where('created_at', 'LIKE','%'. $date .'%')->get();
        $reports = InvoiceDetails::where('created_at', 'LIKE','%'. $date .'%')->get();
        return view('view.reports.report', compact('reports','donate_amount','consult_amount','title','start','finish'));
    }

    public function yearly($date){
        $title = "Yearly";
        $start = '';
        $finish = '';
        $consult_invoice = AppInvoice::where('created_at', 'LIKE','%'. $date .'%')->get();
        $invoices = Donate::where('created_at', 'LIKE','%'. $date .'%')->get();
        $reports = InvoiceDetails::where('created_at', 'LIKE','%'. $date .'%')->get();
        return view('view.reports.report', compact('reports','donate_amount','consult_amount','title','start','finish'));
    }

    public function diffDate(Request $request){
        $title = "Custom";
        $start = date('Y-m-d', strtotime($request->start));
        $finish = date('Y-m-d', strtotime($request->finish));

        $consult_invoice = AppInvoice::whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $consult_amount = 0;
        foreach ($consult_invoice as $amount) {
            $consult_amount += $amount->amount;
        }

        $donates = Donate::whereBetween('donate_date', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $donate_amount = 0;
        foreach ($donates as $amount) {
            $donate_amount += $amount->amount;
        }

        $miscellaneous = Miscellaneous::whereBetween('date', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $miscellaneous_amount = 0;
        foreach ($miscellaneous as $amount) {
            $miscellaneous_amount += $amount->amount;
        }

        $lab_invoices = InvoiceDetails::whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])->select('linetotal')->get();
        $lab_amount = 0;
        foreach ($lab_invoices as $amount) {
            $lab_amount += $amount->linetotal;
        }



        $salary = Expend::where('cost_name_id',1)->whereBetween('date', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $salary_amount = 0;
        foreach ($salary as $amount) {
            $salary_amount += $amount->amount;
        }

        $diagnostics = Expend::where('cost_name_id',2)->whereBetween('date', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $diagnostics_amount = 0;
        foreach ($diagnostics as $amount) {
            $diagnostics_amount += $amount->amount;
        }

        $others = Expend::where('cost_name_id',3)->whereBetween('date', [$start." 00:00:00", $finish." 23:59:59"])->select('amount')->get();
        $others_amount = 0;
        foreach ($others as $amount) {
            $others_amount += $amount->amount;
        }

        return view('view.reports.report', compact('lab_amount','donate_amount','consult_amount','miscellaneous_amount','miscellaneous_amount','salary_amount','diagnostics_amount','others_amount','title','start','finish'));
    }
}
