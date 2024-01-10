<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker-default.css">
<script src="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">کاربران سایت</div>

                            <div class="block-btn align-right">
                            <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2 " onclick="clearForm();">افزودن +</a>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">افزودن</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">

                            <div id="imageSelectBox" class="col-md-12 callout-warning text-center">

                                <img id="uploadImage" width="200" height="120" />

                                <label for="upload" class="btn btn-primary text-center">انتخاب
                                    تصویر</label>
                                <input type="file" name="upload" id="upload" class="post-file-upload" />
                                <input type="hidden" name="photo_address" id="photo_address" value="" />
                            </div>
                        </div>
                        <form enctype="multipart/form-data" name="frmUsers" id="frmUsers" role="form" method="post">
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <input type="hidden" id="hashId" name="hashId" />
                            <div class="form-group">
                                <label class="control-label">نام</label>

                                <input type="text" class="form-control" name="fname" id="fname">

                            </div>
                            <div class="form-group">
                                <label class="control-label">نام خانوادگی</label>

                                <input type="text" class="form-control" name="lname" id="lname">

                            </div>
                            <div class="form-group">
                                <label class="control-label">پست الکترونیکی</label>

                                <input type="text" class="form-control" name="email" id="email">

                            </div>
                            <div class="form-group">
                                <label class="control-label">نام کاربری</label>

                                <input type="text" class="form-control" name="user" id="user">

                            </div>
                            <div class="form-group">
                                <label class="control-label">جنسیت</label>

                                <select class="form-control" id="gender" name="gender">
                                    <option value="0">زن</option>
                                    <option value="1">مرد</option>
                                    <option value="2">سایر</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label">تلفن</label>

                                <input type="text" class="form-control" name="tell" id="tell">

                            </div>
                            <div class="form-group">
                                <label class="control-label">تلفن همراه</label>

                                <input type="text" class="form-control" name="mobile" id="mobile">

                            </div>
                            <div class="form-group">
                                <label class="control-label">تاریخ تولد</label>

                                <input type="text" class="form-control date-picker" autocomplete="off" id="birthDate" name="birthDate" placeholder="تاریخ تولد">

                            </div>
                            <div class="form-group">
                                <label class="control-label">آدرس</label>

                                <textarea name="address" id="address" class="form-control" cols="30" rows="3" style="resize:none"></textarea>

                            </div>

                            <div class="form-group">
                                <label class="control-label">نوع</label>

                                <select class="group-access form-control" name="type" id="type">
                                    <option value="5">کاربر </option>
                                    <option value="2">مدیر</option>
                                </select>

                            </div>

                            <!-- <button type="submit" id="save" name="save" class="btn btn-success btn-send" >ذخیره</button>
                            <button class="btn btn-danger" data-dismiss="modal">بستن</button>
                             -->
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

        <!-- Start anotherModal -->
        <div class="modal fade" id="passModal" tabindex="-2" role="dialog" aria-labelledby="anotherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">تغییر رمز عبور</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmChangePass" id="frmChangePass" role="form" method="post">
                            <input type="hidden" id="userId" name="userId" style="display:none;" />
                            <div class="form-group">
                                <label class="control-label">رمز عبور</label>

                                <input type="text" class="form-control" name="pass" id="pass">

                            </div>
                            <div class="form-group">
                                <label class="control-label">تکرار رمز عبور</label>

                                <input type="text" class="form-control" name="rePass" id="rePass">

                            </div>
                            <button type="submit" id="editPass" name="editPass"  class="btn btn-green btn-send">
                                تایید
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.End anotherModal -->
    </div>
</div><!-- /.content-wrapper -->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/users.js"></script>