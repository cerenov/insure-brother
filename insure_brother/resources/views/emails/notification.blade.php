@component('mail::message')
# Introduction

name: {{$name}}<br>
id отклика: {{$id}}<br>
phone: {{$phone}}<br>
emil: {{$email}}<br>

@component('mail::button', ['url' => 'http://localhost:8000/responses'])
    перейти к откликам
@endcomponent

@component('mail::button', ['url' => $url_read_response])
    открыть карточку отклика
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
