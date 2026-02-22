<?php 
include "db.php"; 
session_start(); // Always start sessions at the very top
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hidden Places - Kerala</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .hero-section { background-color: #2d6a4f; color: white; text-align: center; padding: 80px 20px; border-radius: 15px; margin-bottom: 40px; }
        .district-link { padding: 10px 20px; background: #2d6a4f; color: white; border-radius: 20px; text-decoration: none; display: inline-block; margin: 5px; transition: 0.2s; }
        .district-link:hover { background: #1b4332; }
        .gem-card { border: 1px solid #ddd; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.3s; display: flex; flex-direction: column; height: 100%; }
        .gem-card:hover { box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .share-btn { background:#ffb703; color:white; padding:15px 30px; text-decoration:none; border-radius:30px; font-weight:bold; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block; transition: 0.3s; }
        .share-btn:hover { background: #e0a202; transform: scale(1.05); }
    </style>
</head>
<body>

<nav style="background: #2d6a4f; padding: 15px 30px; color: white; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-weight: bold; font-size: 1.2rem;">Hidden Kerala</div>
    <div>
        <?php if(isset($_SESSION['username'])): ?>
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span> | 
            <a href="profile.php" style="color: white; text-decoration: none;">My Profile</a> | 
            <a href="logout.php" style="color: #ffcccc; text-decoration: none;">Logout</a>
        <?php else: ?>
            <a href="login.php" style="color: white; text-decoration: none;">Login to Explore</a>
        <?php endif; ?>
    </div>
</nav>


    <div class="container">
    <div class="hero-section">
        <h1 style="font-size: 2.5rem; margin-bottom: 10px;">Discover Kerala's Hidden Treasures</h1>
        <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.9;">Explore user-suggested destinations with complete travel guidance.</p>
        <a href="#explore-section" style="background-color: #1b4332; color: white; padding: 15px 35px; border-radius: 30px; text-decoration: none; font-weight: bold;">Get Started</a>
    </div>

    <section style="padding: 40px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px; ">
        <div class="feature-card">max
            <div style="font-size: 40px; margin-bottom: 20px;">🗺️</div>
            <h3 style="color: #2d6a4f;">Hidden Places</h3>
            <p style="color: #777; font-size: 14px;">Gems shared by our community.</p>
        </div>
        <a href="seasonal.php" style="text-decoration: none; color:inherit;">
            <div class="feature-card">
                <div style="font-size: 40px; margin-bottom: 10px;">🌸</div>
                <h3 style="color: #2d6a4f;">Seasonal Splendors</h3>
                <p style="color: #777; font-size: 14px;">Experience Kerala in every season.</p>
            </div>
            </a>
        <div class="feature-card">
            <div style="font-size: 40px; margin-bottom: 10px;">🍽️</div>
            <h3 style="color: #2d6a4f;">Local Dining</h3>
            <p style="color: #777; font-size: 14px;">Authentic flavors.</p>
        </div>
        <a href="Transport.php" style="text-decoration: none; color:inherit;">
        <div class="feature-card">
            <div style="font-size: 40px; margin-bottom: 10px;">🚕</div>
            <h3 style="color: #2d6a4f;">Transport</h3>
            <p style="color: #777; font-size: 14px;">Easy commutes.</p>
        </div>
        </section>
        <div style="max-width: 600px; margin: 0 auto 40px auto; text-align: center;">
    <form action="index.php#explore-section" method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Search for a hidden gem (e.g. Vypin, Dam)..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
               style="flex: 1; padding: 12px 20px; border: 2px solid #2d6a4f; border-radius: 30px; outline: none;">
        <button type="submit" style="background: #2d6a4f; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; font-weight: bold;">
            Search
        </button>
        <?php if(isset($_GET['search'])): ?>
            <a href="index.php#explore-section" style="padding: 12px; color: #777; text-decoration: none;">Clear</a>
        <?php endif; ?>
    </form>
</div>

    <div style="text-align: center; margin: -20px 0 40px 0;">
        <a href="submit_gem.php" class="share-btn">
            + Share a Hidden Gem & Earn 50 Points
        </a>
        <p style="color: #666; font-size: 0.9rem; margin-top: 10px;">Know a place that isn't on the map? Add it here!</p>
    </div>

    <div id="explore-section" style="padding: 20px 0;">
        <h2 style="color: #2d6a4f; text-align: center;">Explore by District</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin: 20px 0;">
            <a href="index.php#explore-section" class="district-link" style="background: #444;">All Districts</a>
            <?php
            $d = mysqli_query($conn, "SELECT * FROM districts");
            while($row = mysqli_fetch_assoc($d)) {
                echo "<a href='index.php?id=".$row['district_id']."#explore-section' class='district-link'>".htmlspecialchars($row['district_name'])."</a>";
            }
            ?>
        </div>

        <?php
// 1. Capture inputs from the URL (District ID or Search Keyword)
$selected_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : null;

// 2. Set the default title and the MUST-HAVE filter
$display_title = "Explore All Hidden Gems"; 
$status_filter = "review_status = 'Live on Site'"; // Only shows approved places

// 3. The Decision Logic (The "Logic Box")
if ($selected_id && $search_query) {
    // Scenario: User picked a District AND typed a search word
    $gem_query = "SELECT * FROM hidden_places WHERE district_id = '$selected_id' AND name LIKE '%$search_query%' AND $status_filter";
    $display_title = "Results for '$search_query'";
} elseif ($selected_id) {
    // Scenario: User only clicked a District link
    $gem_query = "SELECT * FROM hidden_places WHERE district_id = '$selected_id' AND $status_filter";
    $dist_res = mysqli_query($conn, "SELECT district_name FROM districts WHERE district_id = '$selected_id'");
    if($d_row = mysqli_fetch_assoc($dist_res)) $display_title = "Hidden Gems in " . $d_row['district_name'];
} elseif ($search_query) {
    // Scenario: User only used the Search Bar
    $gem_query = "SELECT * FROM hidden_places WHERE name LIKE '%$search_query%' AND $status_filter";
    $display_title = "Search results for '$search_query'";
} else {
    // Scenario: Default view (No search, no district selected)
    $gem_query = "SELECT * FROM hidden_places WHERE $status_filter";
}

// 4. Run the final query
$gem_result = mysqli_query($conn, $gem_query);

// 5. Error Trap: If the query fails, show the error instead of a blank page
if (!$gem_result) {
    die("Database Error: " . mysqli_error($conn));
}
?>

        <h2 style="text-align: center; margin-top: 30px; color: #2d6a4f;"><?php echo htmlspecialchars($display_title); ?></h2>

        <div class="gems-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; padding: 20px;">
            <?php
            if ($gem_result && mysqli_num_rows($gem_result) > 0) {
                while($gem = mysqli_fetch_assoc($gem_result)) {
                    $place_name = $gem['name'] ?? "Hidden Place";
                    ?>
                    <div class='gem-card'>
                        <div style="width:100%; height:200px; background:#eee; display:flex; align-items:center; justify-content:center;">
                            <?php if(!empty($gem['image'])): ?>
                                <img src='uploads/<?php echo htmlspecialchars($gem['image']); ?>' style='width:100%; height:100%; object-fit:cover;' alt='<?php echo htmlspecialchars($place_name); ?>'>
                            <?php else: ?>
                                <span style="color:#999;">No Image Available</span>
                            <?php endif; ?>
                        </div>
                        
                        <div style='padding: 15px;'>
                            <h4 style="margin: 0 0 10px 0; color: #2d6a4f;"><?php echo htmlspecialchars($place_name); ?></h4>
                            <p style='color: #777; font-size: 14px; margin-bottom: 15px;'>
                                <?php echo htmlspecialchars(substr($gem['description'], 0, 100)) . '...'; ?>
                            </p>
                            <a href='details.php?name=<?php echo urlencode($place_name); ?>' style='color: #2d6a4f; font-weight: bold; text-decoration: none;'>View Details →</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align: center; color: #666; padding: 40px;'>No hidden gems found for this selection yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<footer style="background: #2d6a4f; color: white; padding: 40px 20px; text-align: center; margin-top: 50px;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; text-align: left;">
        <div>
            <h3 style="border-bottom: 2px solid #fff; display: inline-block; padding-bottom: 5px;">Hidden Kerala</h3>
            <p style="font-size: 14px; line-height: 1.6; margin-top: 15px;">
                Discovering the untouched beauty of God's Own Country. We provide travel guides and support for exploring lesser-known destinations.
            </p>
        </div>
        <div>
            <h3 style="border-bottom: 2px solid #fff; display: inline-block; padding-bottom: 5px;">Quick Links</h3>
            <ul style="list-style: none; padding: 0; margin-top: 15px; font-size: 14px;">
                <li style="margin-bottom: 10px;"><a href="#explore-section" style="color: white; text-decoration: none;">Explore Districts</a></li>
                <li style="margin-bottom: 10px;"><a href="login.php" style="color: white; text-decoration: none;">Login / Register</a></li>
            </ul>
        </div>
        <div>
            <h3 style="border-bottom: 2px solid #fff; display: inline-block; padding-bottom: 5px;">Contact Us</h3>
            <p style="font-size: 14px; margin-top: 15px;">📍 Kozhikode, Kerala</p>
            <p style="font-size: 14px;">📧 support@hiddenkerala.com</p>
            <p style="font-size: 14px;">📞 +91 98765 43210</p>
        </div>
    </div>
    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.2); margin: 30px 0;">
    <p style="font-size: 12px; opacity: 0.8;">&copy; 2026 Hidden Kerala Travel Portal. All rights reserved.</p>
    <div style="margin-top: 20px; opacity: 0.5;">
        <a href="admin_login.php" style="color: white; text-decoration: none; font-size: 12px;">Admin Portal</a>
    </div>
</footer>

</body>
</html>