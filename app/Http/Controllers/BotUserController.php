<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Company;
use Milly\Laragram\Types\Message;
use Milly\Laragram\Laragram;
use App\Service\ModmeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class BotUserController extends Controller
{
    public ModmeService $modmeService;

    public function start_private(Message $message)
    {
        if($message->chat->type == 'private'){
            $chat_id = $message->chat->id;
            $text = $message->text;
            $first_name = $message->from->first_name;

            if(str_contains($text, "/start ")){
                $modme_company_id = explode(" ", $text)[1];

                $company = Company::query()->where('modme_company_id',$modme_company_id)->first();

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

    public function plan_execution($chat_id, $token, $company_name, $lang){
        $this->modmeService = new ModmeService();

        if(in_array($lang, ['en', 'ru', 'uz'])){
            $locale = $lang ?? 'en';
            App::setLocale($locale);

            $branches = $this->modmeService->checkCompany($token);
            $branches = $branches['data'];

            foreach($branches as $branch){
                $branch_id = $branch['id'];
                $branch_name = $branch['name'];

                $data = $this->modmeService->getDashboad($token, $branch_id);
                $data = $data['data'];

                $to_day = Carbon::now();
                App::setLocale('en'); // dayName u/n en qilganmiz
                $now =  Carbon::now()->dayName;
                $to_from = Carbon::now()->format('Y-m-d');
                App::setLocale($locale);

                $groups = $this->modmeService->getGroups($branch_id, $token, 1);
                $total_pages = $groups['pagination']['totalPages'];

                $number_of_groups = 0;
                $came_to_class = 0;
                $did_not_come_to_class = 0;
                $attendance_not_specified = 0;

                for ($i = 1; $i <= $total_pages; $i++) {
                    $groups = $this->modmeService->getGroups($branch_id, $token, $i);
                    $groups = $groups['data'];

                    foreach ($groups as $group) {
                        $days = $group['days'];

                        if($group['status'] == 2){

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
                                $number_of_groups++;
                            }

                            $group_id = $group['id'];
                            $to_Attendes = $this->modmeService->getAttendanes($token, $branch_id, $group_id, $to_from);

                            foreach($to_Attendes as $to_Attend){
                                if(!empty($to_Attend['student_pay'])){
                                    $student_pay = $to_Attend['student_pay'];

                                    if($student_pay == 1){
                                        $came_to_class++;
                                    }elseif($student_pay == 0){
                                        $did_not_come_to_class++;
                                    }else{
                                        $attendance_not_specified++;
                                    }
                                }
                            }
                        }
                    }
                }

                $resAnswer = [
                    'to_day' => $to_day,
                    'company_name' => $company_name,
                    'branch_name' => $branch_name,
                    'number_of_groups' => $number_of_groups,
                    'came_to_class' => $came_to_class,
                    'did_not_come_to_class' => $did_not_come_to_class,
                    'attendance_not_specified' => $attendance_not_specified,
                    'leads' => $data['leads'],
                    'active_students' => $data['active_students'],
                    'debtors' => $data['debtors'],
                ];

                $text = __('messages.message', $resAnswer);

                Laragram::sendMessage(
                    chat_id: $chat_id,
                    text: $text
                );
            }
        }
    }
}
