
<?php if (isset($model)) : ?>
    <?php foreach ($model as $result) : ?>
        <div class="choose-photo-item" data-mh="choose-item">
            <figure>
                <img id="img_<?= $result['id']; ?>" onclick="selectFromPhotoList(<?= $result['id']; ?>);" src="<?= $HOST_NAME . $result['thumb_address'] ?>" alt="<?= $result['title']; ?>">
                <figcaption>
                    <a href="#"><?= $result['title']; ?></a>
                    <span>تاریخ آپلود: <?= $result['register_date']; ?></span>
                </figcaption>
            </figure>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


