<?php 
include "db.php"; 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details - Hidden Kerala</title>
    <style>
        .btn-utility {
            background-color: #f0fdf4;
            color: #2d6a4f;
            border: 1px solid #2d6a4f;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-utility:hover {
            background-color: #2d6a4f;
            color: white;
        }
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background-color: #f9f9f9; color: #333; }
        .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .back-btn { display: inline-block; margin-bottom: 20px; color: #2d6a4f; text-decoration: none; font-weight: bold; }
        .gem-image { width: 100%; max-height: 450px; object-fit: cover; border-radius: 10px; margin-bottom: 20px; }
        .detail-section { margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px; }
        .label { font-weight: bold; color: #2d6a4f; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        .rating { color: #ffb703; font-size: 1.2rem; font-weight: bold; }
        
        /* Modal Styles */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; display: flex; align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 20px; border-radius: 12px; width: 80%; max-width: 700px; position: relative; }
        .close-btn { position: absolute; right: 15px; top: 10px; font-size: 24px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-btn">← Back to Explore</a>

    <?php
    if (isset($_GET['name'])) {
        $name = mysqli_real_escape_string($conn, $_GET['name']);
        
        $query = "SELECT * FROM hidden_places WHERE name = '$name' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store coordinates for the JS function
            $lat = $row['latitude'];
            $lng = $row['longitude'];
            
            // We CLOSE the PHP tag here so we can write HTML safely
            ?>
            
            <h1><?php echo htmlspecialchars($row['name']); ?></h1>

            <?php if(!empty($row['image'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="gem-image">
            <?php endif; ?>

            <p style="font-size: 1.1rem; line-height: 1.6; color: #555;">
                <?php echo htmlspecialchars($row['description']); ?>
            </p>

            <div class="detail-section">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p class="label">Best Season to Visit</p>
                        <p><?php echo htmlspecialchars($row['season']); ?></p>
                    </div>
                    <div>
                        <p class="label">Average Rating</p>
                        <p class="avg_rating">⭐ <?php echo htmlspecialchars($row['avg_rating']); ?>/5</p>
                    </div>
                </div>
            </div>

            <div class="detail-section">
        
                        <div class="label">Nearby Services</div>
    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
        <button type="button" onclick="openMapModal(<?php echo $lat; ?>, <?php echo $lng; ?>, 'hospitality')" class="btn-utility">
            🏨🍴 Stay & Eat
        </button>
        
        <button type="button" onclick="openMapModal(<?php echo $lat; ?>, <?php echo $lng; ?>, 'fuel')" class="btn-utility">
            ⛽ Petrol Pump
        </button>
        <button type="button" onclick="openMapModal(<?php echo $lat; ?>, <?php echo $lng; ?>, 'car_repair')" class="btn-utility">
            🛠️ Mechanic
        </button>
         <button type="button" onclick="openMapModal(<?php echo $lat; ?>, <?php echo $lng; ?>, 'Hospital')" class="btn-utility">
            🏥 Hospital
        </button>
    </div>
</div>
<div class="detail-section">
    <p class="label">Things to Do</p>
    <p style="line-height: 1.6; color: #555;">
        <?php echo nl2br(htmlspecialchars($row['things_to_do'] ?? 'No activities listed yet.')); ?>
    </p>
</div>

<div class="detail-section" style="text-align: center; border-top: none; margin-top: 10px;">
    <p class="label" style="margin-bottom: 10px;">Current Status</p>
    <span style="background: #e9f5ee; color: #2d6a4f; padding: 8px 20px; border-radius: 20px; font-size: 0.9rem; font-weight: bold; border: 1px solid #2d6a4f;">
        <?php echo htmlspecialchars($row['status'] ?? $row['review_status'] ?? 'Live on Site'); ?>
    </span>
</div>
                    </button>
                </div>
            </div>

           

            <?php
        } else {
            echo "<h2>Place not found!</h2>";
        }
    } else {
        echo "<h2>No destination selected.</h2>";
    }
    ?>
</div>

<div id="mapModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeMap()">&times;</span>
        <div id="map-container" style="height: 400px; width: 100%;"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="map.js"></script>

</body>
</html>