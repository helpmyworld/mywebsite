<h2>New Quote Request</h2>
<p><strong>Name:</strong> {{ $quote->name }}</p>
<p><strong>Email:</strong> {{ $quote->email }}</p>
<p><strong>Phone:</strong> {{ $quote->phone ?: '—' }}</p>
<p><strong>Project Type:</strong> {{ $quote->project_type }}</p>
<p><strong>Budget:</strong> {{ $quote->budget ?: '—' }}</p>
<p><strong>Message:</strong></p>
<p>{{ nl2br(e($quote->message)) }}</p>
<p><em>Submitted at {{ $quote->created_at }}</em></p>
