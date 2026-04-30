<?php
// waf.php - Web Application Firewall semplice ma funzionale per il lab

class WebWAF {
    public function scan_request() {
        $inputs = array_merge($_GET, $_POST);
        $threats = [];

        $sqli_patterns = [
            '/\b(union|select|insert|update|delete|drop)\b/i',
            '/(--|#|;)/',
            '/(or|and)\s+1=1/i',
            '/1=1/i'
        ];

        foreach ($inputs as $value) {
            if (empty($value) || !is_string($value)) continue;
            
            foreach ($sqli_patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    $threats[] = "SQLi rilevato";
                }
            }
        }

        return ['block' => count($threats) > 0, 'threats' => $threats];
    }
}

// Attiva WAF solo sulle richieste POST (per non bloccare il caricamento delle pagine)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waf = new WebWAF();
    $scan = $waf->scan_request();
    
    if ($scan['block']) {
        file_put_contents('waf_log.txt', date('Y-m-d H:i:s') . " - BLOCKED\n", FILE_APPEND);
        die('🚨 ATTACCO BLOCCATO DAL WAF!');
    }
}
?>