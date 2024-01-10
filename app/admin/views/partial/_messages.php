<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <tbody>

            <?php
            $counter = 0;
            ?>

            <?php if (isset($model)) : ?>
                <?php foreach ($model as $result) :  ?>
                    <tr>
                        <td>
                            <div class="checkbox">

                                <input type="checkbox" name="message" id="message_<?= $result['id']; ?>" class="checkboxes" value="1" />

                            </div>
                        </td>
                        <td><?= ++$counter ?></td>
                        <!-- <td class="mailbox-star"><a href="#"><i class="fa <?php if ($result['status'] == 1) echo " fa-star ";
                                                                            else echo " fa-star "  ?> text-yellow"></i></a></td> -->
                        <td class="mailbox-name"><?= $result['name']; ?></td>
                        <td class="mailbox-subject"><b><?= $result['title']; ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['email']; ?></b></td>
                        <td class="mailbox-attachment"><i class="fa fa-paperclip  list-ctrl-icon"></i></td>
                        <td id="status_<?= $result['id'] ?>" class="mailbox-star">
                            <?php if ($result['status'] == 1) : ?>
                                <span  onClick="deactivate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span  onClick="activate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif  ?>
                        </td>
                        <td class="mailbox-date"><?= $result['register_date']; ?></td>
                        <td class="mailbox-date">
                            <button class="btn btn-danger btn-sm" onclick="deleteData('<?= $result['id'] ?>')">
                                <i class="fa   fa-trash list-ctrl-icon"></i>
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

    <?php $current_page = $page_number;  ?>

    <?php if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) : ?>
        <nav aria-label="page navigation">
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
                            << </a>
                    </li> <?php endif; ?>
            </ul> 
            <?php endif;  ?> <input type="hidden" id="txtpagenum" name="txtpagenum" style="display:none;" value="<?= $page_number; ?>" />
        </nav>
</div>