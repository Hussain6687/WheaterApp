<?php
// Array of countries with two cities each
$cities = [
    'USA' => ['New York', 'Los Angeles'],
    'UK' => ['London', 'Manchester'],
    'France' => ['Paris', 'Marseille'],
    'Germany' => ['Berlin', 'Munich'],
    'Australia' => ['Sydney', 'Melbourne'],
    'Canada' => ['Toronto', 'Vancouver'],
    'Brazil' => ['Rio de Janeiro', 'São Paulo'],
    'India' => ['Mumbai', 'Delhi'],
    'China' => ['Beijing', 'Shanghai'],
    'Japan' => ['Tokyo', 'Osaka'],
    'Russia' => ['Moscow', 'Saint Petersburg'],
    'Italy' => ['Rome', 'Milan'],
    'Mexico' => ['Mexico City', 'Guadalajara'],
    'South Africa' => ['Cape Town', 'Johannesburg'],
    'Turkey' => ['Istanbul', 'Ankara'],
    'Egypt' => ['Cairo', 'Alexandria'],
    'Argentina' => ['Buenos Aires', 'Córdoba'],
    'Spain' => ['Madrid', 'Barcelona'],
    'Pakistan' => ['Karachi', 'Lahore'],
    'UAE' => ['Dubai', 'Abu Dhabi'],
    'South Korea' => ['Seoul', 'Busan'],
    'Saudi Arabia' => ['Riyadh', 'Jeddah'],
    'New Zealand' => ['Auckland', 'Wellington'],
    'Malaysia' => ['Kuala Lumpur', 'George Town'],
    'Thailand' => ['Bangkok', 'Chiang Mai'],
    'Indonesia' => ['Jakarta', 'Surabaya'],
    'Philippines' => ['Manila', 'Cebu'],
    'Vietnam' => ['Hanoi', 'Ho Chi Minh City'],
    'Bangladesh' => ['Dhaka', 'Chittagong'],
    'Nigeria' => ['Lagos', 'Abuja'],
    'Kenya' => ['Nairobi', 'Mombasa'],
    'Chile' => ['Santiago', 'Valparaíso'],
    'Colombia' => ['Bogotá', 'Medellín'],
    'Venezuela' => ['Caracas', 'Maracaibo'],
    'Peru' => ['Lima', 'Cusco'],
    'Portugal' => ['Lisbon', 'Porto'],
    'Greece' => ['Athens', 'Thessaloniki'],
    'Sweden' => ['Stockholm', 'Gothenburg'],
    'Norway' => ['Oslo', 'Bergen'],
    'Denmark' => ['Copenhagen', 'Aarhus'],
    'Finland' => ['Helsinki', 'Tampere'],
    'Netherlands' => ['Amsterdam', 'Rotterdam'],
    'Belgium' => ['Brussels', 'Antwerp'],
    'Poland' => ['Warsaw', 'Krakow'],
    'Austria' => ['Vienna', 'Salzburg'],
    'Switzerland' => ['Zurich', 'Geneva'],
    'Czech Republic' => ['Prague', 'Brno'],
    'Hungary' => ['Budapest', 'Debrecen'],
    'Romania' => ['Bucharest', 'Cluj-Napoca']
];

// Function to loop through the cities and generate datalist options
function generateCityOptions($cities)
{
    $options = '';
    foreach ($cities as $country => $cityList) {
        foreach ($cityList as $city) {
            $options .= "<option value='{$city}, {$country}'>\n";
        }
    }
    return $options;
}


function getWeather($city = 'karachi')
{
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=5dac994d4bda09fa20625b62319e30a9";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result;
}
$city = 'Karachi';
if (isset($_POST['submit']) && !empty($_POST['city'])) {
    $cityCountry = explode(',', $_POST['city']);
    $city = trim(str_replace(' ', '%20', $cityCountry[0]));
    $country = trim($cityCountry[1]);
}
// $str = 'this is my name, hussain';
// $name = explode(',', $str);
// $name = trim(str_replace(' ', '%', $str[0]));
// print_r($name);


// echo '<pre>';
$getWeahter = getWeather($city);
// print_r($getWeahter);
// die;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="weather-app">
        <!-- Weather Info -->
        <div class="current-weather">

            <h1 id="location"><?= $getWeahter['name']; ?></h1>

            <div class="weather-icon">
                <!-- This will be dynamically updated using the OpenWeather API's icon code -->
                <img id="weather-icon" src="https://openweathermap.org/img/wn/<?= $getWeahter['weather'][0]['icon']; ?>@2x.png" alt="Weather Icon" />
            </div>
            <h2 id="temperature"><?= round($getWeahter['main']['temp'] - 273.15) ?? 'error'; ?>C°</h2>
            <div class="range">
                <span id="low"><?= round($getWeahter['main']['temp_min'] - 273.15) ?? 'error'; ?> C°</span>
                <span id="high"><?= round($getWeahter['main']['temp_max'] - 273.15) ?? 'error'; ?> C°</span>
            </div>
            <p id="description"><?= $getWeahter['weather'][0]['main']; ?></p>
            <p id="description">Wind: <?= $getWeahter['wind']['speed']; ?> M/H</p>
            <p id="description">Date: <?= date('d-M-y', $getWeahter['dt']) ?></p>

        </div>

        <!-- Forecast Section -->
        <!-- <div class="forecast">
            <div class="day">
                <p>Mon</p>
                <img id="icon-mon" src="" alt="Weather Icon" />
                <p class="temp">22/16</p>
            </div>
            <div class="day">
                <p>Tue</p>
                <img id="icon-tue" src="" alt="Weather Icon" />
                <p class="temp">20/13</p>
            </div>
            <div class="day">
                <p>Wed</p>
                <img id="icon-wed" src="" alt="Weather Icon" />
                <p class="temp">18/11</p>
            </div>
            <div class="day">
                <p>Thu</p>
                <img id="icon-thu" src="" alt="Weather Icon" />
                <p class="temp">22/16</p>
            </div>
            <div class="day">
                <p>Fri</p>
                <img id="icon-fri" src="" alt="Weather Icon" />
                <p class="temp">25/14</p>
            </div>
        </div> -->



        <!-- City Search Form -->
        <div class="search">
            <form method="POST" action="">
                <label for="city">Choose a city:</label>
                <input type="text" name="city" id="city" list="cities" placeholder="Enter city name..." required>
                <datalist id="cities">
                    <?php echo generateCityOptions($cities); ?>
                </datalist>
                <button type="submit" name='submit'>Get Weather</button>
            </form>
        </div>
    </div>
    </div>
    <script src="script.js"></script>
</body>

</html>