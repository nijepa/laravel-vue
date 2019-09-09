<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait StoreFileTrait
{

    /**
     * Upload file and set fle name
     *
     * @param Request $request
     */
    public function uploadFile(Request $request, $dir)
    {
        If ($request->hasFile('doc')) {
            //dd('aa');
            $fileName = time().'.'.$request->doc->getClientOriginalExtension();
            $request->offsetSet('doc_id', $fileName);
            $request->doc->move(public_path($dir), $fileName);
        }
    }
}