
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/styles.css')}}" rel="stylesheet">  
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
		<script>
		<?php 
		$sr = 1;
		$countdate = '2020-07-30 11:39:21';
		$countdate = date('m/d/Y H:i:s', strtotime($countdate)); ?>
		var end = new Date(<?php echo "'".$countdate." GMT+0400'";?>);
		var _second = 1000;
		var _minute = _second * 60;
		var _hour = _minute * 60;
		var _day = _hour * 24;
		var timer;

		function getESTOffset() {
			return new Date().getTimezoneOffset() - (end.getTimezoneOffset())
		}

		function showRemaining() {
			var now = new Date();
			var distance = end - now - getESTOffset() * _hour;
			if (distance < 0) {
				clearInterval(timer);
                    if(!window.location.hash) {
					window.location = window.location + '#loaded';
					window.location.reload();
					}
				return;
			}
			var days = Math.floor(distance / _day);
			var hours = Math.floor((distance % _day) / _hour);
			var minutes = Math.floor((distance % _hour) / _minute);
			var seconds = Math.floor((distance % _minute) / _second);
		if(hours < '10'){ var hours = '0'+ hours; }
		if(minutes < '10'){ var minutes = '0'+ minutes; }
		if(seconds < '10'){ var seconds = '0'+ seconds; }
		if(days > 0){ var showdays = '<span class="timeboxmain">'+ days + ' : <span class="timebox">DAYS</span></span>'; }
		else { var showdays = ''; }
		document.getElementById('timcounter').innerHTML = showdays + '<span class="timeboxmain">'+ hours + ' : <span class="timebox">HRS</span></span>' + '<span class="timeboxmain">'+ minutes + ' : <span class="timebox">MINS</span></span>' + '<span class="timeboxmain">'+ seconds + '<span class="timebox">SECS</span></span>'; 
		}
		timer = setInterval(showRemaining, 1000);
		</script>
    </head>
    <body>
        <div class="flex-center position-ref homebg full-height">
            

            <div class="content">
                <div class="title m-b-md" s>
                   
					Coming soon
                </div>
				<h1 class="block text-center text-white bold winnertimecounter" id="timcounter"></h1>
        
                
            </div>
        </div>
    </body>
	<script type="text/javascript">
		var plugin_path = 'public/plugins/';
		</script>
		<script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.1.4.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
		
	
</html>
