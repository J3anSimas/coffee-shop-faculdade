<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <?php
    if (!empty($head_styles) && is_array($head_styles)) {
        foreach ($head_styles as $style) {
            echo "<link rel='stylesheet' href='css/$style'>";
        }
    }
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&family=Inter:wght@300;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?php
    $title = null;
    if (!empty($head_title)) {
        $title = 'Simas Café | ' . $head_title;
    } else {
        $title = 'Simas Café';
    }
    ?>
    <title><?php echo $title ?></title>
</head>