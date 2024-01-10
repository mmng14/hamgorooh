<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title"><?php echo $user_info; ?></div>

                            <div class="block-btn align-right">
                                <button href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2" onclick="clearForm();">افزودن +</button>
                                <!-- <button type="submit" name="btndelete" id="btndelete" class="btn btn-danger btn-md-2" style="margin-left: 3%; margin-bottom: 1%;" onclick="return checkElement();">حذف</button> -->
                            </div>
                            <?php if (isset($msg)) echo $msg; ?>
                            <input type="hidden" name="this_user_id" id="this_user_id" value="<?php echo $user; ?>" />
                            <div class="block-btn align-right">
                                <label> : مرتب سازی </label>
                                <select id="cmbsort" name="cmbsort" onChange="loadData();" class="selectpicker form-control " aria-controls="sample_1">
                                    <option value="1">قدیمی تر</option>
                                    <option value="2">جدید تر</option>
                                </select>
                            </div>
                            <div class="block-btn align-right">
                                <label> : تعداد سطرها </label>
                                <select id="cmbnumberPage" name="cmbnumberPage" onChange="loadData();" class="selectpicker form-control" aria-controls="sample_1">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>

                            <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Tab panes -->
                    <!-- <form action="ajax/ajax_user_subjects.php" method="post"> -->
                    <div class="ui-block responsive-flex" id="results">
                        <div class="loading-div" id="loader"></div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;</button>
                        <h4 class="modal-title">افزودن</h4>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" name="frmUserGroups" id="frmUserGroups" role="form" method="post">
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <input type="hidden" id="hashId" name="hashId" style="display: none;" />
                            <div class="form-group">
                                <label class="control-label">موضوع</label>

                                <select class="form-control" id="subject" name="subject" onchange='setCategory(this.value,0)'>
                                    <option value="0">انتخاب کنید</option>
                                    <?php
                                    foreach ($subject_list as $result) {
                                        echo "<option value=\"" . $result['id'] . "\" />" . $result['name'];
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label">گروه</label>

                                <select class="form-control" id="group" name="group">
                                    <option value="0">همه گروه‌ها</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label class="control-label">سمت</label>

                                <select class="form-control" id="role" name="role">
                                    <option value="3">مدیر گروه</option>
                                    <option value="4">کاربر ويژه</option>
                                    <option value="5">کاربر ساده</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label">حق دسترسی</label>

                                <input type="text" class="form-control" name="rights" id="rights">

                            </div>


                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" id="status" class="checkboxes" value="1">
                                        وضعیت
                                    </label>
                                </div>
                            </div>
                            <!-- <button type="submit" id="save" name="save" class="btn btn-green btn-send" value="">ذخیره</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">بستن</button>
                       -->
                            <button type="submit" id="save" name="save" class="btn btn-green btn-md btn-send">ذخیره</button>
                            <button class="btn btn-grey btn-md" data-dismiss="modal">بستن</button>
        
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.content-wrapper -->
    <!-- page end-->
    <script>
        var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
    </script>
    <script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/user_groups.js"></script>