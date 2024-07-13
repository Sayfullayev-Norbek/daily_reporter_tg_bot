@extends('layouts.modme')

@section('title')
    Bosh sahifa
@endsection

@section('content')
    <div class="bg-dark text-center " style="border-radius: 9px;">
        <div class="shape-parent container">
            <div class="justify-content-center text-white mb-100 row">
                <div data-aos="fade-up" class="col-12 col-lg-8 col-xl-6 col aos-init aos-animate">
                    Sizning Kampaniyangiz 👇
                    <h1 class="display-4 mb-4 text-white">{{ $company->name }} 🏫</h1>
                    <p class="mb-4">
                        <a href="https://t.me/birinchitgbot?start={{ $company->modme_company_id }}" class="text-white">
                            Bu telegram bot
                        </a>
                        orqali siz har kuni 21:00 da Sizning Kampaniyangiz
                        @if(!empty($branches))
                            va filaillarinizni
                            @foreach ($branches as $branch)
                                {{ $branch['name'] }},
                            @endforeach
                            hisobatlarini ham olishingiz mumkin! 👇
                        @else
                            hisobatlarini olishingiz mumkin! 👇
                        @endif
                    </p>
                    <div class="d-flex justify-content-center align-items-center" style="position: relative;">
                        <a href="https://t.me/birinchitgbot?start={{ $company->modme_company_id }}" class="btn btn-primary text-white m-2" style="border-radius: 5px; border-bottom: 2px solid #007bff; margin: 2px;" target="_blank">
                            https://t.me/birinchitgbot?start={{ $company->modme_company_id }}
                        </a>
                        <button class="btn btn-primary" onclick="copyToClipboard('linkInput', 'copyIcon', 'copyNotification')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16" id="copyIcon" style="border-radius: 3px; border-botton: 2px solid #007bff; margin: 2px;">
                                <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                            </svg>
                        </button>
                        <div id="copyNotification" class="text-success" style="display: none; position: absolute; top: -20px; right: 0;">
                        </div>
                    </div>
                    <input type="text" id="linkInput" value="https://t.me/birinchitgbot?start={{ $company->modme_company_id }}" readonly style="width: 100%; position: absolute; left: -9999px;">

                </div>
            </div>

        </div>

        @include('rating')

    </div>
@endsection
