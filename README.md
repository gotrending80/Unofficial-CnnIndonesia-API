# Unofficial Cnn Indonesia API
Currently Cnn Indonesia doesn't have any API on their site for developer like us that might be useful for testing when creating Android apps or something. That's why I created this very small library that actually scrap [CNN Indonesia Website](https://www.cnnindonesia.com) (which is only for learning purpose) and get their data.

## Dependencies
- [paquettg/php-html-parser](https://github.com/paquettg/php-html-parser)

## Methods
### Get Home Page News
Code : 
```php
<?php

$cnn            = new CnnIndonesia\Cnn;
echo $cnn->home('headline_news');
// Here's the list of news options that you can use in this method: 
// 1. headline_news
// 2. featured_news
// 3. box_news
// 4. latest_news
// 5. popular_news
```

Response : 
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
        }
    ]
}
```
### Detail
Code :
```php
<?php

$cnn            = new CnnIndonesia\Cnn;
$news_url       = 'https://www.cnnindonesia.com/nasional/20200630203110-12-519252/tim-novel-baswedan-adukan-kadiv-hukum-polri-ke-ombudsman';
$mode           = 'full';
echo $cnn->detail($news_url, $mode);
// Here's the list of mode :
// 1. default
// 2. full
```

Response : 
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
### Category List
Code : 
```php
<?php
$cnn        = new CnnIndonesia\Cnn;
echo $cnn->get_categories('full');
// Here's the list of mode :
// 1. default
// 2. full
```

Response : 
```json
{
    "status": 200,
    "type": "categories",
    "total_data": 7,
    "data": [
        {
            "url": "https://www.cnnindonesia.com/nasional",
            "name": "Nasional",
            "sub_categories": [
                {
                    "url": "https://www.cnnindonesia.com/nasional/politik",
                    "name": "Politik"
                },
                ...
            ],
            "highlights": [
                {
                    "id": 519761,
                    "title": "DPRD DKI Kritik PPDB Jakarta Jalur RW Tetap Pakai Usia",
                    "url": "https://www.cnnindonesia.com/nasional/20200701195950-20-519761/dprd-dki-kritik-ppdb-jakarta-jalur-rw-tetap-pakai-usia",
                    "image_url": "https://akcdn.detik.net.id/visual/2020/06/26/posko-ppdb-sma-negeri-70-jakarta-12_169.jpeg?q=100",
                    "category": null,
                    "created_at": "2020-07-01 19:59:50",
                    "timestamp": 20200701195950,
                    "category_id": 519
                }
            ]
        }
    ]
}
```
### Sub Category List
Code : 
```php
<?php

$cnn        = CnnIndonesia\Cnn;
echo $cnn->get_sub_categories();
```
Response : 
```json
{
    "status": 200,
    "type": "sub_categories",
    "total_data": 28,
    "data": [
        {
            "url": "https://www.cnnindonesia.com/nasional/politik",
            "name": "Politik"
        },
        {
            "url": "https://www.cnnindonesia.com/nasional/hukum-kriminal",
            "name": "Hukum & Kriminal"
        }
    ]
}
```
### Search
Code :
```php
<?php

$cnn            = new \CnnIndonesia\Cnn;

$keyword        = $_GET['keyword'];
$category       = isset($_GET['category']) ? $_GET['category'] : ''; // format ex: &category=Nasional
$date           = isset($_GET['date']) ? $_GET['date'] : ''; // format ex: &date=2020/07/06
$page           = isset($_GET['page']) ? $_GET['page'] : 1; // format ex: &page=1

echo $cnn->search($keyword, $category, $date, $page);
```

Response : 
```json
{
    "status": 200,
    "type": "search",
    "total_data": 2635,
    "current_page": 1,
    "data": [
        {
            "id": 521450,
            "title": "Kemendikbud: Pecah Rekor, 95 Persen Peserta SBMPTN Ikut UTBK",
            "url": "https://www.cnnindonesia.com/nasional/20200706160712-20-521450/kemendikbud-pecah-rekor-95-persen-peserta-sbmptn-ikut-utbk",
            "image_url": "https://akcdn.detik.net.id/visual/2020/07/05/utbk-di-unj-13_169.jpeg?q=100",
            "category": "Nasional",
            "created_at": "2020-07-06 16:07:12",
            "timestamp": 20200706160712,
            "category_id": 521
        }
    ]
}
```
#### All News
Code : 
```php
<?php

$cnn        = new \CnnIndonesia\Cnn;
$page       = isset($_GET['page']) ? $_GET['page'] : 1;
$date       = isset($_GET['date']) ? $_GET['date'] : '';

echo $cnn->allNews($page, $date);
```

Response :
```json
{
    "status": 200,
    "type": "all_news",
    "current_page": 3,
    "data": [
        {
            "id": 521575,
            "title": "Lampard Takut Chelsea Ditekel MU dari Belakang",
            "url": "https://www.cnnindonesia.com/olahraga/20200706221300-142-521575/lampard-takut-chelsea-ditekel-mu-dari-belakang",
            "image_url": "https://akcdn.detik.net.id/visual/2020/07/05/manchester-united-vs-bournemouth-di-liga-inggris-3_169.jpeg?q=100",
            "category": "Olahraga",
            "created_at": "2020-07-06 22:13:00",
            "timestamp": 20200706221300,
            "category_id": 142
        }
    ]
}
```
#### Get News By Category ID
(coming soon)
#### Get News By Sub Category ID
(coming soon)
## Installation
### Using composer
```sh
composer require rasyidcode/unofficial-cnn-indonesia-api
```

### If you don't have composer
You can download it [here](https://getcomposer.org/download/).
