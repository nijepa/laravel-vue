<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait StoreImageTrait
{

    /**
     * Store photo
     *
     * @param Request $request
     * @param $model
     * @param $directory
     * @param $fieldname
     * @return string
     */
    public function savePhoto(Request $request, $directory, $fieldname, $model = '')
    {
        if (strlen($request->$fieldname) > 1000) {

            $currentPhoto = '';
            if ($model !== '') {
                $currentPhoto = $model->$fieldname;
            }

            if($request->$fieldname !== $currentPhoto){

                $name = time().'.' . explode('/',
                        explode(':',
                            substr($request->$fieldname, 0,
                                strpos($request->$fieldname, ';')))[1])[1];

                //$request->$fieldname->move('img/'.$directory.'/' , $name);


                $request->merge([$fieldname => $name]);

                $userPhoto = public_path('img/'.$directory.'/').$currentPhoto;

                if(file_exists($userPhoto)){
                    @unlink($userPhoto);
                }

                return $name;
            }
        }
    }
}