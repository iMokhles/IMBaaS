@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => "Hello {$user->name}",
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <center><p><strong> Click on the below button to verify your email address </strong></p></center>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => 'Verify',
        	'link' => 'http://google.com'
    ])

@stop