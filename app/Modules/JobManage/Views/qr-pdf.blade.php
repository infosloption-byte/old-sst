<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Job Scan - SISFS</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}
		</style>
	</head>

	<body>
		<table style="width: 100%">
			<tr>
				<td style="text-align: center;height: 40px;"></td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<h1 style="color: #488f3a">Scan Here To Start Job</h1>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;height: 20px;"></td>
			</tr>
		</table>

		<table style="width: 100%;" style="padding: 10px;border-radius: 10px;" border="1">
			<tr>
				<td style="text-align: center;">
					<img src="http://chart.apis.google.com/chart?cht=qr&chl={{$job}}&chs=500">
				</td>
			</tr>
		</table>
		<table style="width: 100%">
			<tr>
				<td style="text-align: center;height: 20px;"></td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<p>Refernce No - {{$job}}</p>	
				</td>
			</tr>
			<tr>
				<td style="text-align: center;height: 20px;"></td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<img src="{{url('storage/image/sis.png')}}" alt="Company logo" style="width: 100px;"/>
				</td>
			</tr>
		</table>
	</body>
</html>