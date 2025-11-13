<?php use App\Order; ?>
   
       <script>
        window.onload = function() {
            document.getElementById('payfast-form').submit();
        }
    </script>

                <?php
                $orderDetails = Order::getOrderDetails(Session::get('order_id'));
                $orderDetails = json_decode(json_encode($orderDetails));
                /*echo "<pre>"; print_r($orderDetails); die;*/
                $nameArr = explode(' ',$orderDetails->name);
                $getCountryCode = Order::getCountryCode($orderDetails->country);
                ?>
                <form id="payfast-form" action="https://www.payfast.co.za/eng/process" method="POST">
                    <input type="hidden" name="merchant_id" value="13013445">
                    <input type="hidden" name="merchant_key" value="kz6v5zebgr2xh">
                       <input type="hidden" name="return_url" value="https://helpmyworldpublishing.com/thanks">
                    <input type="hidden" name="cancel_url" value="https://helpmyworldpublishing.com/cancel">
                    <input type="hidden" name="notify_url" value="{{ url('itn') }}">
                      <input type="hidden" name="name_first" value="{{ $nameArr[0] }}">
                    <input type="hidden" name="name_last" value="{{ $nameArr[1] ?? ''}}">
                    <input type="hidden" name="email_address" value="{{ $orderDetails->user_email }}">
                    <input type="hidden" name="m_payment_id" value="{{ Session::get('order_id') }}">
                    <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
                    <input type="hidden" name="item_name" value="Order {{ Session::get('order_id') }}">
                     <input type="hidden" name="passphrase" value="Rorisang/Maimane/6923_">
                    <input type="hidden" id="signature" name="signature">
                </form>
               
<?php
Session::forget('grand_total');
Session::forget('order_id');
?>


