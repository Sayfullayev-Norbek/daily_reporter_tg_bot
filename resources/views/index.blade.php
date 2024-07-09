@extends('layouts.modme')

@section('title')
    Statistika
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row ">
            <div class="col-12  px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" style="position: relative;">
                    <h2>
                        <a href="https://t.me/birinchitgbot?start={{ $company->modme_company_id }}">
                            https://t.me/birinchitgbot?start={{ $company->modme_company_id }}
                        </a>
                    </h2>
                </div>
            </div>
        </div>
    </div>

@endsection
