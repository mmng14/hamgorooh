
<?php if (isset($model)) : ?>
    <?php foreach ($model as $result) : ?>
        <div class="choose-photo-item" data-mh="choose-item">
            <figure>
                <img style="height:180px;width:300px ;" id="resource_<?= $result['id']; ?>" onclick="selectFromResourceList(<?= $result['id']; ?>);" src="<?= $HOST_NAME . $result['photo_address'] ?>" alt="<?= $result['title']; ?>">
                <figcaption>
                    <a href="#"><?= $result['title']; ?></a>
                    <span>تاریخ آپلود: <?= $result['register_date']; ?></span>
                </figcaption>
            </figure>
            <input type="hidden" id="resource_photo_<?= $result['id'] ?>" name="resource_address_<?= $result['id'] ?>" value="<?= $result['photo_address']; ?>" />
            <input type="hidden" id="resource_address_<?= $result['id'] ?>" name="resource_address_<?= $result['id'] ?>" value="<?= $HOST_NAME."resource/".$result['id']."/".$result['title']; ?>" />
            <input type="hidden" id="resource_title_<?= $result['id'] ?>" name="resource_address_<?= $result['id'] ?>" value="<?= $result['title'] ?>" />
        </div>
    <?php endforeach; ?>
<?php endif; ?>


