<?php

namespace App\Http\Controllers\API;

use App\Events\NewMessage;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * ProductsController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('store',  'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $request->merge(['from' => $user]);

        $message = Message::create([
            'from' => $request->from,
            'to' => $request->contact_id,
            'message' => $request->text
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);
        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
            ->get();
        return response()->json($messages);
        /*$messages = Message::where('from', (int) $id)->where('to', auth()->id())->orWhere('to', $id)->where('from', auth()->id())->get();
        return response()->json($messages);*/
    }
}
