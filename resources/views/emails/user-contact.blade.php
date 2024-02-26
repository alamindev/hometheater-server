@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://admin.hometheaterproz.com/contact/view/'. $contact->id])
    <div style="display: flex; align-items: center;">
        <strong style="text-decoration: underline; font-size: 24px;">
            New Message from Website</strong>
    </div>
@endcomponent
@endslot
Dear <b>Admin,</b>
<br>
<b>{{$contact->name }}</b>, sent you a message.<br>

{{ $contact->details }} <br>

<p>Option selected: <strong>{{$contact->reason}}</strong></p>
<p>Phone Number: <strong>{{$contact->phone}}</strong></p>
 <br>
@component('mail::button', ['url' => 'https://admin.hometheaterproz.com/contact/view/'. $contact->id])
Please login to see more details
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
