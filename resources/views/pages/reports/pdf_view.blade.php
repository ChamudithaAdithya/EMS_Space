<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Achievement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #ff0606;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .certificate {
            border: 10px solid #ddd;
            padding: 20px;
            width: 70%;
            /* max-width: 800px; */
            height: auto;
            margin: 0 auto;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #dddddd
        }
        .certificate h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }
        .certificate h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .certificate p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .signature {
            margin-top:0px;
            /* display: flex;
            justify-content: space-between; */
            width: 100%;
        }
       
        .signature img {
            width: 80px; /* Adjust the size as needed */

            /* display: block;
            margin: 0 auto; */
        }
        .logo img {
            width: 150px; /* Adjust the size as needed */
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="logo">
            {{-- <img src="../storage/app/public/images/logo.png" alt=" "> --}}
        </div>
        <h1>Certificate of Achievement</h1>
        <h2>ACCIMT</h2>
        <p>This is to certify that</p>
        <p><strong>HARINDU ASHEN</strong></p>
        <p>has successfully completed</p>
        <p><strong>Water Rocket</strong></p>
        <p>on</p>
        <p><strong>2024/08/01</strong></p>
        
        <div class="row">
            <div class="col-6">
                <div class="signature" >
                    {{-- <div style="text-align: left">
                        <img style="text-align: left" src="../storage/app/public/images/signatrure.png" alt="Instructor Signature">
                        <p style="text-align: left">Instructor</p>
                    </div> --}}
                </div>
            </div>
            <div class="col-6">
                <div class="signature" >
                    {{-- <div style="text-align:right">
                        <img style="text-align: right" src="../storage/app/public/images/signatrure.png" alt="Director Signature">
                        <p style="text-align: right">Director</p>
                    </div> --}}
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
