<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ردیف</th>
                <th class="hidden-480">عنوان</th>
                <th class="hidden-480">کد</th>
                <th class="hidden-phone">تصویر</th>
                <th class="hidden-phone">منوی اصلی</th>
                <th class="hidden-phone">دارای منابع</th>
                <th class="hidden-phone">وضعیت</th>
                <th>گروهها</th>
                <th>منابع</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $counter = 0;
            ?>

            <?php if (isset($model)) : ?>
                <?php foreach ($model as $result) : ?>
                    <tr>

                        <td><?= ++$counter ?></td>

                        <td class="mailbox-subject"><b><?= $result['name']; ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['id']; ?></b></td>
                        <td class="mailbox-subject">
                            <img alt="" src="<?= $HOST_NAME . $result['photo'] ?>" width="90px" height="50px" />
                        </td>
                        <td id="topmenu_<?= $result['id'] ?>" class="hidden-phone">
                            <?php if ($result['top_menu'] == 1) : ?>
                                <span onClick="deactivateTopMenu(<?= $result['id'] ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span onClick="activateTopMenu(<?= $result['id'] ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif  ?>
                        </td>
                        <td id="has_resource_<?= $result['id'] ?>" class="hidden-phone">
                            <?php if ($result['has_resource'] == 1) : ?>
                                <span onClick="deactivateHasResource(<?= $result['id'] ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span onClick="activateHasResource(<?= $result['id'] ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif  ?>
                        </td>
                        <td id="status_<?= $result['id'] ?>" class="hidden-phone">
                            <?php if ($result['status'] == 1) : ?>
                                <span onClick="deactivate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span onClick="activate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif  ?>
                        </td>
                        <td>
                            <a href="<?= $HOST_NAME ?>/admin/subject_category/<?= $result['id'] ?>">گروهها</a>
                        </td>
                        <td>
                            <a href="<?= $HOST_NAME ?>/admin/subject_resources/<?= $result['id'] ?>">منابع</a>
                        </td>
                        <td class="mailbox-date">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" href="#myModal" onclick="setData('<?= $result['id'] ?>')">
                                <i class="fa  fa-edit list-ctrl-icon"></i>
                            </button>

                            <button class="btn btn-danger btn-sm" onclick="deleteData('<?= $result['id'] ?>')">
                                <i class="fa  fa-trash list-ctrl-icon"></i>
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- /.table -->

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
                            <</a>
                    </li>
                    <li class="last"><a class="page-link" href="#" data-page="<?= $total_pages; ?>" title="Last">
                            <<</a>
                    </li> <?php endif; ?>
            </ul> <?php endif; ?> <input type="hidden" id="page_num" name="page_num" style="display:none;" value="<?= $page_number; ?>" />

        </nav>


</div>