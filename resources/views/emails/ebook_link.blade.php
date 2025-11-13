<!doctype html>
<html>
  <body>
    <p>Hi {{ $toName }},</p>
    <p>Your e-book is ready. Click the link below to download:</p>
    <p><a href="{{ $url }}">{{ $url }}</a></p>
    <p>Note: This link expires on {{ $link->expires_at->toDayDateTimeString() }} and allows up to {{ $link->max_attempts }} downloads.</p>
    <p>Enjoy your reading!</p>
  </body>
</html>
