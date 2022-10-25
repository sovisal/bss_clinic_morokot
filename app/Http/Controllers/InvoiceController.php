<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
			'remark' => $request->remark,
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
			// $this->refresh_invoice_detail($request, $inv->id, true);
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

    public function refresh_invoice_detail($request, $id_prescription = 0, $is_new = false) {
		// Do update the labor detail
		$detail_ids = $request->test_id ?: [];
		$detail_values = [];

		// #1, Bind values from post
		foreach ($detail_ids as $index => $id) {
			$detail_values[$is_new ? $index : $id] = [
				'id'			=> $id,
				'medicine_id' 	=> $request->medicine_id[$index] ?: 0,
				'qty' 			=> $request->qty[$index] ?: 0,
				'upd' 			=> $request->upd[$index] ?: 0,
				'nod' 			=> $request->nod[$index] ?: 0,
				'total' 		=> $request->total[$index] ?: 0,
				'unit' 			=> $request->unit[$index] ?: '',
				'usage_id' 		=> $request->usage_id[$index] ?: 0,
				'usage_times' 	=> [],
				'other' 		=> $request->other[$index] ?: '',
			];
		}

		// #2, Bind time usage values from checkbox
		$time_usage = getParentDataSelection('time_usage');
		foreach ($detail_values as $id => $val) {
			$tmp_usage_time = [];
			foreach ($time_usage as $tm_id => $tm_name) {
				if (
					isset($request->{'time_usage_' .$val['id']. '_' . $tm_id}) || // For edit
					isset($request->{'time_usage_' . $tm_id}[$id]) && $request->{'time_usage_' . $tm_id}[$id] != "OFF" // For create
				) {
					$tmp_usage_time[] = $tm_id;
				}
			}
			$detail_values[$id]['usage_times'] = implode(',', $tmp_usage_time ?: []);
		}

		if ($is_new == false) {
			// #3, Update recoed database
			foreach ($detail_values as $id => $val) {
				PrescriptionDetail::find($id)->update($val);
			}
	
			// #4, Clean old data when clicked on icon trast/delete
			if (sizeof($detail_ids) > 0) {
				$detailToDelete = PrescriptionDetail::where('prescription_id', $id_prescription)->whereNotIn('id', $detail_ids);
				$detailToDelete->delete();
			}
		} else {
			// #5, Insert new data
			foreach ($detail_values as $id => $val) {
				unset($val['id']);
				$val['prescription_id'] = $id_prescription;
				$detail = new PrescriptionDetail;
				$detail->create($val);
			}
		}
	}
}
