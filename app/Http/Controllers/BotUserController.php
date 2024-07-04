<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use Milly\Laragram\Types\Message;
use Milly\Laragram\Laragram;
use App\Service\ModmeService;

class BotUserController extends Controller
{
    private ModmeService $modmeService;

    public function __construct(ModmeService $modmeService)
    {
        $this->modmeService = $modmeService;
    }

    public function start_private(Message $message)
    {
        if($message->chat->type == 'private'){
            $chat_id = $message->chat->id;
            $text = $message->text;
            $first_name = $message->from->first_name;

            if(str_contains($text, "/start ")){
                $modme_company_id = explode(" ", $text)[1];

                $bot = BotUser::query()->where('telegram_id', $chat_id)->where('modme_company_id',$modme_company_id)->first();

                if(!$bot){
                    $data = [
                        'telegram_id' => $chat_id,
                        'telegram_name' => $first_name,
                        'modme_company_id' => $modme_company_id
                    ];
                    BotUser::query()->create($data);

                    Laragram::sendMessage(
                        chat_id: $message->chat->id,
                        text: ''
                    );
                }
            }else{
                return "Start company id!";
            }
        }else{
            return Laragram::sendMessage(
                chat_id: $message->chat->id,
                text: 'Bu kunlik Hisobot yuboradigan bot, Faqat Modme bergan Link orqali kirsangiz hisobatlarni kunlik olasiz!'
            );
        }
    }

    public function plan_execution($chat_id, $token, $company_name){
        $data = $this->modmeService->checkCompany($token);
        $branches = $data['data'];

        foreach($branches as $branch){
            Laragram::sendMessage(
                chat_id: $chat_id,
                text: 'Hisobat '.  $company_name . 'mana!    ' . $branch['name'] . " " . $branch['id']
            );
        }
    }
}
