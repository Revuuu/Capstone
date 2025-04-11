<?php
include('get_messages.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    
<div class="container p-5">
    <?php foreach($chats as $chat){?>
        <div class="row" style="width: 100%">
            <?php if($chat['is_seller'] != 1){?>
                <div class="col-10" style="text-align: left">
                    <span class="badge text-bg-light"><?=$chat['content']?></span>
                </div>
                <div class="col-2"></div>
            <?php } else {?>
                <div class="col-2"></div>
                <div class="col-10" style="text-align: right">
                    <span class="badge text-bg-primary"><?=$chat['content']?></span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<div class="continer p-5">
    <form action="send_message.php" method="post">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" style="height: 100px" required name="message"></textarea>
            <label>Enter your message here</label>
        </div>
        <center>
            <input type="hidden" name="thread_id" value="<?= $_GET['thread_id']?>">
            <input type="submit" class="btn btn-success mt-2" value="Send">
        </center>
    </form>

</div>

</body>
</html>