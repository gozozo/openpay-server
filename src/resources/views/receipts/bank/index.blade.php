<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('openpay.app_name')}}</title>
    <style>
        /* CSS Document */

        body {
            margin:0;
            font-family:Helvetica, Arial, sans-serf;
        }
        h3 {
            font-size:25px;
            margin:15px 0 0 0;
        }
        h4 {
            font-size:17px;
            margin:8px 0;
        }
        .whitepaper {
            background-color:#FFF;
            width:812px;
            height: 1075px;
            margin:0 auto;
            border:#D8D8D8 1px solid;
        }
        .Header {
            clear:both;
            float:left;
            width:84%;
            margin:4% 8% 4% 8%;
        }
        .Logo_empresa img {
            width:220px;
            float:left;
        }
        .Logo_paynet {
            float:right;
            margin-top:3px;
        }
        .Logo_paynet div {
            font-size:20px;
            font-weight:lighter;
            display:block;
            float:left;
            margin:10px 12px 0 0;
        }
        .Logo_paynet img {
            width:130px;
            float:left;
        }
        .Data {
            width:100%;
            clear:both;
            float:left;
        }
        .DT-margin {
            margin:5px 0;
            display:block;
            float:left;
            width:100%;
            clear:both;
        }
        .Big_Bullet {
            width:40px;
            float:left;
            margin-right:24px;
        }
        .Big_Bullet span, .col2 {
            background-color:#f9b317;
        }
        .Big_Bullet span {
            width:100%;
            height:55px;
            display:block;
        }
        .col1 {
            width:350px;
            float:left;
        }
        .col1 span {
            font-size:14px;
            clear:both;
            display:block;
            margin:5px 0;
        }
        .col1 small {
            font-size:12px;
            width:320px;
            display:block;
        }
        .col2 {
            width:358px;
            float:right;
            color:#FFF;
            padding:40px 0 40px 40px;
        }
        .col2 h1 {
            margin:0;
            padding:0;
            font-size:60px;
        }
        .col2 h1 span {
            font-size:45px;
        }
        .col2 h1 small {
            font-size:20px;
        }
        .col2 h2 {
            margin:0;
            font-size:22px;
            font-weight:lighter;
        }
        .Table-Data ,.Table-Info{
            margin:10px 0 0 0;
            clear:both;
            width:100%;
            display:block;
            float:left;
        }
        .table-row {
            float:left;
            width:83%;
            padding:0 8.5%;
        }
        .table-row div {
            float:left;
            width:250px;
            padding:15px 0;
        }
        .table-row span {
            float:left;
            border-left:3px solid #FFF;
            padding:15px 0 15px 40px;
        }
        .Table-Info .table-row {
            float: left;
            width: 100%;
            padding: 0;
        }
        .Table-Info .table-row div {
            float: left;
            width: 44.58%;
            padding: 15px 20px;
        }
        .Table-Info .table-row span {
            float: left;
            border-left: none;
            padding: 0;
            font-size: 15px;
            color: #565656;
        }
        .Table-Info .table-row div.title {
            color: black;
            margin: 10px 0;
            font-size: 16px;
            width: 100%;
            padding: 0;
        }
        .Table-Info .table-row div.title .middle{
            width: 45%;
            display: inline-block;
        }

        .Table-Info .table-row span.value {
            float: none;
            margin-left: 15px;
        }
        .color1 {
            background-color:#F3F3F3;
        }
        .color2 {
            background-color:#EBEBEB;
        }

        .col1 ol, .Col2 ol {
            font-size:12px;
            width:290px;
            padding-left:20px;
        }
        .col1 li, .Col2 li {
            padding:5px 0;
            line-height:16px;
        }
        .logos-bancos {
            clear: both;
            float: left;
            width: 99%;
            padding: 10px 0 10px 10px;
            border-top: 1px solid #EDEDED;
            border-bottom: 1px solid #EDEDED;
            margin: 20px 0 0 0;
        }
        .logos-bancos div {
            float:left;
            margin-right:50px;
        }
        .logos-bancos small {
            font-size:11px;
            margin-left:20px;
            float:left;
        }
        .logos-bancos ul {
            margin: 0px 42px;
            list-style: none;
            padding: 0;
            width: 380px;
            float: left;
        }
        .logos-bancos li {
            float: left;
            margin: 10px 10px 0 0px;
        }

        .Powered {
            width:100%;
            float:left;
            margin-top:31px;
        }
        .Powered img {
            margin-left:65px;
            margin-right:290px;
        }
        .Powered a {
            border-radius:6px;
            background-color:#0075F0;
            padding:7px 13px;
            color:#FFF;
            font-size:16px;
            font-weight:normal;
            text-decoration:none;
            margin:10px;
        }
        .Powered a:hover {
            background-color:#009BFF;
        }
    </style>
