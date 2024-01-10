<div class="table-responsive mailbox-messages">
<table class="table table-striped border-top" id="sample_1">
    <thead>
    <tr>

        <th>ردیف</th>
        <th>عنوان</th>
        <th class="hidden-phone">کد</th>
        <th class="hidden-phone">تصویر</th>
        <th class="hidden-phone">قیمت</th>
        <th class="hidden-phone">وضعیت</th>
        <th class="hidden-phone"></th>

    </tr>
    </thead>
    <tbody>
    <?php
    $counter=0;
    ?>

    <?php if(isset($model)):?>
        <?php    foreach ($model as $result) :  ?>

            <tr>

                <td><?= ++$counter ?></td>
                <td class="hidden-480"><a href="" target="_blank" ><?= $result['title']  ?></a></td>
                <td><?= $result['post_code'] ?></td>
                <td class="hidden-phone">
                    <img alt="" src="<?= $result['thumb_address'] ?>" width="90" height="50" />
                </td>
                <td><?= $result['price'] ?></td>
                <td id="status_<?= $result['id'] ; ?>" class="hidden-phone">
                    <?php if ($result['status'] == 1) : ?>
                        <span   onClick="deactivate(<?= $result['id']; ?>);" ><i class="fa  fa-toggle-on active-toggle"></i></span>
                    <?php else: ?>
                        <span  onClick="activate(<?= $result['id']; ?>);" ><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                    <?php endif; ?>
                </td>
                <td>
                    <button class="btn btn-purple btn-sm"
                    onclick="sendToSubjects(<?= $result['id']; ?>)" title=" ارسال به سایت مرتبط" >
                    <i class="fa fa-paper-plane  list-ctrl-icon"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>
<div class="form-group pagination-total-rows">
    <div class="col-lg-12">
        <label style="direction: rtl; text-align: right; display: inline-block; padding: 6px;"> تعداد کل سطر ها :  <?php echo $total_rows; ?> ردیف</label>
    </div>
</div>
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
                    <li class="page-item"><a href="#" class="page-link" data-page="1" title="First">>></a></li>
                    <li class="page-item"><a href="#" class="page-link" data-page="<?php echo $previous_link; ?>" title="Previous">></a></li>
                    <?php for ($i = ($current_page - 2); $i < $current_page; $i++) : ?>
                        <?php if ($i > 0) : ?>
                            <li><a href="#" class="page-link" data-page="<?= $i; ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php $first_link = false; ?>
                <?php endif; ?>

                <?php if ($first_link) : ?>
                    <li class="page-item active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php elseif ($current_page == $total_pages) : ?>
                    <li class="page-item active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php else : ?>
                    <li class="paginate_button active"><a class="page-link"><?= $current_page; ?></a></li>
                <?php endif; ?>

                <?php for ($i = $current_page + 1; $i < $right_links; $i++) : ?>
                    <?php if ($i <= $total_pages) : ?>
                        <li class="page-item"><a class="page-link" href="#" data-page="<?= $i ?>" title="Page<?= $i; ?>"><?= $i; ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <?php $next_link = ($i > $total_pages) ? $total_pages : $i; ?>
                    <li class="page-item"><a class="page-link" href="#" data-page="<?= $next_link; ?>" title="Next">
                            <</a> </li> <li class="last"><a class="page-link" href="#" data-page="<?= $total_pages; ?>" title="Last">
                                    <<</a> </li> <?php endif; ?> </ul> <?php endif; ?> <input type="hidden" id="page_num" name="page_num" style="display:none;" value="<?= $page_number; ?>" />

        </nav>


</div>



