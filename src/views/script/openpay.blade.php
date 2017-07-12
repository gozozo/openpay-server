<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        OpenPay.setId('{{config('openpay.id')}}');
        OpenPay.setApiKey('{{config('openpay.pk')}}');
        OpenPay.setSandboxMode({{config('openpay.sandbox')}});
        var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    });
</script>