</head>
<body>
<div class="whitepaper">
    <div class="Header">
        <div class="Logo_empresa">
            <img src="{{config('openpay.app_logo')}}" alt="Logo">
        </div>
        <div class="Logo_paynet">
            <div>Transferencia interbancaria (SPEI)</div>
        </div>
    </div>
    <div class="Data">
        <div class="Big_Bullet">
            <span></span>
        </div>
        <div class="col1">
            <h3>Fecha límite de pago</h3>
            <h4>{{$charge->due_date==null?'No aplica' :\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sP', $charge->due_date)->formatLocalized('%d de %B %Y')}}</h4>
            <h3>Beneficiario:</h3>
            <h4>{{config('openpay.bank_beneficiary')}}</h4>
        </div>
        <div class="col2">
            <h2>Total a pagar</h2>
            <h1>${{explode('.', number_format($charge->amount,2))[0]}}<span>.{{explode('.', number_format($charge->amount,2))[1]}}</span><small> {{$charge->currency}}</small></h1>
        </div>
    </div>
    <div class="DT-margin"></div>
    <div class="Data">
        <div class="Big_Bullet">
            <span></span>
        </div>
        <div class="col1">
            <h3>Detalles de la compra</h3>
        </div>
    </div>
    <div class="Table-Data">
        <div class="table-row color1">
            <div>Descripción</div>
            <span>{{$charge->description}}</span>
        </div>
        <div class="table-row color2">
            <div>Fecha y hora</div>
            <span>{{\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sP', $charge->operation_date)->formatLocalized('%d de %B de %Y a las %H:%M')}}</span>
        </div>
        <div class="table-row color2" style="display:none">
            <div>&nbsp;</div>
            <span>&nbsp;</span>
        </div>
        <div class="table-row color1" style="display:none">
            <div>&nbsp;</div>
            <span>&nbsp;</span>
        </div>
    </div>
    <div class="DT-margin"></div>
    <div class="Data">
        <div class="Big_Bullet">
            <span></span>
        </div>
        <div class="col1">
            <h3>Pasos para realizar el pago</h3>
        </div>
    </div>
    <div class="Table-Info">
        <div class="table-row">
            <div class="color1" style="margin-right: 8px;min-height: 317px;" >
                <div class="title"><b>Desde BBVA Bancomer</b></div>
                <span>1. Dentro del menú de "Pagar" seleccione la opción "De Servicios" e ingrese el siguiente "Número de convenio CIE"</span>
                <div class="title"><b>Número de convenio CIE:</b><span class="value">{{$charge->payment_method->agreement}}</span></div>
                <span>2. Ingrese los datos de registro para concluir con la operación.</span>
                <div class="title"><b class="middle">Referencia:</b><span class="value">{{$charge->payment_method->name}}</span></div>
                <div class="title"><b class="middle">Importe:</b><span class="value">${{number_format($charge->amount,2)}} {{$charge->currency}}</span></div>
                <div class="title"><b class="middle">Concepto:</b><span class="value">{{$charge->description}}</span></div>
            </div>
            <div class="color1">
                <div class="title"><b>Desde cualquier otro banco</b></div>
                <span>1. Ingresa a la sección de transferencias y pagos o pagos a otros bancos y proporciona los datos de la transferencia:</span>
                <div class="title"><b class="middle">Beneficiario:</b><span class="value">{{config('openpay.bank_beneficiary')}}</span></div>
                <div class="title"><b class="middle">Banco destino:</b><span class="value">{{$charge->payment_method->bank}}</span></div>
                <div class="title"><b class="middle">Clabe:</b><span class="value">{{$charge->payment_method->clabe}}</span></div>
                <div class="title"><b class="middle">Concepto de pago:</b><span class="value">{{$charge->payment_method->name}}</span></div>
                <div class="title"><b class="middle">Referencia:</b><span class="value">{{$charge->payment_method->agreement}}</span></div>
                <div class="title"><b class="middle">Importe:</b><span class="value">${{number_format($charge->amount,2)}} {{$charge->currency}}</span></div>
            </div>
        </div>
    </div>

    <div class="logos-bancos">
        <ul>
            <li><img src="{{config('openpay.path_resources')}}/brand_bank1.png" width="180" height="30"></li>
            <li><img src="{{config('openpay.path_resources')}}/brand_bank2.png" width="180" height="30"></li>
        </ul>
        <div style="font-size:12px;height: 39px; width: 300px; float: right; margin-top: 10px; margin-right: 39px;">
            ¿Quieres pagar en otros bancos con servicio spei? visita: <a href="https://www.openpay.mx/bancos.html" target="_blank" style="text-decoration: none;color: black;">www.openpay.mx/bancos.html</a>
        </div>
    </div>
    <div class="Powered">
        <img src="{{config('openpay.path_resources')}}/powered_openpay.png" alt="Powered by Openpay" width="150">
        <a target="_blank" href="{{route('openpay.bank.print',$charge->id)}}">Imprimir</a>
        <a href="{{route(config('openpay.bank_redirect'))}}">Seguir comprando</a>
    </div>
</div>
<div style="height: 40px; width: 100%; float:left;"></div>

</body>
</html>