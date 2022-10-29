<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
	public function index()
	{
		$data = [
			'services' => Service::orderBy('name', 'asc')->get(),
		];
		return view('service.index', $data);
	}

	public function create()
	{
		return view('service.create');
	}

	public function store(StoreServiceRequest $request)
	{
		$service = Service::create([
			'name' => $request->name,
			'price' => $request->price,
			'description' => $request->description
		]);

		if ($request->ajax()) {
			return $service;
		} else {
			$url = route('invoice.service.index');
			if ($request->save_opt == 'save_create') {
				$url = route('invoice.service.create');
			}else if($request->save_opt == 'save_edit'){
				$url = route('invoice.service.edit', $service->id);
			}
			return redirect($url)->with('success', __('alert.message.success.crud.create'));
		}
	}

	public function edit(Service $service)
	{
		$data['row'] = $service;
		return view('service.edit', $data);
	}

	public function update(UpdateServiceRequest $request, Service $service)
	{
		$service->update([
			'name' => $request->name,
			'price' => $request->price,
			'description' => $request->description,
		]);
		return redirect()->route('invoice.service.index')->with('success', __('alert.message.success.crud.update'));
	}

	public function destroy(Service $service)
	{
		if ($service->delete()) {
			return back()->with('success', __('alert.message.success.crud.delete'));
		}
		return back()->with('error', __('alert.message.error.crud.delete'));
	}
}
