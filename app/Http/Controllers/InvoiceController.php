<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\DataParent;
use App\Models\Prescription;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\PrescriptionDetail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hello';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['patient'] = Patient::orderBy('name_en', 'asc')->get();
		$data['doctor'] = Doctor::orderBy('name_en', 'asc')->get();
		$data['medicine'] = Medicine::orderBy('name', 'asc')->get();
        $data['gender'] = getParentDataSelection('gender');

        $statement = DB::select("SHOW TABLE STATUS LIKE 'invoices'");
        $data['inv_number'] = "PT-" . str_pad($statement[0]->Auto_increment, 4, '0', STR_PAD_LEFT);
		$data['is_edit'] = false;
		return view('invoice.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
		if ($inv = Invoice::create([
			'inv_date' => $request->inv_date ?: date('Y-m-d H:i:s'),
			'doctor_id' => $request->doctor_id,
			'remark' => $request->remark ?: '',
			'pt_id' => $request->patient_id,
			'pt_code' => $request->pt_code,
			'pt_gender' => $request->pt_gender,
			'pt_age' => $request->pt_age,
			'address_id' => update4LevelAddress($request),
			'exchange_rate' => $request->exchange_rate ?: 4100,
			'total' => 0,
			// 'attribite' => $request->attribite,
			// 'status' => 1,
		])) {
			$this->refresh_invoice_detail($request, $inv->id, true);
            return redirect()->route('invoice.edit', $inv->id)->with('success', 'Data created success');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        if (!$invoice) return;

        $data['row'] = $invoice;
        $data['patient'] = Patient::orderBy('name_en', 'asc')->get();
        $data['doctor'] = Doctor::orderBy('name_en', 'asc')->get();
        $data['medicine'] = Medicine::orderBy('name', 'asc')->get();
        $data['gender'] = getParentDataSelection('gender');
        // $data['prescription_detail'] = $prescription->detail()->get();
        $data['inv_number'] = "PT-" . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
		$data['is_edit'] = true;
		return view('invoice.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
		$request['address_id'] = update4LevelAddress($request);
		$request['doctor_id'] = $request->doctor_id ?? 0;
		if ($invoice->update($request->all())) {
			// $this->refresh_prescriotion_detail($request, $invoice->id);
			return redirect()->route('invoice.index')->with('success', 'Data update success');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function refresh_invoice_detail($request, $parent_id = 0, $is_new = false) {
		$ids = $request->inv_item_id ?: [];
		$detail_values = [];

		// #1, Bind values from post
		foreach ($ids as $index => $id) {
			$detail_values[$is_new ? $index : $id] = [
				'id'			=> $id,
				'service_type' 	=> $request->service_type[$index] ?: '',
				'service_name'  => $request->service_name[$index] ?: '',
				'service_id' 	=> $request->service_id[$index] ?: 0,
				'qty' 			=> $request->qty[$index] ?: 0,
				'price' 		=> $request->price[$index] ?: 0,
				'description'   => $request->description[$index] ?: '',
				'total' 		=> $request->total[$index] ?: 0,
			];
		}

		if ($is_new == false) {
			// #2, Update recoed database
			foreach ($detail_values as $id => $val) {
				InvoiceDetail::find($id)->update($val);
			}
	
			// #3, Clean old data when clicked on icon trast/delete
			if (sizeof($ids) > 0) {
				$detailToDelete = InvoiceDetail::where('invoice_id', $parent_id)->whereNotIn('id', $ids);
				$detailToDelete->delete();
			}
		} else {
			// #4, Insert new data
			foreach ($detail_values as $id => $val) {
				unset($val['id']);
				$val['invoice_id'] = $parent_id;
				InvoiceDetail::create($val);
			}
		}
	}
}
