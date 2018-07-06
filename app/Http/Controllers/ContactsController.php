<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactsController extends Controller
{
    public function index()
    {

        return view('contacts.index');
    }

    public function confirm(ContactRequest $request)
	{
	    $contact = new Contact($request->all());
	    // // 「お問い合わせ種類（checkbox）」を配列から文字列に
	    // $type = '';
	    // if (isset($request->type)) {
	    //     $type = implode(', ',$request->type);
	    // }

	    return view('contacts.confirm', compact('contact'));
	}

	public function complete(ContactRequest $request)
	{
	    $input = $request->except('action');
	    if ($request->action === '戻る') {
	        return redirect()->action('ContactsController@index')->withInput($input);
	    }


	    // データを保存
	    Contact::create($request->all());

	    // 二重送信防止
	    $request->session()->regenerateToken();

		// 送信メール
	    // \Mail::send(new \App\Mail\Contact([
	    //     'to' => $request->email,
	    //     'to_name' => $request->name,
	    //     'from' => $request->email,
	    //     'from_name' => 'pk.links',
	    //     'subject' => 'お問い合わせありがとうございました。',
	    //     'body' => $request->body
	    // ]));

	    // 受信メール
	    \Mail::send(new \App\Mail\Contact([
	        'to' => 'pk.links2018@gmail.com',
	        'to_name' => $request->name,

	        'from' => $request->email,
	        'from_name' => $request->name,
	        'subject' => 'サイトからのお問い合わせ',
	        'body' => $request->body
	    ], 'from'));

	    return view('contacts.complete');

	}

}