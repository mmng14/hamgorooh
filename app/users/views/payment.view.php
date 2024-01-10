<!-- Content Wrapper. Contains page content -->

<div class="main-header">
  <div class="content-bg-wrap bg-group"></div>
  <div class="container">
    <div class="row">
      <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
        <div class="main-header-content">
          <h3>
          <i class="fa fa-globe"></i>
           پرداخت فاکتور
          </h3>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="container">
  <div class="row">

  <div class="col col-lg-12 m-auto col-md-8 col-sm-12 col-12">

      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          فروشنده
          <address>
            <strong>شبکه اجتماعی همگروه</strong><br>
            بابل - میدان سردار شهید سلیمانی<br>
            تلفن: 011-32251211<br>
            ایمیل: info@hamgorooh.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          خریدار
          <address>
            <strong><?= $customer_name ?></strong><br>
            <?= $customer_address ?><br>
            تلفن: <?= $customer_phone ?><br>
            ایمیل: <?= $customer_email ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>شماره فاکتور : </b> <?= $invoice_number ?><br>

          <b>تاریخ پرداخت : </b> <?= $payment_date ?><br>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <hr />
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>تعداد</th>
                <th>محصول</th>
                <th>سریال #</th>
                <th>شرح</th>
                <th>قیمت</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td>1</td>
                <td><?= $product_name ?></td>
                <td><?= $invoice_number ?></td>
                <td> <?= $title ?> </td>
                <td><?= number_format($price) ?></td>
              </tr>

            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">روشهای پرداخت:</p>
          <img src="https://cdn.zarinpal.com/home/v2/assets/images/footer-logo.svg?d66823f354f11c156f6bc80229944c18" alt="Zarinpal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            پس از کلیک بر روی پرداخت نهایی به درگاه زرین پال هدایت خواهید شد و پس از پرداخت مبلغ خرید شما فعال خواهد شد.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">قیمت : </th>
                <td><?= number_format($price) ?></td>
              </tr>
              <tr>
                <th>مالیات : </th>
                <td><?= number_format($tax)  ?></td>
              </tr>
              <tr>
                <th>جمع کل : </th>
                <td><?= number_format($total_price) ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
         
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> پرداخت نهایی
          </button>
          <button  class="btn btn-blue"><i class="fa fa-print"></i> چاپ</button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> خروجی PDF
          </button>
        </div>
      </div>

    </div>
    <!-- /.content -->


  </div>
</div>

<script>
  var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/users/scripts/payment.js"></script>