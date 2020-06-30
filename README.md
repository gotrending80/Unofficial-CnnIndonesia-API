# Unofficial Cnn Indonesia API
Currently Cnn Indonesia doesn't have any API on their site for developer like us that might be useful for testing when creating Android apps or something. That's why I created this very small library that actually scrap [CNN Indonesia Website](https://www.cnnindonesia.com) (which is only for learning purpose) and get their data.

## Dependencies
- [paquettg/php-html-parser](https://github.com/paquettg/php-html-parser)

### Code Example
- **Home (Main Page)**
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
//$news_part  = $_GET['news_part'];
$news_part  = 'headline_news'

echo $cnn->home($news_part);
```
Here's the list of news_part that you can use : 
  * headline_news
  * featured_news
  * box_news
  * latest_news
  * popular_news

Or you can look at ``src/CnnIndonesia/Home.php``. Below is output sample if you choose **headline_news**
```json
{
    "status": 200,
    "type": "headline_news",
    "total_data": 5,
    "data": [
        {
            "id": 519252,
            "title": "Tim Novel Baswedan Adukan Kadiv Hukum Polri ke Ombudsman",
            "url": "https://www.cnnindonesia.com/nasional/20200630203110-12-519252/tim-novel-baswedan-adukan-kadiv-hukum-polri-ke-ombudsman",
            "image_url": "https://akcdn.detik.net.id/visual/2020/06/15/penasihat-hukum-penyiram-air-keras_169.jpeg?q=100",
            "category": "Nasional",
            "created_at": "2020-06-30 20:31:10",
            "timestamp": 20200630203110,
            "category_id": 519
        },
        ...
    ]
}
```
- **Detail**
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$news_url   = $_GET['news_url'];
$mode       = isset($_GET['mode']) ? $_GET['mode'] : 'default';

echo $cnn->detail($news_url, $mode);
```
Here's the list of mode :
* default
* full
the default mode is **default** and it will only shows you the detail of that news, and if you choose **full** mode, you will see the detail + any property like in Home. here's the output if you choose full mode: 
```json
{
    "status": 200,
    "type": "detail_full",
    "data": {
        "id": 519184,
        "title": "Underpass Senen Jakarta Pusat Ditutup 30 Hari",
        "author": "CNN Indonesia",
        "category": "Nasional",
        "content": " Jakarta, CNN Indonesia -- <p>Arus lalu lintas di underpass Senen, Jakarta Pusat dari arah Cempaka Putih menuju ke arah Senen ditutup akibat proyek perpanjangan underpass mulai Selasa (30/6).</p> <p>Direktur Lalu Lintas Polda Metro Jaya Kombes Sambodo Purnomo Yogo mengatakan penutupan jalan itu akan berlangsung selama satu bulan atau 30 hari.</p> <p>\"Ditutup sementara sehubungan pekerjaan pembangunan underpass Senen extension di Simpang Senen, Jakarta Pusat,\" kata Sambodo saat dihubungi, Selasa (30/6).</p>                Lihat juga: 150 Petugas Satpol PP Akan Awasi 8 Titik CFD Jakpus Besok     <p>Selama penutupan underpass, kendaraan dialihkan untuk melintas lewat atas atau melalui rel kereta api.</p> <p>Kendati demikian, kata Sambodo, pihaknya telah menyiapkan rute alternatif lain bagi pengendara. Rute itu disiapkan agar para pengendara terhindar dari kepadatan lalu lintas di seputar Simpang Senen.</p> <p>\"Untuk mengurangi kepadatan lalu Iintas di Simpang Senen. kendaraan dari arah Timur atau Pulogadung dapat melalui jalan alternatif,\" ucap Sambodo.</p> <p>Lebih lanjut, Sambodo mengimbau kepada para pengendara untuk tetap mengikuti rambu-rambu lalu lintas dan petunjuk petugas di lapangan.</p>      Lihat juga: Pedagang Positif Corona, Pasar Minggu Tutup Sementara 3 Hari     <p>Berikut ini alternatif jalan yang disiapkan selama penutupan Underpass Senen:</p> <p>1. Arah Ancol:-Jalan Letjend Suprapto-Jalan Tanah TInggi Barat-Jalan Benyamin Sueb</p> <p>2. Arah Tugu Tani:-Jalan Kemayoran Gempol-JalanGaruda-Jalan Bungur Raya-Jalan Gunung Sahari 3-Jalan Gunung Sahari-Jalan Budi Utomo</p> <p>3. Arah Matraman:-Jalan Salemba Raya</p> (dis/ugo)  [Gambas:Video CNN]  ",
        "image_url": "https://akcdn.detik.net.id/visual/2020/05/03/43192e11-3bfc-4d17-9f32-7338e8296251_169.jpeg?q=100",
        "image_text": "Pekerja menyelesaikan proyek pembangunan underpass Senen Extension di kawasan Senen, Jakarta. (ANTARA FOTO/M Risyal Hidayat)",
        "sub_category": "Berita Peristiwa",
        "published_date": "Selasa, 30/06/2020 19:18 WIB",
        "created_at": "2020-06-30 18:47:38",
        "timestamp": 20200630184738,
        "category_id": 519,
        "url": "https://www.cnnindonesia.com/nasional/20200630184738-20-519184/underpass-senen-jakarta-pusat-ditutup-30-hari"
    }
}
```
- **Search**
(coming soon)
- **Category List**
(coming soon)
- **Sub Category List**
(coming soon)
- **All News**
(coming soon)
- **Get News By Category ID**
(coming soon)
- **Get News By Sub Category ID**
(coming soon)
## Installation
### Using composer
```sh
composer require rasyidcode/unofficial-cnn-indonesia-api
```

### If you don't have composer
You can download it [here](https://getcomposer.org/download/).