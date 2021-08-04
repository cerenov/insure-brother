@component('mail::message')
# Introduction

name: {{$name}}<br>
id отклика: {{$id}}<br>
phone: {{$phone}}<br>
emil: {{$email}}<br>

@component('mail::button', ['url' => 'http://localhost:8000/dashboard'])
    перейти к откликам
@endcomponent

@component('mail::button', ['url' => 'http://localhost:8000/responses/read'])
    открыть карточку отклика
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
