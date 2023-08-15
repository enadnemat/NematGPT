<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use phpDocumentor\Reflection\Types\This;


class ChatGPTController extends Controller
{

    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function ask(Request $request)
    {
        $message = $request->input('prompt');

        $old_messages = Message::select('id', 'content', 'role', 'user_id', 'created_at')
            ->where('user_id', \Auth::user()->id)->get();

        $all_messages = [];

        foreach ($old_messages as $key => $value) {
            $all_messages[] = ['role' => $value['role'], 'content' => $value['content']];
        }
        $all_messages[] = ['role' => 'user', 'content' => $message];


        $response = $this->httpClient->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo-0613',
                'messages' => $all_messages,
            ],
        ]);


        $data = json_decode($response->getBody(), true)['choices'][0]['message']['content'];

        $user_message = Message::create([
            'content' => $message,
            'role' => 'user',
            'user_id' => \Auth::user()->id,
            'chat_id' => null,
        ]);

        $api_message = Message::create([
            'content' => $data,
            'role' => 'assistant',
            'user_id' => \Auth::user()->id,
            'chat_id' => null,
        ]);

        return view('chatgpt.response', ['data' => $data]);
    }

}
