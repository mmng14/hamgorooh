<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Your Page Content Here -->

            <!-- page start-->
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h3>کاربران ويژه</h3>
                        <div class="inbox-body">
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
                                            <form class="form-horizontal" enctype="multipart/form-data" name="frmUserAdmin" id="frmUserAdmin" role="form" method="post">
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
                                                    <label class="control-label">آدرس</label>

                                                    <textarea name="address" id="address" class="form-control" cols="30" rows="3" style="resize:none"></textarea>

                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">کاربر ويژه</label>

                                                    <input type="checkbox" name="poweruser" id="poweruser" class="checkboxes" value="1" />

                                                </div>


                                                <button class="btn btn-danger" data-dismiss="modal">بستن</button>
                                                <input type="submit" id="save" name="save" class="btn btn-success btn-send" value="" />

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
                                            <form class="form-horizontal" name="frmChangePass" id="frmChangePass" role="form" method="post">
                                                <input type="hidden" id="userId" name="userId" style="display:none;" />
                                                <div class="form-group">
                                                    <label class="control-label">رمز عبور</label>
                                                   
                                                        <input type="text" class="form-control" name="pass" id="pass">
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">تکرار رمز عبور</label>
                                                   
                                                        <input type="text" class="form-control" name="rePass" id="rePass">
                                                    
                                                </div>
                                                <input type="submit" id="editPass" name="editPass" value="ویرایش" class="btn btn-send" onClick="return checkElement();" />
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.End anotherModal -->
                        </div>

                    </header>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <label> مرتب سازی : </label>
                                <select id="cmbsort" name="cmbsort" onChange="loadData();" class="form-control" aria-controls="sample_1">
                                    <option value="1">قدیمی تر</option>
                                    <option value="2">جدید تر </option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label> تعداد سطرها : </label>
                                <select id="cmbnumberPage" name="cmbnumberPage" onChange="loadData();" class="form-control" aria-controls="sample_1">
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
                        </div>
                    </div><br />
                    <div id="results">
                        <div class="loading-div" id="loader"></div>

                    </div>
                </section>
            </div>
            <!-- page end-->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/user_admin.js"></script>