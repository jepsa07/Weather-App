<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather App | Laravel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .weather-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .temp {
            font-size: 60px;
            font-weight: bold;
        }
        .desc {
            text-transform: capitalize;
            color: #555;
        }
    </style>
</head>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                window.location.href =
                    "{{ route('location.weather') }}" +
                    "?lat=" + lat + "&lon=" + lon;
            },
            function() {
                alert("Location permission denied!");
            }
        );
    } else {
        alert("Geolocation not supported.");
    }
}
</script>

<body>

<div class="weather-card text-center">
    <h3 class="mb-3">🌤 Laravel Weather App</h3>
    <button onclick="getLocation()" class="btn btn-success mb-3 w-100">
    📍 Use My Location
</button>


    <form method="GET" action="{{ route('weather') }}">
        <div class="input-group mb-3">
            <input type="text" name="city" class="form-control" placeholder="Enter city (Delhi)" required>
            <button class="btn btn-primary">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>

    @if(session('error'))
        <div class="alert alert-danger p-2">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($weather['main']))
        <h4 class="mt-3">{{ $weather['name'] }}, {{ $weather['sys']['country'] }}</h4>

        <div class="temp">
            {{ round($weather['main']['temp']) }}°C
        </div>

        <p class="desc">
            <i class="fa-solid fa-cloud"></i>
            {{ $weather['weather'][0]['description'] }}
        </p>

        <div class="row mt-3">
            <div class="col">
                <i class="fa-solid fa-wind"></i><br>
                {{ $weather['wind']['speed'] }} m/s
            </div>
            <div class="col">
                <i class="fa-solid fa-droplet"></i><br>
                {{ $weather['main']['humidity'] }} %
            </div>
        </div>
    @endif
    @if(isset($forecast['list']))
<hr>

<h5 class="mt-4">🕒 Next 24 Hours</h5>

<div class="d-flex overflow-auto gap-3 mt-3 pb-2">
    @foreach(array_slice($forecast['list'], 0, 8) as $hour)
        <div class="text-center p-3 bg-light rounded" style="min-width:120px;">
            <small>
                {{ \Carbon\Carbon::parse($hour['dt_txt'])->format('h A') }}
            </small>

            <div class="fw-bold mt-1">
                {{ round($hour['main']['temp']) }}°C
            </div>

            <small class="text-muted">
                {{ $hour['weather'][0]['main'] }}
            </small>
        </div>
    @endforeach
</div>
@endif
</div>



</body>
</html>
