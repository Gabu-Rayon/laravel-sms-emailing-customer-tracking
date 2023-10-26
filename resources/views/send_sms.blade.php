<!DOCTYPE html>
<html>
<head>
    <title>Bulky SMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Send Message</h1>
    <form id="smsForm" action="{{ route('send-sms') }}" method="POST">
		@csrf
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
            <div id="phoneError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" rows="5" id="message" name="message" required></textarea>
            <div id="messageError" class="text-danger"></div>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="single">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
