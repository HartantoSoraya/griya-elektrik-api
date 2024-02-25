<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    protected $model = ProductCategory::class;

    protected $productCategories = [
        'Elektronik' => [
            'Televisi' => ['LED', 'Plasma', 'LCD'],
            'Laptop' => ['Notebook', 'Ultrabook', 'Chromebook'],
            'Smartphone' => ['Android', 'iOS', 'Windows Phone'],
        ],
        'Pakaian' => [
            'Pria' => ['Kemeja', 'Celana', 'Jaket'],
            'Wanita' => ['Blouse', 'Rok', 'Dress'],
            'Anak-anak' => ['Baju Anak', 'Celana Anak', 'Jaket Anak'],
        ],
        'Alat Masak' => [
            'Peralatan Masak' => ['Panci', 'Wajan', 'Rice Cooker'],
            'Peralatan Makan' => ['Piring', 'Gelas', 'Sendok Garpu'],
            'Peralatan Minum' => ['Termos', 'Botol Minum', 'Gelas Minum'],
        ],
        'Olahraga' => [
            'Sepatu' => ['Sepatu Lari', 'Sepatu Basket', 'Sepatu Futsal'],
            'Bola' => ['Bola Sepak', 'Bola Basket', 'Bola Voli'],
            'Pakaian Olahraga' => ['Jersey', 'Celana Pendek', 'Kaos Kaki'],
        ],
        'Mainan' => [
            'Edukasi' => ['Puzzle', 'Mainan Bangun-Bangun', 'Mainan Pendidikan'],
            'Boneka' => ['Boneka Barbie', 'Boneka Teddy Bear', 'Boneka Karakter'],
            'Kendaraan' => ['Mobil Remote Control', 'Pesawat Remote Control', 'Kereta Api Mainan'],
        ],
        'Makanan' => [
            'Makanan Ringan' => ['Keripik', 'Kacang', 'Permen'],
            'Makanan Berat' => ['Nasi Goreng', 'Ayam Goreng', 'Sop'],
            'Minuman' => ['Air Mineral', 'Jus Buah', 'Soda'],
        ],
        'Furniture' => [
            'Sofa' => ['Sofa 3-Seater', 'Sofa Bed', 'Sofa Recliner'],
            'Meja' => ['Meja Makan', 'Meja Kerja', 'Meja Konsol'],
            'Kursi' => ['Kursi Makan', 'Kursi Sofa', 'Kursi Lipat'],
        ],
        'Kesehatan' => [
            'Suplemen' => ['Vitamin C', 'Kalsium', 'Omega 3'],
            'Obat' => ['Parasetamol', 'Antibiotik', 'Vitamin B12'],
            'Alat Kesehatan' => ['Termometer', 'Alat Pemeriksa Tekanan Darah', 'Nebulizer'],
        ],
        'Kendaraan' => [
            'Mobil' => ['Sedan', 'SUV', 'Hatchback'],
            'Motor' => ['Matic', 'Manual', 'Sport'],
            'Sepeda' => ['Sepeda Gunung', 'Sepeda Balap', 'Sepeda Lipat'],
        ],
        'Perabotan Rumah Tangga' => [
            'Lemari' => ['Lemari Pakaian', 'Lemari Buku', 'Lemari TV'],
            'Rak' => ['Rak Buku', 'Rak Sepatu', 'Rak TV'],
            'Keranjang' => ['Keranjang Laundry', 'Keranjang Buah', 'Keranjang Mainan'],
        ],
        'Hewan Peliharaan' => [
            'Anjing' => ['Golden Retriever', 'Labrador Retriever', 'Chihuahua'],
            'Kucing' => ['Persia', 'Anggora', 'Maine Coon'],
            'Burung' => ['Lovebird', 'Parkit', 'Kakatua'],
        ],
        'Perhiasan' => [
            'Cincin' => ['Emas', 'Perak', 'Berlian'],
            'Kalung' => ['Mutia', 'Topaz', 'Ruby'],
            'Gelang' => ['Gelang Emas', 'Gelang Perak', 'Gelang Berlian'],
        ],
    ];

    public function definition(): array
    {
        $productCategories = $this->flattenArray($this->productCategories);

        $code = Str::upper(Str::random(10));
        $name = $productCategories[array_rand($productCategories)];

        return [
            'code' => $code,
            'name' => $name,
            'image' => UploadedFile::fake()->image('image.jpg'),
            'slug' => Str::slug($name.'-'.$code),
        ];
    }

    public function getProductCategoryExample(): array
    {
        $category = array_rand($this->productCategories);
        $subCategory = array_rand($this->productCategories[$category]);
        $item = $this->productCategories[$category][$subCategory][array_rand($this->productCategories[$category][$subCategory])];

        $result = [];
        array_push($result, $category);
        array_push($result, $subCategory);
        array_push($result, $item);

        return $result;
    }

    public function flattenArray($array)
    {
        $result = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value));
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }

    public function setName(string $str)
    {
        return $this->state(function (array $attributes) use ($str) {
            return [
                'name' => $str,
            ];
        });
    }
}
