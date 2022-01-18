@component('mail::message')
    <html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    </head>
    <body>
    <div>
        <p>
            The email {{$data['subscriber']}} has requested to subscribe to PolizzaCerta newsletters and has agreed to the Privacy Policy terms on {{$data['date']}} with IP no. {{$data['ip']}}.
        </p>
    </div>
    </body>
    </html>
@endcomponent
