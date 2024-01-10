
<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <tbody>

        <?php
        $counter=0;
        ?>

        <?php if(isset($model)):?>
        <?php    foreach ($model as $result) :  ?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><?= ++$counter ?></td>
                    <td class="mailbox-star"><a href="#"><i class="fa <?php if($result['status']==1) echo " fa-star "; else echo " fa-star-o "  ?> text-yellow"></i></a></td>
                    <td class="mailbox-name"><?= $result['name']; ?></td>
                    <td class="mailbox-subject"><b><?= $result['title']; ?></b></td>
                    <td class="mailbox-subject"><b><?= $result['email']; ?></b></td>
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    <td class="mailbox-date"><?= $result['register_date']; ?></td>
                
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <!-- /.table -->
    <div class="box-footer no-padding">
        <div class="mailbox-controls">
            <?php $current_page=$page_number;  ?>

            <?php  if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages): ?>
                <ul class="pagination">
                    <?php
                    $right_links    = $current_page + 6;
                    $previous       = $current_page - 1; //previous link
                    $next           = $current_page + 1; //next link
                    $first_link     = true; //boolean var to decide our first link
                    ?>
                    <?php   if($current_page > 1) : ?>

                        <?php $previous_link = ($previous==0)?1:$previous; ?>
                        <li class="first"><a href="#" data-page="1" title="First">>></a></li>
                        <li><a href="#" data-page="<?php echo $previous_link; ?>" title="Previous">></a></li>
                        <?php for($i = ($current_page-2); $i < $current_page; $i++): ?>
                            <?php if($i > 0): ?>
                                <li><a href="#" data-page="<?= $i; ?>" title="Page<?=$i;?>"><?=$i;?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $first_link = false; ?>
                    <?php endif; ?>

                    <?php if($first_link): ?>
                        <li class="first active"><a><?=$current_page;?></a></li>
                    <?php elseif($current_page == $total_pages): ?>
                        <li class="last active"><a><?=$current_page;?></a></li>
                    <?php else: ?>
                        <li class="paginate_button active"><a><?= $current_page;?></a></li>
                    <?php endif; ?>

                    <?php for($i = $current_page+1; $i < $right_links ; $i++):?>
                        <?php   if($i<=$total_pages): ?>
                            <li class="paginate_button"><a href="#" data-page="<?=$i?>" title="Page<?=$i;?>"><?= $i;?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($current_page < $total_pages): ?>
                        <?php  $next_link = ($i > $total_pages)? $total_pages : $i; ?>
                        <li class="paginate_button"><a href="#" data-page="<?=$next_link;?>" title="Next"><</a></li>
                        <li class="last"><a href="#" data-page="<?=$total_pages;?>" title="Last"><<</a></li>
                    <?php endif; ?>

                </ul>
            <?php endif;  ?>

            <input type="hidden" id="txtpagenum" name="txtpagenum" style="display:none;"   value="<?= $page_number; ?>"  />
        </div>
    </div>
</div>


