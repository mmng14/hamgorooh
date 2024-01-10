<table class="table table-striped border-top" id="sample_1">
    <thead>
        <tr>

            <th>ردیف</th>
            <th class="hidden-480">نام کاربری</th>
            <th class="hidden-480">نام و نام خانوادگی</th>
            <th class="hidden-480">جنسیت</th>
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

                <tr>

                    <td><?= ++$counter ?></td>
                    <td class="hidden-480"><a href="" target="_blank"><?= $result['user_name'] ?> </a></td>
                    <td class="hidden-480"><a href="" target="_blank"><?= $result['fname'] ?> <?= $result['lname'] ?></a></td>
                    <?php
                    $gender = "";
                    if ($result['gender'] == 0) {
                        $gender = " زن ";
                    }
                    if ($result['gender'] == 1) {
                        $gender = " مرد ";
                    }
                    if ($result['gender'] == 2) {
                        $gender = " سایر ";
                    }
                    ?>
                    <td><?= $gender ?></td>
                    <td class="hidden-phone">
                        <div class="author-thumb">
                            <img alt="" src="<?= $HOST_NAME ?>/<?= $result['photo'] ?>" class="avatar"  width="50" />
                        </div>
                    </td>
                    <td id="status_<?= $result['id']; ?>" class="hidden-phone">
                        <select class="group-access form-control" data-user="<?= $result['id']; ?>" name="user_group_<?= $result['id']; ?>" id="user_group_<?= $result['id']; ?>">
                            <option value="0" <?php if ($result['role'] == 0) echo " selected "; ?>>بدون دسترسی</option>
                            <option value="3" <?php if ($result['role'] == 3) echo " selected "; ?>>مدیر</option>
                            <option value="4" <?php if ($result['role'] == 4) echo " selected "; ?>>کاربر ویژه</option>
                            <option value="5" <?php if ($result['role'] == 5) echo " selected "; ?>>کاربر ساده</option>
                        </select>
                    </td>
                    <td>

                    </td>
                </tr>

            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="box-footer no-padding">

    <?php $current_page = $page_number; ?>

    <?php if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) : ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                $right_links = $current_page + 6;
                $previous = $current_page - 1; //previous link
                $next = $current_page + 1; //next link
                $first_link = true; //boolean var to decide our first link
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
                            << /a>
                    </li>
                    <li class="page-item last"><a class="page-link" href="#" data-page="<?= $total_pages; ?>" title="Last">
                            <<< /a>
                    </li> <?php endif; ?>
            </ul> <?php endif; ?> <input type="hidden" id="page_num" name="page_num" style="display:none;" value="<?= $page_number; ?>" />
        </nav>
</div>
<!-- 
<div class="form-group">
    <div class="col-lg-12">

        <?php $current_page = $page_number;  ?>

        <?php if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) : ?>
        <ul class="pagination">
            <?php
            $right_links    = $current_page + 6;
            $previous       = $current_page - 1; //previous link
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            ?>
            <?php if ($current_page > 1) : ?>

            <?php $previous_link = ($previous == 0) ? 1 : $previous; ?>
            <li class="first"><a href="#" data-page="1" title="First">>></a></li>
            <li><a href="#" data-page="<?php echo $previous_link; ?>" title="Previous">></a></li>
            <?php for ($i = ($current_page - 2); $i < $current_page; $i++) : ?>
            <?php if ($i > 0) : ?>
            <li><a href="#" data-page="<?= $i; ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
            <?php endif; ?>
            <?php endfor; ?>
            <?php $first_link = false; ?>
            <?php endif; ?>

            <?php if ($first_link) : ?>
            <li class="first active"><a><?= $current_page; ?></a></li>
            <?php elseif ($current_page == $total_pages) : ?>
            <li class="last active"><a><?= $current_page; ?></a></li>
            <?php else : ?>
            <li class="paginate_button active"><a><?= $current_page; ?></a></li>
            <?php endif; ?>

            <?php for ($i = $current_page + 1; $i < $right_links; $i++) : ?>
            <?php if ($i <= $total_pages) : ?>
            <li class="paginate_button"><a href="#" data-page="<?= $i ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
            <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
            <?php $next_link = ($i > $total_pages) ? $total_pages : $i; ?>
            <li class="paginate_button"><a href="#" data-page="<?= $next_link; ?>" title="Next"><</a></li>
            <li class="last"><a href="#" data-page="<?= $total_pages; ?>" title="Last"><<</a></li>
            <?php endif; ?>

        </ul>
        <?php endif;  ?>

        <input type="hidden" id="txtpagenum" name="txtpagenum" style="display:none;"   value="<?= $page_number; ?>"  />
    </div>

</div>
<div class="form-group">
    <div class="col-lg-12">
        <label style="direction: rtl; text-align: right; display: inline-block; padding: 6px;"><?php echo $total_rows; ?> ردیف</label>
    </div>
</div> -->