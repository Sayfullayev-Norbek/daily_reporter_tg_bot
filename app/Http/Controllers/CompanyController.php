<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Service\ModmeService;

class CompanyController extends Controller
{
    private ModmeService $modmeService;

    public function __construct(ModmeService $modmeService)
    {
        $this->modmeService = $modmeService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $token = $request->input('token');
        $tokenInfo = $this->modmeService->checkToken($token);

        if(!empty($tokenInfo) && isset($tokenInfo['data']['company']['id'])){

            $modme_company_id = $tokenInfo['data']['company']['id'];
            $company = Company::query()->where('modme_company_id', $modme_company_id)->where('modme_token', $token)->first();

            if($company){

                $branches = $this->modmeService->checkCompany($token);
                return "Ok";
            }else{
                return view('tariff.tariff', compact('token'));
            }

        }else{
            return "Modme token orqali kirishingiz kerak!";
        }
    }

    public function tariffStore(Request $request){
        $request->validate([
            'token' => 'required',
            'tariff' => 'required',
            'terms' => 'accepted',
        ]);

        $token = $request->input('token');
        $tariff = $request->tariff;

        $tokenInfo = $this->modmeService->checkToken($token);

        if(!empty($tokenInfo) && isset($tokenInfo['data']['company']['id'])){
            $company_id = $tokenInfo['data']['company']['id'];
            $company_name = $tokenInfo['data']['company']['name'];

            Company::create([
                'name' => $company_name,
                'modme_company_id' => $company_id,
                'modme_token' => $token,
                'tariff' => $tariff
            ]);

            return redirect()->route('index')->with('token', $token);
        }else{
            return "Modme token orqali kirishingiz kerak!";
        }
    }
}
