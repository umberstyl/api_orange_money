<div class="panel">
        <div class="overlay hidden">
            <div class="overlay-content"><img src="loading.gif" alt="Processing..." /></div>
        </div>

        <div class="panel-heading">
            <h3 class="panel-title">TRX: <?php echo $Om['data']['payToken"']; ?></h3>
            <h6 class="panel-title">Total<?php echo $Om['data']['amount'].' Francs Cfa '; ?> </h6></br>
            <!-- Product Info -->  
            <p><b>Phone number :</b> <?php echo $Om['data']['subscriberMsisdn']; ?></p>
            <p><b>Tme :</b> <?php  echo $Om['data']['createtime'] ?></p></br>
        </div>
        <div class="panel-body">
            <!-- Display status message -->
            <div id="paymentResponse"> <?php  echo $Om['data']['status'] ?></div>
            <?php $link = "?status=chack&mp=".$mp."&paytoken=".$Om['data']['payToken"']; ?>
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container">
                <a href="<?php echo $link; ?>">
            </div>
        </div>

    </div>
    <script>

    </script>
