<!DOCTYPE html>
<html>
    <body>
        <p>
            Hello {{ $subscriber_name }}
        </p>
        <p>
            Webinar URL : <a href="{{ $webinar_url }}" target="_blank">Click Here!</a>
        </p>
        {!! $body !!}
        
        
        
    </body>
</html>