<h1>Hello, {{ $userAbout->getFullName() }}!</h1>
<p>You got a review from <strong>{{ $reviewer->getFullName() }}</strong>
for event <strong>{{ $event->name }}</strong> ({{ $event->date }}, {{ $event->destination }})!</p>
<p>Your point is - <strong>{{ $mark }}</strong></p>