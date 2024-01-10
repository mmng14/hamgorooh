<div class="table-responsive mailbox-messages">

    <?php if (isset($model)) : ?>
        <?php foreach ($model as $result) : ?>
            <div class="ui-block">


                <div class="birthday-item inline-items badges">
                    <div class="author-thumb">
                        <img src="<?= $HOST_NAME ?>resources/assets/img/badge1.png" alt="author">
                        <div class="label-avatar bg-primary">2</div>
                    </div>
                    <div class="birthday-author-name">
                        <a href="#" class="h6 author-name">Olympian User</a>
                        <div class="birthday-date">Congratulations! You have been in the Olympus community for 2 years.</div>
                    </div>

                    <div class="skills-item">
                        <div class="skills-item-meter">
                            <span class="skills-item-meter-active skills-animate" style="width: 76%; opacity: 1;"></span>
                        </div>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <div class="box-footer no-padding">
        <div class="mailbox-controls">
            <?php $current_page = $page_number; ?>

            <?php if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) : ?>
                <ul class="pagination">
                    <?php
                    $right_links = $current_page + 6;
                    $previous = $current_page - 1; //previous link
                    $next = $current_page + 1; //next link
                    $first_link = true; //boolean var to decide our first link
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
                        <li class="paginate_button"><a href="#" data-page="<?= $next_link; ?>" title="Next">
                                << /a>
                        </li>
                        <li class="last"><a href="#" data-page="<?= $total_pages; ?>" title="Last">
                                <<< /a>
                        </li>
                    <?php endif; ?>

                </ul>
            <?php endif; ?>

            <input type="hidden" id="page_num" name="page_num" style="display:none;" value="<?= $page_number; ?>" />
        </div>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1<div class="ripple-container">
                        <div class="ripple ripple-on ripple-out" style="left: -10.3833px; top: -16.8333px; background-color: rgb(255, 255, 255); transform: scale(16.7857);"></div>
                    </div></a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">12</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
    <!-- ... end Pagination -->
</div>