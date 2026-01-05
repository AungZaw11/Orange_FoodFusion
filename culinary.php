<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = Database::connect();

// Handle resource download
if (isset($_GET['download'])) {
    $resource_id = intval($_GET['download']);
    $stmt = $db->prepare("SELECT * FROM resources WHERE id = ? AND type IN ('recipe_card', 'tutorial', 'video')");
    $stmt->execute([$resource_id]);
    $resource = $stmt->fetch();
    
    if ($resource) {
        // Increment download count
        $update_stmt = $db->prepare("UPDATE resources SET download_count = download_count + 1 WHERE id = ?");
        $update_stmt->execute([$resource_id]);
        
        // In a real application, you would serve the file for download
        // For this example, we'll just show a success message
        $message = displayMessage('Download started: ' . htmlspecialchars($resource['title']), 'success');
    }
}

// Get culinary resources
$culinary_resources = $db->query("
    SELECT * FROM resources 
    WHERE type IN ('recipe_card', 'tutorial', 'video') 
    ORDER BY download_count DESC
")->fetchAll();

// Get resource categories
$categories = $db->query("SELECT DISTINCT category FROM resources WHERE category IS NOT NULL")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Resources - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }
        .resource-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .resource-card:hover {
            transform: translateY(-5px);
        }
        .resource-header {
            background: #ff9800;
            color: white;
            padding: 15px;
        }
        .resource-body {
            padding: 20px;
        }
        .resource-footer {
            background: #fff8e1;
            padding: 15px;
            border-top: 1px solid #ffcc80;
        }
        .resource-type {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-right: 10px;
        }
        .recipe-card { background: #4CAF50; color: white; }
        .tutorial { background: #2196F3; color: white; }
        .video { background: #FF5722; color: white; }
        .download-btn {
            background: #ff9800;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .download-count {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Culinary Resources</h1>
        <p class="subtitle">Download recipe cards, tutorials, and cooking videos to enhance your culinary skills.</p>
        
        <?php echo $message ?? ''; ?>
        
        <!-- Resource Filter -->
        <div class="filters" style="margin: 20px 0;">
            <form method="GET" action="">
                <select name="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['category']; ?>" <?php echo ($_GET['category'] ?? '') == $cat['category'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="type" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="recipe_card" <?php echo ($_GET['type'] ?? '') == 'recipe_card' ? 'selected' : ''; ?>>Recipe Cards</option>
                    <option value="tutorial" <?php echo ($_GET['type'] ?? '') == 'tutorial' ? 'selected' : ''; ?>>Tutorials</option>
                    <option value="video" <?php echo ($_GET['type'] ?? '') == 'video' ? 'selected' : ''; ?>>Videos</option>
                </select>
            </form>
        </div>
        
        <!-- Resource Statistics -->
        <div class="stats" style="background: #fff8e1; padding: 15px; border-radius: 10px; margin: 20px 0;">
            <h3>Resource Library</h3>
            <p>
                <strong>Total Resources:</strong> <?php echo count($culinary_resources); ?> |
                <strong>Most Downloaded:</strong> 
                <?php 
                if (count($culinary_resources) > 0) {
                    $most_downloaded = $culinary_resources[0];
                    echo htmlspecialchars($most_downloaded['title']) . ' (' . $most_downloaded['download_count'] . ' downloads)';
                } else {
                    echo 'No resources yet';
                }
                ?>
            </p>
        </div>
        
        <!-- Resource Grid -->
        <?php if (count($culinary_resources) > 0): ?>
            <div class="resource-grid">
                <?php foreach ($culinary_resources as $resource): 
                    // Skip if filtered
                    if ((isset($_GET['category']) && $_GET['category'] && $resource['category'] != $_GET['category']) ||
                        (isset($_GET['type']) && $_GET['type'] && $resource['type'] != $_GET['type'])) {
                        continue;
                    }
                ?>
                    <div class="resource-card">
                        <div class="resource-header">
                            <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                            <span class="resource-type <?php echo $resource['type']; ?>">
                                <?php 
                                $type_labels = [
                                    'recipe_card' => 'Recipe Card',
                                    'tutorial' => 'Tutorial',
                                    'video' => 'Video',
                                    'infographic' => 'Infographic'
                                ];
                                echo $type_labels[$resource['type']] ?? $resource['type'];
                                ?>
                            </span>
                            <?php if ($resource['category']): ?>
                                <span style="color: #fff; font-size: 14px;">• <?php echo htmlspecialchars($resource['category']); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="resource-body">
                            <?php if ($resource['description']): ?>
                                <p><?php echo htmlspecialchars($resource['description']); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($resource['type'] == 'video'): ?>
                                <div style="background: #f5f5f5; padding: 10px; border-radius: 5px; text-align: center; margin: 15px 0;">
                                    <span style="font-size: 48px;">🎬</span>
                                    <p>Cooking Video Tutorial</p>
                                </div>
                            <?php elseif ($resource['type'] == 'tutorial'): ?>
                                <div style="background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 15px 0;">
                                    <p><strong>Step-by-step guide included</strong></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="resource-footer">
                            <a href="culinary.php?download=<?php echo $resource['id']; ?>" class="download-btn">
                                Download Now
                            </a>
                            <span class="download-count" style="float: right;">
                                Downloaded <?php echo $resource['download_count']; ?> times
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <h3>No culinary resources available yet.</h3>
                <p>Check back soon for recipe cards, tutorials, and cooking videos!</p>
            </div>
        <?php endif; ?>
        
        <!-- Sample Resources (for demo purposes) -->
        <?php if (count($culinary_resources) == 0): ?>
            <div class="resource-grid">
                <!-- Sample Recipe Card -->
                <div class="resource-card">
                    <div class="resource-header">
                        <h3>Classic Italian Pasta Recipe Card</h3>
                        <span class="resource-type recipe-card">Recipe Card</span>
                        <span style="color: #fff; font-size: 14px;">• Italian</span>
                    </div>
                    <div class="resource-body">
                        <p>Beautifully designed recipe card for authentic Italian pasta. Includes ingredients, step-by-step instructions, and serving suggestions.</p>
                        <div style="text-align: center; margin: 15px 0;">
                            <span style="font-size: 48px;">🍝</span>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <a href="#" class="download-btn">Download Now</a>
                        <span class="download-count" style="float: right;">PDF • 2 MB</span>
                    </div>
                </div>
                
                <!-- Sample Tutorial -->
                <div class="resource-card">
                    <div class="resource-header">
                        <h3>Knife Skills Masterclass</h3>
                        <span class="resource-type tutorial">Tutorial</span>
                        <span style="color: #fff; font-size: 14px;">• Techniques</span>
                    </div>
                    <div class="resource-body">
                        <p>Learn essential knife skills with this comprehensive tutorial. Perfect for beginners and experienced cooks alike.</p>
                        <div style="background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 15px 0;">
                            <p><strong>Includes:</strong> Chopping, dicing, slicing techniques and safety tips</p>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <a href="#" class="download-btn">Download Now</a>
                        <span class="download-count" style="float: right;">PDF • 5 MB</span>
                    </div>
                </div>
                
                <!-- Sample Video -->
                <div class="resource-card">
                    <div class="resource-header">
                        <h3>Perfect Cake Baking</h3>
                        <span class="resource-type video">Video</span>
                        <span style="color: #fff; font-size: 14px;">• Baking</span>
                    </div>
                    <div class="resource-body">
                        <p>Video tutorial showing how to bake the perfect cake every time. Includes troubleshooting common baking problems.</p>
                        <div style="background: #f5f5f5; padding: 10px; border-radius: 5px; text-align: center; margin: 15px 0;">
                            <span style="font-size: 48px;">🎬</span>
                            <p>30-minute video tutorial</p>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <a href="#" class="download-btn">Download Now</a>
                        <span class="download-count" style="float: right;">MP4 • 250 MB</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Request Resources -->
        <div style="background: #e8f5e9; padding: 30px; border-radius: 10px; margin: 40px 0;">
            <h2>Can't find what you're looking for?</h2>
            <p>We're constantly adding new resources. Let us know what you'd like to see!</p>
            <a href="contact.php?subject=Resource Request" class="btn">Request a Resource</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>