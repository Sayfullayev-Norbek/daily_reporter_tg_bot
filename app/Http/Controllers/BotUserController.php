<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Company;
use Milly\Laragram\Types\Message;
use Milly\Laragram\Laragram;
use App\Service\ModmeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

            $to_day = Carbon::now();
            $now = Carbon::now()->dayName;

            $groups = $this->modmeService->checkGroup($branch_id, $token, 0);
            $total_pages = $groups['pagination']['totalPages'];

            $n = 0;
            for ($i = 1; $i <= $total_pages; $i++) {
                $groups = $this->modmeService->checkGroup($branch_id, $token, $i);
                $groups = $groups['data'];

                foreach ($groups as $group) {

                    $days = $group['days'];
                    $groupDays = [];

                    if ($days == 1) {

                        $groupDays = ["Monday", "Wednesday", "Friday"];
                    } elseif ($days == 2) {

                        $groupDays = ["Tuesday", "Thursday", "Saturday"];
                    } elseif ($days == 3) {

                        $groupDays = ["Saturday", "Sunday"];
                    } elseif ($days == 4) {

                        $groupDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    } else {

                        $groupDays = ["Monday", "Tuesday", "Wednesday"];
                    }

                    if (in_array($now, $groupDays)) {
                        $n++;
                    }
                }
            }

           $answer = "
• Bugungi davomat:  $to_day

• Korxona:  $company_name
• Filiali:  $branch_name

• Guruhlar soni: $n

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
