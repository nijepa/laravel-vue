<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait StoreFileTrait
{

    /**
     * Upload file and set fle name
     *
     * @param Request $request
     * @param string $dir
     * @return void
     */
    public function uploadFile(Request $request, $dir)
    {
        If ($request->hasFile('doc')) {
            $fileName = time().'.'.$request->doc->getClientOriginalExtension();
            $request->offsetSet('doc_id', $fileName);
            $request->doc->move(public_path($dir), $fileName);
        }
    }
}