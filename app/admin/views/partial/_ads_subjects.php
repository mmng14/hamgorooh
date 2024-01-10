<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <thead style="background-color: #aaa;min-height:35px;">
            <tr>
                <th>ردیف</th>
                <th class="hidden-phone">کد موضوع</th>
                <th class="hidden-phone">نام سایت</th>
                <th class="hidden-phone">آدرس سایت</th>
                <th class="hidden-phone">API</th>
                <!-- <th class="hidden-phone">وضعیت</th> -->
                <th class="hidden-phone"></th>
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
                        <td class="mailbox-subject"><b><?= $result['subject_id'] ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['site_name'] ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['site_link'] ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['recieve_link'] ?></b></td>
                        <!-- <td id="status_<?= $result['id'] ?>" class="hidden-phone">
                            <?php if ($result['status'] == 1) : ?>
                                <span class="btn btn-green btn-sm" onClick="deactivate(<?= $result['id'] ?>);"><i class="fa  fa-check"></i></span>
                            <?php else : ?>
                                <span class="btn btn-danger btn-sm" onClick="activate(<?= $result['id'] ?>);"><i class="fa  fa-window-close"></i></span>
                            <?php endif  ?>
                        </td> -->
                        <td class="mailbox-date">

                            <button class="btn btn-green btn-sm" onclick="sendToSubjects('<?= $result['id'] ?>')" title=" ارسال تبلیغ ">
                                <i class="fa fa-paper-plane list-ctrl-icon"></i>
                            </button>

                            <!-- <button class="btn btn-primary btn-md" 
								onclick="updateToSubjects('<?= $result['id'] ?>')" title=" بروز رسانی تبلیغ " >
								<i class="fa fa-paper-plane-o"></i>
							</button> -->

                            <button class="btn btn-danger btn-sm" onclick="deleteToSubjects('<?= $result['id'] ?>')" title=" حذف تبلیغ ">
                                <i class="fa fa-paper-plane list-ctrl-icon"></i>
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
                            <</a> </li> <li class="page-item last"><a class="page-link" href="#" data-page="<?= $total_pages; ?>" title="Last">
                                    <<</a> </li> <?php endif; ?> </ul> <?php endif; ?> <input type="hidden" id="page_num" name="page_num" style="display:none;" value="<?= $page_number; ?>" />
        </nav>
</div>