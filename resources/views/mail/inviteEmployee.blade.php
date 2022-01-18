@component('mail::message')
    <html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    </head>
    <body>
    <div>
        <p>
            You were invited to {{$title}}
        </p>
        <a href="{{$server.'/register/employee/'.$token}}">
            <button style="padding:10px 20px; background-color: #7367F0; border-radius: 5px; border: 0px; color: white; cursor: pointer;">
                Go to registration
            </button>
        </a>
    </div>
    </body>
    </html>
@endcomponent
