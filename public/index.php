<?php
require '../vendor/autoload.php';

$Parsedown = new Parsedown();

$config = require_once('../config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    
    $parser = new \Parsedown();
    $sender = (isset($_POST['receiver'])) ? explode(';',$_POST['receiver']) : [];

    foreach($sender as $mail){
        $data = [
            'to' => $mail,
            'reply_to' => (!empty($_POST['replyto'])) ? $_POST['replyto'] : null,
            'subject' => $_POST['subject'],
            'text' => $parser->setBreaksEnabled(true)->text($_POST['message']),
            'from' => $_POST['sender'],
        ];
        file_put_contents('../mail/queue/' . $mail . '_' . time() . '.json', json_encode($data));
    }

}


?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMTP sender</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body>

    <div class="col-lg-8 mx-auto p-4 py-md-5">
        <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <span class="fs-4">SMTP sender</span>
            </a>
        </header>

        <main>
            <form method="post">
                <div class="mb-3">
                    <label for="sender" class="form-label">Absender</label>
                    <select name="sender" id="sender" class="form-select">
                        <?php foreach($config['sender'] as $key => $val): ?>
                        <option value="<?=$key?>"><?=$key?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="replyto" class="form-label">Antworten an</label>
                    <input type="email" class="form-control" id="replyto" name="replyto">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Betreff</label>
                    <input type="text" class="form-control" id="subject" name="subject">
                </div>
                <div class="mb-3">
                    <label for="receiver" class="form-label">Empfänger</label>
                    <input type="text" class="form-control" id="receiver" name="receiver">
                    <div class="form-text">Mehrere Empfänger mit einem Semikolon trennen.</div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nachricht</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Senden</button>
            </form>
        </main>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script>
    var simplemde = new SimpleMDE({
        element: $("#message")[0]
    });
    </script>

</body>

</html>