<html>

<head>
	<style>
		.box {
			width: 97%;
			height: auto;
			min-height: 200px;
			/* background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(255, 192, 0, 1)); */
			padding: 1%;
            border:2px solid green;
		}

		.center {
			text-align: center;
            color:green;
            font-weight:bold;
		}

		.btn {
			padding: 2px;
			height: 50px;
			width: 200px;
			border-radius: 6%;
			font-size: 15px;
			outline-color: grey;
		}

        #logo{
            width:100px;
            height:100px;
        }


	</style>
</head>

<body>
	<div class="box">
		
		<h1 class="center"><?= $message;?></h1>
        <center>
        <img id="logo" src="http://sp.istmein.de:8080/mui/assets/logo/mui.png" alt="">
		<!-- <p class="center">Klik tombol dibawah untuk verifikasi akun anda</p> -->
		</center>
	</div>
</body>

</html>
