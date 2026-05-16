<?php
// Hata raporlamayı açarak olası eksiklikleri görmeyi sağlar
error_reporting(E_ALL);
ini_set('display_errors', 1);

// index.html formundan POST verisi gelip gelmediğini kontrol eder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'])) {
    
    // Girilen numarayı filtreleyip temizler
    $raw_phone = trim($_POST['phone']);
    $phone = preg_replace('/[^0-9]/', '', $raw_phone);

    // Numara geçerlilik kontrolü (10 haneli olmalı)
    if (strlen($phone) === 10) {
        
        // Attığın paketteki utils.php dosyasının varlığını kontrol eder ve dahil eder
        $utils_path = __DIR__ . "/spammers/utils.php";
        
        if (file_exists($utils_path)) {
            include_once($utils_path);
            
            // Bağlantı Başarılı Log çıktısı
            echo "<div style='background:#050a0e; color:#00ff66; font-family:monospace; padding:20px; border:1px solid #00ff66; margin:20px; border-radius:8px;'>";
            echo "<h3>[BAŞARILI] SMS Gönderim İşlemi Başlatıldı</h3>";
            echo "<p>Hedef Numara: +90 " . htmlspecialchars($phone) . "</p>";
            echo "<p>Durum: spammers/utils.php tetiklendi.</p>";
            echo "<br><a href='index.html' style='color:#00e5ff; text-decoration:none;'>← Panele Geri Dön</a>";
            echo "</div>";
            
        } else {
            // Klasör yolu hatası senaryosu
            echo "<div style='background:#050a0e; color:#ff5f56; font-family:monospace; padding:20px; border:1px solid #ff5f56; margin:20px; border-radius:8px;'>";
            echo "<h3>[HATA] Altyapı Dosyası Bulunamadı</h3>";
            echo "<p>Gerekli olan 'spammers/utils.php' dosyası sunucuda mevcut değil.</p>";
            echo "</div>";
        }

    } else {
        echo "[HATA] Lütfen telefon numarasını başında sıfır olmadan 10 hane olarak girin.";
    }

} else {
    // Doğrudan URL'den sms.php'ye erişilmek istendiğinde index.html'e yönlendirir
    header("Location: index.html");
    exit;
}
?>