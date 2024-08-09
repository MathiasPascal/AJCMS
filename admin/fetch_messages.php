<?php
require_once '../settings/config.php';

function getChatMessages($conn)
{
    $sql = "SELECT m.id, m.message, m.timestamp, u.name AS username
            FROM messages m
            JOIN users u ON m.user_id = u.id
            ORDER BY m.timestamp ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$chat_messages = getChatMessages($conn);
?>

<?php foreach ($chat_messages as $message) { ?>
    <div class="message">
        <div class="username"><?php echo htmlspecialchars($message['username']); ?></div>
        <div class="timestamp"><?php echo $message['timestamp']; ?></div>
        <div class="text"><?php echo htmlspecialchars($message['message']); ?></div>
    </div>
<?php } ?>
