<?php

namespace App\Http\Controllers;

use App\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProxyController extends Controller
{
    public function update(Request $request, $id)
    {
        
        $proxy = Proxy::findOrFail($id);

        $this->authorize('update', $proxy);

        if ($request->isMethod('delete')) {
            $proxy->delete();
            return redirect('/')->with('status', 'Прокси удален');
        }
        
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'location' => 'required|max:255',
                'speed' => 'required|max:255',
                'port' => 'required|integer',
                'type' => 'required|max:255',
                'status' => 'required|integer|max:1',
                'on' => 'integer|max:1',
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('proxy-update', ['id' => $proxy->id])->withErrors($validator)->withInput();
            }
            
            // update
            $proxy->fill($data);
            $proxy->update();
            $proxy->on = (isset($data['on']))?$data['on']:0;
            $proxy->save();
            return redirect('/')->with('status', 'Прокси успешно обновлен');
        }

        return view('proxy.update-form', [
            'proxy' => $proxy
        ]);
    }
    
    public function add(Request $request)
    {

        $this->authorize('create', Proxy::class);

        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'location' => 'required|max:255',
                'speed' => 'required|max:255',
                'port' => 'required|integer',
                'type' => 'required|max:255',
                'status' => 'required|integer|max:1',
                'on' => 'integer|max:1',
            ]);

            if ($validator->fails()) {
                return redirect()->route('proxy-add')->withErrors($validator)->withInput();
            }
            
            // save
            $proxy = new Proxy();
            $proxy->ip = $data['ip'];
            $proxy->location = $data['location'];
            $proxy->speed = $data['speed'];
            $proxy->type = $data['type'];
            $proxy->port = $data['port'];
            $proxy->status = 0;
            $proxy->on = (isset($data['on']))?$data['on']:0;
            $proxy->sites = '';
            $proxy->save();

            return redirect('/');
        }
        
        return view('proxy.add');
    }
}
