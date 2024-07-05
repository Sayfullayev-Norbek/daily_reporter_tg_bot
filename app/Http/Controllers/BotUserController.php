<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Company;
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

                $company = Company::query()->where('')->where('modme_company_id',$modme_company_id)->first();
                
                if($company){
                    $bot = BotUser::query()->where('telegram_id', $chat_id)->where('modme_company_id',$modme_company_id)->first();

                    if(!$bot){
                        $data = [
                            'telegram_id' => $chat_id,
                            'telegram_name' => $first_name,
                            'modme_company_id' => $modme_company_id
                        ];

                        BotUser::query()->create($data);
                    }
                    Laragram::sendMessage(
                        chat_id: $message->chat->id,
                        text: 'Tabriklayman! Siz har kuni soat 21:00 da hisobatizni yuborib turmamiz'
                    );
                }else{
                    Laragram::sendMessage(
                        chat_id: $message->chat->id,
                        text: 'Sizni Company ID bazada topilmadi'
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

            $branch_id = $branch['id'];
            $branch_name = $branch['name'];

            $to_day_attendance = date("Y-m-d H:i:s");

            $groups = $this->modmeService->checkGroup($branch_id, $token);
            $groups = $groups['data'];

            $company_group_number = 0;
            foreach($groups as $group){
                if($branch_id == $group['branch_id']){
                    $company_group_number += $group['company_group_number'];
                }
            }

            $answer = "
• Bugungi davomat:  $to_day_attendance

• Korxona:  $company_name
• Filiali:  $branch_name

• Guruhlar soni: $company_group_number

• Darsga keldi: API keladiyov
• Darsga kelmadi: API keladiyov
• Davomat belgilanmadi: API keladiyov

• Aktiv lidlar: API keladiyov
• Aktiv studentlar: API keladiyov

• Qarzdorlar soni: API keladiyov
• Umumiy qarzlar: API keladiyov
";
            Laragram::sendMessage(
                chat_id: $chat_id,
                text: $answer
            );
        }
    }
}
