<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">مدیریت موضوعات</div>

                            <div class="block-btn align-right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2" onclick="clearForm();">افزودن +</a>
                            </div>
                            <?php if (isset($msg)) echo $msg; ?>

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

                    <div class="ui-block responsive-flex" id="results">
                        <div class="loading-div" id="loader"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">افزودن</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <div id="imageSelectBox" class="col-md-12 callout-warning text-center">

                                <img id="uploadImage" width="200" height="120" />

                                <label for="upload" class="btn btn-primary text-center upload-lable-btn">انتخاب
                                    تصویر</label>
                                <input type="file" name="upload" id="upload" class="post-file-upload" />
                                <input type="hidden" name="photo_address" id="photo_address" value="" />
                            </div>


                        </div>
                        <form enctype="multipart/form-data" name="formSubjects" id="formSubjects" role="form" method="post">
                            <input type="hidden" id="hashId" name="hashId" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <div class="form-group">
                                <label for="title" class="control-label">عنوان</label>

                                <input type="text" class="form-control " name="name" id="name">

                            </div>

                            <div class="form-group">
                                <label class="control-label">نام دادهای</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="data_name" id="data_name">

                            </div>
                            <div class="form-group">
                                <label class="control-label">سرور دیتا بیس</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="db_server" id="db_server">

                            </div>
                            <div class="form-group">
                                <label class="control-label">نام دیتا بیس</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="db_name" id="db_name">

                            </div>
                            <div class="form-group">
                                <label class="control-label">نام کاربری دیتا بیس</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="db_user" id="db_user">

                            </div>
                            <div class="form-group">
                                <label class="control-label">کلمه عبور دیتا بیس</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="db_pass" id="db_pass">

                            </div>
                            <div class="form-group">
                                <label class="control-label">توضیحات</label>

                                <textarea name="description" id="description" class="form-control" cols="45" rows="3" style="resize: none"></textarea>

                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label">Telegram Token</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="telegram_token" id="telegram_token">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Telegram ID</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="telegram_id" id="telegram_id">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Telegram Link</label>

                                <input type="text" class="form-control" style="direction: ltr; text-align: left;" name="telegram_link" id="telegram_link">

                            </div> -->

            
                            <div class="form-group">
                                <label class="control-label">منوی اصلی</label>

                                <input type="checkbox" name="topmenu" id="topmenu" class="checkboxes" value="1" />

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="has_resource">دارای منبع</label>

                                <input type="checkbox" name="has_resource" id="has_resource" class="checkboxes" value="1" />

                            </div>

                            <div class="form-group">
                                <label class="control-label">ترتیب</label>

                                <input type="text" class="form-control" name="ordering" id="ordering">

                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" id="status" class="checkboxes" value="1">
                                        وضعیت
                                    </label>
                                </div>
                            </div>

                            <!-- <button type="submit" id="save" name="save" class="btn btn-success btn-send" value="">ذخیره</button>
                            <button class="btn btn-danger" data-dismiss="modal">بستن</button> -->

                            <button type="submit" id="save" name="save" class="btn btn-green btn-md btn-send">ذخیره</button>
                            <button class="btn btn-grey btn-md" data-dismiss="modal">بستن</button>

                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</div><!-- /.content-wrapper -->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/subjects.js"></script>