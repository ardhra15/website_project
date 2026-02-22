<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seasonal Splendors - Kerala</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .seasonal-container { max-width: 1000px; margin: 50px auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .season-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px; }
        .season-card img { width: 100%; height: 200px; object-fit: cover; }
        h1 { text-align: center; color: #2d6a4f; margin-top: 50px; }
    </style>
</head>
<body>

    <a href="index.php" style="text-decoration: none; color: #2d6a4f; font-weight: bold;">← Back to Home</a>
    <h1>Seasonal Splendors of Kerala</h1>

    <div class="seasonal-container">
        <div class="season-card">
            <img src="images/monsoon.jpg" alt="Monsoon">
            <h3 style="color: #2d6a4f;">Monsoon Magic (June - Aug)</h3>
            <p style="padding: 0 15px; color: #666;">Rain-washed greenery and Ayurvedic treatments.</p>
        </div>

        <div class="season-card">
            <img src="images/winter.jpg" alt="Winter">
            <h3 style="color: #2d6a4f;">Winter Bliss (Sept - Mar)</h3>
            <p style="padding: 0 15px; color: #666;">Perfect weather for backwaters and trekking.</p>
        </div>

        <div class="season-card">
            <img src="images/summer.jpg" alt="Summer">
            <h3 style="color: #2d6a4f;">Summer Escape (April - May)</h3>
            <p style="padding: 0 15px; color: #666;">Cool hill stations like Munnar and Wayanad.</p>
        </div>
    </div>

</body>
</html>

