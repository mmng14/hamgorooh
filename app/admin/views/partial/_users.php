<style>
    .user-type-select{
        padding: 4px 10px !important;
    }
</style>
<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ردیف</th>
                <th class="hidden-480">نام و نام خانوادگی</th>
                <th class="hidden-phone">جنسیت</th>
                <th class="hidden-phone">تصویر</th>
                <th class="hidden-phone">نام کاربری</th>
                <th class="hidden-phone">تلفن</th>
                <th class="hidden-phone">وضعیت</th>
                <th class="hidden-phone">نوع کاربر</th>
                <th>عملیات</th>
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
                        <?php
                                $gender = "نا مشخص";
                                if ($result['gender'] == 0) {
                                    $gender = "زن";
                                }
                                if ($result['gender'] == 1) {
                                    $gender = "مرد";
                                }
                                if ($result['gender'] == 2) {
                                    $gender = "سایر";
                                }


                                $strSubjectAdmin = "";
                                $strGroupAdmin = "";
                                $strPowerUser = "";
                                $strSimpleUser = "";
                                if($result['type']==2){   $strSubjectAdmin= " selected " ;   }
                                if($result['type']==3){   $strGroupAdmin= " selected " ;   }
                                if($result['type']==4){   $strPowerUser= " selected " ;   }
                                if($result['type']==5){   $strSimpleUser= " selected " ;   }


                                ?>
                        <td class="hidden-480"><a href="<?= $HOST_NAME ?>admin/user_info/<?= $result['id'] ?>"><?= $result['name'] ?> <?= $result['family'] ?></a></td>
                        <td class="mailbox-subject"><b><?= $gender ?></b></td>
                        <td class="mailbox-subject">
                            <?php
                            $user_photo = $HOST_NAME . "resources/assets/img/default_user_image.jpg";
                            if($result['photo'] !=null && $result['photo'] !=""){
                                $user_photo = $HOST_NAME . $result['photo'];
                            }
                            ?>
                            <img alt="" src="<?= $user_photo ?>" width="90px" height="50px" />
                        </td>
                        <td class="mailbox-subject"><b><?= $result['username']; ?></b></td>
                        <td class="mailbox-subject"><b><?= $result['phone']; ?></b></td>





                        <td id="status_<?= $result['id'] ?>" class="hidden-phone">
                            <?php if ($result['status'] == 1) : ?>
                                <span  onClick="deactivate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-on active-toggle"></i></span>
                            <?php else : ?>
                                <span  onClick="activate(<?= $result['id'] ?>);"><i class="fa  fa-toggle-off deactive-toggle"></i></span>
                            <?php endif  ?>
                        </td>

                        <td id="type_<?= $result['id'] ?>>" class="hidden-phone">
                            <select class="group-access user-type-select" data-user="<?=$result['id']?>" name="type_<?=$result['id'] ?>" id = "type_<?=$result['id']?>">
                                <option  <?=$strSimpleUser?> value="5">کاربر </option>
                                <option  <?= $strSubjectAdmin?> value="2">مدیر</option>
                            </select>
                        </td>

                        <td class="mailbox-date">
                            <a class="btn btn-green btn-sm btn-link-custom" href="<?=$HOST_NAME?>/admin/user_subjects/<?=$result['id']?>" title="گروههای مدیریت کاربر">
                                <i class="fa fa-users list-ctrl-icon"></i>
                            </a>
                            <!-- <a class="btn btn-primary btn-sm btn-link-custom" href="<?=$HOST_NAME?>/admin/user_groups/<?=$result['id']?>"  title="زیرگروههای مدیریت کاربر">
                                <i class="fa fa-users list-ctrl-icon"></i>
                            </a> -->

                            <a class="btn btn-purple btn-sm btn-link-custom" data-toggle="modal" href="#passModal" onclick="setPassData('<?=$result['id']?>')" title="تغییر کلمه عبور" >
                                <i class="fa fa-key list-ctrl-icon"></i>
                            </a>
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
        </div>
    </div>