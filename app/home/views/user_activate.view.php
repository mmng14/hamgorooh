<!-- signup-verification-page -->
<section class="medium-padding120">
    <div class="container">
        <div class="row">
            <div class="col col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="page-404-content">
                    <?php if (isset($activation) && $activation == "pass") : ?>
                        <img src="<?=$HOST_NAME ?>resources/assets/img/approved.png" alt="photo" class="center">

                        <div class="crumina-module crumina-heading align-center">

                            <h2 class="h1 heading-title"> <span class="c-primary"><?= $msg ?></span> </h2>
                            <p class="heading-text">
                                <a> پس از چند لحظه بطور خود کار وارد صفحه اصلی سایت خواهيد شد</a>
                            </p>

                        </div>
                    <?php else : ?>
                        <img src="<?=$HOST_NAME ?>resources/assets/img/rejected.png" alt="photo" class="center">

                        <div class="crumina-module crumina-heading align-center">

                            <h2 class="h1 heading-title"> <span class="c-primary"><?= $msg ?></span> </h2>
                            <p class="heading-text">
                                <a> پس از چند لحظه بطور خود کار وارد صفحه اصلی سایت خواهيد شد</a>
                            </p>

                        </div>
                    <?php endif; ?>
                    <div class="cleaner"></div>

                    <a href="/" class="btn btn-primary btn-lg">صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- signup-verification-page -->

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/home/scripts/signin.js"></script>