<?php
$user_id = $_SESSION["user_id"];
?>

<?php if(isset($model)) : ?>
    <?php foreach ($model as $item) : ?>

        <?php if ($item["sender_user_id"] == $user_id) : ?>

            <li>
                <div class="author-thumb">
                    <img src="<?= $HOST_NAME ?><?= $item["sender_photo"] ?>" alt="author">
                </div>
                <div class="notification-event">
                    <div class="event-info-wrap">
                        <a href="#" class="h6 notification-friend"><?= $item["sender_full_name"] ?></a>
                        <span class="notification-date"><time class="entry-date updated" datetime="<?= $item["register_date_fa"] . " " . $item["register_date_fa"] ?>"><?= $item["register_time_fa"] . "  -  " . $item["register_date_fa"] ?></time></span>
                    </div>
                    <span class="chat-message-item"><?= nl2br($item["message"],true) ?></span>
                </div>
            </li>

        <?php else : ?>

            <li class="chat-others-li">
                <div class="author-thumb">
                    <img src="<?= $HOST_NAME ?><?= $item["sender_photo"] ?>" alt="author">
                </div>
                <div class="notification-event">
                    <div class="event-info-wrap chat-others-div">
                        <a href="#" class="h6 notification-friend"><?= $item["sender_full_name"] ?></a>
                        <span class="notification-date"><time class="entry-date updated" datetime="<?= $item["register_date_fa"] . " " . $item["register_time_fa"] ?>"><?= $item["register_date_fa"] . "  - " . $item["register_time_fa"] ?></time></span>
                    </div>
                    <span class="chat-message-item chat-message-item-current  chat-others-span">
                        <?= nl2br($item["message"],true) ?>
                    </span>

                </div>
            </li>

        <?php endif; ?>

    <?php endforeach; ?>
<?php else : ?>
    <li>داده ای برای نمایش وجود ندارد</li>
<?php endif; ?>