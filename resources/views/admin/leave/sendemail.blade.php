<!DOCTYPE html>
<html>
<head>
    <title>Leave Request</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <div class="body">
            <p><strong>Please review and approve/reject this leave request:</strong></p>
            <form action="" method="">
                @csrf
                <input type="hidden" name="status" value="approved">
                <button type="submit">Approve</button>
            </form>
            <form action="" method="">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="submit">Reject</button>
            </form>
        </div>

        </div>
</body>
</html>