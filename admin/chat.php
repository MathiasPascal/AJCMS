<?php
require_once '../settings/config.php';

// Function to get chat messages
function getChatMessages($conn)
{
    $sql = "SELECT m.id, m.message, m.timestamp, u.name AS username
            FROM messages m
            JOIN users u ON m.user_id = u.id
            ORDER BY m.timestamp ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new message to the chat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in session
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: chat.php");
    exit();
}

// Fetch chat messages
$chat_messages = getChatMessages($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title><?php echo SITE_NAME; ?> - Chat</title>
    <style>
        .chat-container {
            max-width: 100%;
            margin: auto;
        }

        .chat-box {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            height: 500px;
            overflow-y: scroll;
            background-color: #f9f9f9;
        }

        .message {
            margin-bottom: 15px;
        }

        .message .username {
            font-weight: bold;
        }

        .message .timestamp {
            font-size: 0.8em;
            color: #666;
        }

        .message .text {
            margin-top: 5px;
        }

        .message-input {
            margin-top: 10px;
        }

        .video-conference {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            height: 500px;
            background-color: #f9f9f9;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>
        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container chat-container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-center text-danger">Chat</h1>
                <div class="chat-box" id="chatBox">
                    <?php foreach ($chat_messages as $message) { ?>
                        <div class="message">
                            <div class="username"><?php echo htmlspecialchars($message['username']); ?></div>
                            <div class="timestamp"><?php echo $message['timestamp']; ?></div>
                            <div class="text"><?php echo htmlspecialchars($message['message']); ?></div>
                        </div>
                    <?php } ?>
                </div>
                <form method="POST" action="" class="message-input">
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h1 class="text-center text-danger">Video Conference</h1>
                <div id="jitsi-container" class="video-conference"></div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function fetchMessages() {
                $.ajax({
                    url: 'fetch_messages.php',
                    method: 'GET',
                    success: function(data) {
                        $('#chatBox').html(data);
                        const chatBox = document.getElementById('chatBox');
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                });
            }

            // Fetch messages every 3 seconds
            setInterval(fetchMessages, 3000);

            // Initial fetch
            fetchMessages();

            // Jitsi Meet integration
            const domain = "meet.jit.si";
            const options = {
                roomName: "AJCMSChatRoom",
                width: "100%",
                height: 500,
                parentNode: document.querySelector('#jitsi-container'),
                configOverwrite: {
                    defaultLanguage: 'en' // Set the language to English
                },
                interfaceConfigOverwrite: {
                    filmStripOnly: false,
                    SHOW_JITSI_WATERMARK: false
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);
        });
    </script>
    <script src="https://meet.jit.si/external_api.js"></script>
</body>

</html>
