<?php

$fp = fopen('C:/Users/rikib/.gemini/antigravity/brain/8c28fd96-b07c-44a5-b5be-33fde39d784c/.system_generated/logs/transcript.jsonl', 'r');
$idx = 0;
while (($line = fgets($fp)) !== false) {
    if (strpos($line, 'resources/css/app.css') !== false || strpos($line, 'resources\\\\css\\\\app.css') !== false) {
        $json = json_decode($line, true);
        echo "Step {$json['step_index']}: " . ($json['type'] ?? '') . "\n";
        if (isset($json['content'])) {
            echo "  Content preview: " . substr($json['content'], 0, 100) . "\n";
        }
    }
    $idx++;
}
fclose($fp);

