<?php declare(strict_types=1);

/**
 * Returns the current COLOR_INDEX and increments it cyclically.
 * Stored in session.
 */
function getNextColorIndex(int $max): int
{
    if (!isset($_SESSION['COLOR_INDEX'])) {
        $_SESSION['COLOR_INDEX'] = 0;
    }
    $current = $_SESSION['COLOR_INDEX'];
    $_SESSION['COLOR_INDEX'] = ($current + 1) % $max;
    return $current;
}

/**
 * Outputs CSS rules for elements with nth-child coloring based on a color palette.
 * $count = number of elements to color,
 * $selector = CSS selector to apply nth-child on,
 * $boxShadow = if true, include box-shadow property.
 */
function outputColorCSS(int $count, string $selector, bool $boxShadow = true): void
{
    $rainbow_colors = ['var(--red)', 'var(--orange)', 'var(--yellow)', 'var(--green)', 'var(--cyan)', 'var(--blue)', 'var(--purple)'];
    for ($i = 1; $i <= $count; $i++) {
        $color = $rainbow_colors[getNextColorIndex(count($rainbow_colors))];
        echo "$selector:nth-child($i) { background-color: $color;";
        if ($boxShadow)
            echo " box-shadow: $color;";
        echo "}\n";
        if ($boxShadow) {
            echo "$selector:nth-child($i):hover { box-shadow: 0 0 20px $color; }\n";
        }
    }
}

/**
 * Outputs responsive flex styles based on number of items.
 */
function outputResponsiveFlexCSS(int $count): void
{
    $basis = $count < 3 ? '50%' : '33.33%';
    echo "@media (min-width: 768px) {
        section a {
            flex: 1 1 calc($basis - 20px);
            max-width: calc($basis - 20px);
        }
    }";
}
