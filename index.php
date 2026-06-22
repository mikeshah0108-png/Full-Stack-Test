<?php
/**
 * Main Entry Point
 * WPoets Full Stack Test - Tabbed Slider with Accordion
 */

require_once 'config/database.php';

// Fetch categories
$sql = "SELECT id, name, description FROM categories ORDER BY display_order ASC";
$result = $conn->query($sql);

if (!$result) {
    die('Query failed: ' . $conn->error);
}

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch items for first category (default)
$firstCategoryId = $categories[0]['id'] ?? null;
$items = [];

if ($firstCategoryId) {
    $sql = "SELECT id, category_id, title, description, image_url FROM items WHERE category_id = ? ORDER BY display_order ASC";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param('i', $firstCategoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WPoets Full Stack Developer Test - Tabbed Slider Interface">
    <title>WPoets Full Stack Test</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <!-- Page Header -->
            <div class="col-12 mb-5">
                <h1 class="display-4 font-weight-bold">WPoets Slider</h1>
                <p class="lead text-muted">Interactive Tabbed & Accordion Slider Interface</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Column 1: Categories (Tabs/Accordion) -->
            <div class="col-12 col-lg-3 mb-4 mb-lg-0">
                <div class="categories-container">
                    <!-- Desktop Tabs -->
                    <div class="categories-tabs d-none d-lg-flex flex-column">
                        <?php foreach ($categories as $index => $category): ?>
                            <button 
                                class="category-tab <?= $index === 0 ? 'active' : '' ?>"
                                data-category-id="<?= $category['id'] ?>"
                                data-toggle="tab"
                            >
                                <span class="category-name"><?= escape_output($category['name']) ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Mobile Accordion -->
                    <div class="categories-accordion d-lg-none" id="categoriesAccordion">
                        <?php foreach ($categories as $index => $category): ?>
                            <div class="card mb-2">
                                <div class="card-header p-0" id="heading<?= $category['id'] ?>">
                                    <button class="btn btn-link btn-block text-left p-3" type="button" data-toggle="collapse" data-target="#collapse<?= $category['id'] ?>">
                                        <span class="category-name"><?= escape_output($category['name']) ?></span>
                                        <i class="fas fa-chevron-down ml-auto"></i>
                                    </button>
                                </div>
                                <div id="collapse<?= $category['id'] ?>" class="collapse <?= $index === 0 ? 'show' : '' ?>" data-parent="#categoriesAccordion">
                                    <div class="card-body p-3 category-description">
                                        <?= escape_output($category['description']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Column 2: Slider with Controls -->
            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="slider-container">
                    <div class="slider-wrapper">
                        <div class="slider" id="mainSlider">
                            <?php foreach ($items as $item): ?>
                                <div class="slider-item" data-item-id="<?= $item['id'] ?>">
                                    <div class="slider-content">
                                        <h3><?= escape_output($item['title']) ?></h3>
                                        <p><?= escape_output($item['description']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Slider Controls -->
                    <div class="slider-controls mt-4">
                        <button class="btn btn-outline-primary slider-btn-prev" id="sliderPrev">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <span class="slider-counter" id="sliderCounter">1 / <?= count($items) ?></span>
                        <button class="btn btn-outline-primary slider-btn-next" id="sliderNext">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Slider Dots -->
                    <div class="slider-dots mt-3" id="sliderDots">
                        <?php foreach ($items as $index => $item): ?>
                            <span class="dot <?= $index === 0 ? 'active' : '' ?>" data-slide="<?= $index ?>"></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Column 3: Image Display -->
            <div class="col-12 col-lg-4">
                <div class="image-container">
                    <div class="image-wrapper">
                        <div id="imageDisplay" class="image-display">
                            <?php if (!empty($items)): ?>
                                <img src="<?= escape_output($items[0]['image_url']) ?>" alt="<?= escape_output($items[0]['title']) ?>" class="img-fluid">
                            <?php else: ?>
                                <div class="no-image">
                                    <p>No images available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="image-info mt-3">
                        <h5 id="imageTitle"><?= escape_output($items[0]['title'] ?? 'No Title') ?></h5>
                        <p id="imageDescription" class="text-muted"><?= escape_output($items[0]['description'] ?? 'No Description') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5 pt-5 border-top">
            <div class="col-12 text-center text-muted">
                <p>&copy; 2024 WPoets Full Stack Test. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>
