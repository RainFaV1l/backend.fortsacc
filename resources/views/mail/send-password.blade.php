<x-mail::message>
# Introduction

Thank you for registering your account.
Your password to log in to the system: {{ $password }}
We recommend changing it after authorization!

<x-mail::button :url="'http://localhost:5173/login'">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
