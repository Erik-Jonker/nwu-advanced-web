<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getServicesPage()
    {
        return view('services');
    }

    public function renameService(Service $service, Request $request)
    {
        $service->description = $request->description;
        $service->save();
    }

    public function getAllServices()
    {
        return Service::orderBy('created_at','desc')->get();
    }

    public function createService(Request $request)
    {
        Service::firstOrCreate($request->all());
    }

    public function deleteService(Service $service)
    {
        $service->delete();
    }
}

