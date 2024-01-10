<div class="table-responsive mailbox-messages">
    <table class="table table-striped border-top forums-table" id="sample_1">
        <thead>
            <tr>

                <th>ردیف</th>
                <th class="hidden-480">عنوان</th>
                <th class="hidden-phone">تصویر</th>
                <th class="hidden-phone">وضعیت</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 0;
            ?>

            <?php if (isset($model)) : ?>
                <?php foreach ($model as $result) :  ?>


                    <?php
                    $link_post_id =   $result['id'];
                    $link_post_id_length =  strlen($result['id']);
                    $link_subject_id =   $result['subject_id'];
                    $link_subject_id_length =  strlen($result['subject_id']);
                    $link_category_id =   $result['category_id'];
                    $link_category_id_length =  strlen($result['category_id']);
                    $link_post_name = $result['post_name'];
                    $link_post_url = $HOST_NAME . "post/{$link_subject_id_length}{$link_subject_id}{$link_category_id_length}{$link_category_id}{$link_post_id_length}{$link_post_id}/{$link_post_name}";
                    //overwrite it if its news
                    if ($link_subject_id == 16) {
                        $current_year = jdate('Y');
                        $current_year = convertPersianToEng($current_year);
                        $link_post_url = $HOST_NAME . "news/{$current_year}{$link_subject_id_length}{$link_subject_id}{$link_category_id_length}{$link_category_id}{$link_post_id_length}{$link_post_id}/{$link_post_name}";
                    }

                    $post_id = encode_url($result["id"]);
                    $thumb_address = $result['thumb_address'];
                    if (strpos(strtolower($thumb_address), 'http') === false) {
                        $thumb_address = $HOST_NAME . $thumb_address;
                    }
                    ?>
                    <tr>

                        <td><?= ++$counter ?></td>
                        <td class="hidden-480" style="text-align:right !important;"><a href="<?= $link_post_url ?>"  target="_blank" ><?=  mb_substr(strip_tags(trim(html_entity_decode($result['title'],   ENT_COMPAT, 'UTF-8'))), 0, 100). '...'  ?></a></td>
                        <td class="hidden-phone">
                            <img alt="" src="<?= $thumb_address ?>" style="max-width: 70px !important;" />
                        </td>
                        <td id="status_<?= $result['id']; ?>" class="hidden-phone">
                            <?php if ($result['status'] == 1) : ?>
                                <span  onClick="deactivate(<?= $result['id']; ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span  onClick="activate(<?= $result['id']; ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif; ?>

                        </td>
                        <td>
                            <a class="btn btn-green btn-sm btn-link-custom" title="ارسال به سایت مرتبط" onclick="sendToSubjectSite('<?= $result['id'] ?>')"><i class="fa fa-paper-plane list-ctrl-icon color-white" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm btn-link-custom" title="ارسال به رپرتاژ" onclick="reportage('<?= $result['id'] ?>')"><i class="fa fa-paper-plane list-ctrl-icon color-white" aria-hidden="true"></i></a>
                            <a class="btn btn-blue btn-sm btn-link-custom" title="ارسال به تلگرام" onclick="telegram('<?= $result['id'] ?>')"><i class="fa fa-paper-plane list-ctrl-icon color-white" aria-hidden="true"></i></a>

                            <a class="btn btn-green btn-sm btn-link-custom" href="<?= $HOST_NAME?>group_admin/post-attachments/<?= $link_subject_id ?>/<?= $link_category_id ?>/<?= $result['id']; ?>">
                                <i class="fa fa-paperclip list-ctrl-icon"></i>
                            </a>

                            <a class="btn btn-purple btn-sm btn-link-custom" data-toggle="modal" href="<?php echo $HOST_NAME; ?>/group_admin/comments/<?= $result['id'] ?>/">
                                <i class="fa fa-comment  list-ctrl-icon"></i>
                            </a>

                            <a href="<?php echo $HOST_NAME; ?>group_admin/post_add/<?php echo $link_subject_id; ?>/<?php echo $link_post_id; ?>" class="btn btn-primary btn-sm btn-link-custom" onclick="setData('<?= $result['id'] ?>')">
                                <i class="fa fa-edit  list-ctrl-icon"></i>
                            </a>

                            <button class="btn btn-danger btn-sm" href="#" onclick="deleteData('<?= $result['id']; ?>')">
                                <i class="fa fa-trash  list-ctrl-icon"></i>
                            </button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="box-footer no-padding">

    <?php $current_page = $page_number;  ?>

    <?php if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) : ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                $right_links    = $current_page + 6;
                $previous       = $current_page - 1; //previous link
                $next           = $current_page + 1; //next link
                $first_link     = true; //boolean var to decide our first link
                ?>
                <?php if ($current_page > 1) : ?>

                    <?php $previous_link = ($previous == 0) ? 1 : $previous; ?>
                    <li class="page-item first"><a class="page-link" href="#" data-page="1" title="First">>></a></li>
                    <li class="page-item"><a class="page-link" href="#" data-page="<?php echo $previous_link; ?>" title="Previous">></a></li>
                    <?php for ($i = ($current_page - 2); $i < $current_page; $i++) : ?>
                        <?php if ($i > 0) : ?>
                            <li class="page-item"><a class="page-link" href="#" data-page="<?= $i; ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php $first_link = false; ?>
                <?php endif; ?>

                <?php if ($first_link) : ?>
                    <li class="page-item first active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php elseif ($current_page == $total_pages) : ?>
                    <li class="page-item last active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php else : ?>
                    <li class="page-item active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php endif; ?>

                <?php for ($i = $current_page + 1; $i < $right_links; $i++) : ?>
                    <?php if ($i <= $total_pages) : ?>
                        <li class="page-item"><a class="page-link" href="#" data-page="<?= $i ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <?php $next_link = ($i > $total_pages) ? $total_pages : $i; ?>
                    <li class="page-item"><a class="page-link" href="#" data-page="<?= $next_link; ?>" title="Next">
                            <</a>
                    </li>
                    <li class="page-item last"><a class="page-link" href="#" data-page="<?= $total_pages; ?>" title="Last">
                            <<</a>
                    </li>
                <?php endif; ?>

            </ul>
        <?php endif;  ?>

        <input type="hidden" id="txtpagenum" name="txtpagenum" style="display:none;" value="<?= $page_number; ?>" />
        </nav>

</div>

<div class="form-group">
    <div class="col-lg-12">
        <label style="direction: rtl; text-align: right; display: inline-block; padding: 6px;"><?php echo $total_rows; ?> ردیف</label>
    </div>
</div>