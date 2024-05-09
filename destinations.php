<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Destinations - AirCucho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }
        body {
        padding-top: 50px; 
    }
    .navbar {
    display: flex; 
    justify-content: center; 
    align-items: center; 
    width: 100%; 
    position: fixed; 
    top: 0; 
    left: 0;
    z-index: 1000; 
    background-color: #333; 
    overflow: hidden; 
    font-family: Arial, sans-serif;
    height: 50px; 
}


.navbar a {
    display: block; 
    color: #f2f2f2; 
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
}


.navbar a:hover {
    background-color: #ddd;
    color: black;
}

   
    .navbar::after {
        content: "";
        clear: both;
        display: table;
    }
        .container {
            width: 80%;
            margin: auto;
        }
        .destination {
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            color: white;
            background-size: cover;
            background-position: center;
            position: relative;
            height: 200px; 
            display: flex;
            align-items: center; 
            justify-content: center; 
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7); 
        }
        h1, h2 {
            text-align: center;
        }
        h2 {
            margin: 0;
            padding: 20px; 
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="navbar">
        <a href="index.html">Home</a>
        <a href="flights.php">See Flights</a>
    </div>
    <div class="container">
        <h1>Explore Top Destinations</h1>
        <?php
        $destinations = [
            ['name' => 'Paris', 'description' => 'The City of Light draws millions of visitors every year with its unforgettable ambiance.', 'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg/640px-La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg'],
            ['name' => 'Tokyo', 'description' => 'Tokyo is a marvelous mix of modern living and old-fashioned manners.', 'image_url' => 'https://img.freepik.com/foto-gratis/vista-aerea-paisaje-urbano-tokio-montana-fuji-japon_335224-148.jpg?size=626&ext=jpg&ga=GA1.1.672697106.1714348800&semt=ais'],
            ['name' => 'Cairo', 'description' => 'Egypt’s capital is a chaotic city with a long and turbulent history.', 'image_url' => 'https://www.kolaboo.com/blog/wp-content/uploads/2022/01/piramides-egipto-gran-esfinge.jpg']
        ];

        foreach ($destinations as $destination) {
            echo "<div class='destination' style='background-image: url(\"" . htmlspecialchars($destination['image_url']) . "\");'>";
            echo "<h2>" . htmlspecialchars($destination['name']) . "</h2>";
            echo "<p>" . htmlspecialchars($destination['description']) . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
