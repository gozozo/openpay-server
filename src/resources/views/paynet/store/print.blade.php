<!doctype html>
<html>
<head>
    <title>Openpay - Dashboard</title>
    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <meta charset="UTF-8">
    <style>
        /* CSS Document */

        body {
            margin:0;
            font-family:Helvetica, Arial, sans-serf;
            -webkit-print-color-adjust: exact;
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
            height: 90%;
            margin:0 auto;
            border:#D8D8D8 1px solid;
        }
        .Header {
            clear:both;
            float:left;
            width:84%;
            margin:4% 8% 4% 8%;
        }
        .Logo_empresa div {
            font-size:30px;
            font-weight:lighter;
            display:block;
            width:220px;
            height: 57.2px;
            float:left;
        //margin:10px 15px 0 0;
            text-align: center;
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
        .barcode {
            width:300px;
            height: 61px;
        }
        .Data {
            width:100%;
            clear:both;
            float:left;
        }
        .DT-margin {
            margin:2px 0;
            display:block;
            float:left;
            width:100%;
            clear:both;
            border:#FF0000 0px solid;
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
        .S-margin {
            padding-left:80px;
        }

        .Table-Data {
            margin:2px 0 0 0;
            clear:both;
            width:100%;
            display:block;
            float:left;
        }
        .table-row {
            float:left;
            width:83%;
            padding:0 8.0%;
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
        .logos-tiendas {
            clear:both;
            float:left;
            width:92%;
            padding:10px 0 10px 8%;
            border-top:1px solid #EDEDED;
            border-bottom:1px solid #EDEDED;
            margin:20px 0 0 0;
        }
        .logos-tiendas div {
            float:left;
            margin-right:50px;
        }
        .logos-tiendas small {
            font-size:11px;
            margin-left:20px;
            float:left;
        }
        .logos-tiendas ul {
            margin: 0;
            list-style: none;
            padding: 0;
            width: 480px;
            float: left;
        }
        .logos-tiendas li {
            float: left;
            margin: 10px 10px 0 10px;
        }

        .Powered {
            width:100%;
            height: 20px;
            float:left;
            margin-top:10px;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
</head>
<body>

<div class="whitepaper">
    <div class="Header">
        <div class="Logo_empresa">
            <img src="{{config('openpay.app_logo')}}" alt="Logo">
        </div>
        <div class="Logo_paynet">
            <div>Servicio a pagar</div>
            <img src="{{config('openpay.path_resources')}}/paynet_logo.png" alt="Logo Paynet">
        </div>
    </div>
    <div class="Data">
        <div class="Big_Bullet">
            <span></span>
        </div>
        <div class="col1">
            <h3>Fecha límite de pago</h3>
            <h4>{{$charge->due_date==null?'No aplica' :\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sP', $charge->due_date)->formatLocalized('%d de %B %Y, a las %H:%m')}}</h4>
            <img class="barcode" src="{{$charge->payment_method->barcode_url}}" alt="Código de Barras">
            <span>{{$charge->payment_method->reference}}</span>
            <small>En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.</small>
        </div>
        <div class="col2">
            <h2>Total a pagar</h2>
            <h1>${{number_format($charge->amount,0)}}<span>.{{explode('.', number_format($charge->amount,2))[1]}}</span><small> {{$charge->currency}}</small></h1>
            <h2 class="S-margin">+8 pesos por comisión</h2>
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
            <span>{{\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sP', $charge->operation_date)->formatLocalized('%d de %B de %Y a las %H:%m')}}</span>
        </div>
        <div class="table-row color1">
            <div>Correo del cliente</div>
            <span>{{$customer->email}}</span>
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
    <div>
        <div class="Big_Bullet">
            <span></span>
        </div>
        <div class="col1">
            <h3>Como realizar el pago</h3>
            <ol>
                <li>Acude a cualquier tienda afiliada</li>
                <li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet</li>
                <li>Realizar el pago en efectivo por {{number_format($charge->amount,2)}} {{$charge->currency}} (más $8 pesos por comisión)</li>
                <li>Conserva el ticket para cualquier aclaración</li>
            </ol>
            <small>Si tienes dudas comunícate a {{config('openpay.app_name')}} al teléfono {{config('openpay.app_phone')}} o al correo {{config('openpay.app_support_email')}}</small>
        </div>
        <div class="col1">
            <h3>Instrucciones para el cajero</h3>
            <ol>
                <li>Ingresar al menú de Pago de Servicios</li>
                <li>Seleccionar Paynet</li>
                <li>Escanear el código de barras o ingresar el núm. de referencia</li>
                <li>Ingresa la cantidad total a pagar</li>
                <li>Cobrar al cliente el monto total más la comisión de $8 pesos</li>
                <li>Confirmar la transacción y entregar el ticket al cliente</li>
            </ol>
            <small>Para cualquier duda sobre como cobrar, por favor llamar al teléfono (55) 5351 7371 en un horario de
                8am a 9pm de lunes a domingo
            </small>
        </div>
    </div>

    <div class="logos-tiendas">
        <ul>
            <li><img src="{{config('openpay.path_resources')}}/seven.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/circulok.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/fahorro.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/benavides.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/walmart.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/sams.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/bodega.png" width="100" height="50"></li>
            <li><img src="{{config('openpay.path_resources')}}/superama.png" width="100" height="50">
            </li>
        </ul>
        <div style="height: 90px; width: 190px; float: right; margin-top: 30px;">
            ¿Quieres pagar en otras tiendas? visítanos en: <a href="https://www.openpay.mx/tiendas" target="_blank" style="text-decoration: none;color: black;">www.openpay.mx/tiendas</a>
        </div>

    </div>
    <div class="Powered">
        <center>
            <img src="{{config('openpay.path_resources')}}/powered_openpay.png"
                 alt="Powered by Openpay" width="150">
        </center>
    </div>
</div>
</body>
</html>