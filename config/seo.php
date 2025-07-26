<?php
// SEO Configuration
class SEO {
    private $title;
    private $description;
    private $keywords;
    private $canonical;
    private $robots;
    private $ogTags;

    public function __construct() {
        $this->title = '';
        $this->description = '';
        $this->keywords = '';
        $this->canonical = '';
        $this->robots = 'index, follow';
        $this->ogTags = [];
    }

    // Set page title
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    // Set meta description
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    // Set meta keywords
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
        return $this;
    }

    // Set canonical URL
    public function setCanonical($url) {
        $this->canonical = $url;
        return $this;
    }

    // Set robots meta tag
    public function setRobots($robots) {
        $this->robots = $robots;
        return $this;
    }

    // Add Open Graph tag
    public function addOGTag($property, $content) {
        $this->ogTags[$property] = $content;
        return $this;
    }

    // Generate meta tags
    public function generateMetaTags() {
        $tags = [];

        // Title tag
        if ($this->title) {
            $tags[] = "<title>" . htmlspecialchars($this->title) . " | College Finder</title>";
        }

        // Meta description
        if ($this->description) {
            $tags[] = '<meta name="description" content="' . htmlspecialchars($this->description) . '">';
        }

        // Meta keywords
        if ($this->keywords) {
            $tags[] = '<meta name="keywords" content="' . htmlspecialchars($this->keywords) . '">';
        }

        // Canonical URL
        if ($this->canonical) {
            $tags[] = '<link rel="canonical" href="' . htmlspecialchars($this->canonical) . '">';
        }

        // Robots meta tag
        $tags[] = '<meta name="robots" content="' . htmlspecialchars($this->robots) . '">';

        // Open Graph tags
        foreach ($this->ogTags as $property => $content) {
            $tags[] = '<meta property="og:' . htmlspecialchars($property) . '" content="' . htmlspecialchars($content) . '">';
        }

        return implode("\n    ", $tags);
    }

    // Generate sitemap
    public static function generateSitemap($pages) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($page['url']) . "</loc>\n";
            if (isset($page['lastmod'])) {
                $xml .= "    <lastmod>" . htmlspecialchars($page['lastmod']) . "</lastmod>\n";
            }
            if (isset($page['changefreq'])) {
                $xml .= "    <changefreq>" . htmlspecialchars($page['changefreq']) . "</changefreq>\n";
            }
            if (isset($page['priority'])) {
                $xml .= "    <priority>" . htmlspecialchars($page['priority']) . "</priority>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        return $xml;
    }

    // Generate robots.txt
    public static function generateRobotsTxt($sitemapUrl) {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /config/\n";
        $content .= "Sitemap: " . $sitemapUrl . "\n";
        return $content;
    }

    // Optimize image alt text
    public static function optimizeImageAlt($imageName, $context = '') {
        $alt = str_replace(['-', '_'], ' ', $imageName);
        $alt = ucwords($alt);
        if ($context) {
            $alt .= ' - ' . $context;
        }
        return $alt;
    }

    // Generate structured data
    public static function generateStructuredData($type, $data) {
        $json = [
            '@context' => 'https://schema.org',
            '@type' => $type
        ];

        foreach ($data as $key => $value) {
            $json[$key] = $value;
        }

        return '<script type="application/ld+json">' . json_encode($json) . '</script>';
    }
}

// Example usage:
/*
$seo = new SEO();
$seo->setTitle('Top Engineering Colleges in India')
    ->setDescription('Find the best engineering colleges in India with detailed information about courses, fees, and rankings.')
    ->setKeywords('engineering colleges, top colleges, India education, engineering courses')
    ->setCanonical('https://collegefinder.com/top-engineering-colleges')
    ->addOGTag('title', 'Top Engineering Colleges in India')
    ->addOGTag('description', 'Find the best engineering colleges in India')
    ->addOGTag('image', 'https://collegefinder.com/images/engineering-colleges.jpg');

echo $seo->generateMetaTags();
*/
?> 