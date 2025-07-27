<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatCustomerController extends Controller
{

    /**
     * Mengambil data provinsi dari API RajaOngkir dengan penanganan error.
     * @return array
     */
    public function get_provinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 6nPSFGOI0ca8b6115e87b680ziajHDJL" // Ganti dengan API Key Anda yang valid
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            // Jika ada error cURL (misal: tidak ada koneksi), kembalikan array kosong
            return [];
        }

        $response = json_decode($response, true);

        // Memeriksa apakah respons API sukses (kode status 200)
        if (isset($response['rajaongkir']['status']['code']) && $response['rajaongkir']['status']['code'] == 200) {
            // Jika sukses, kembalikan data 'results'
            return $response['rajaongkir']['results'];
        }

        // Jika API mengembalikan error atau formatnya tidak sesuai, kembalikan array kosong
        return [];
    }

    /**
     * Mengambil data kota dari API RajaOngkir dengan penanganan error.
     * @return array
     */
    public function get_city()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=jakarta&limit=5&offset=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 6nPSFGOI0ca8b6115e87b680ziajHDJL" // Ganti dengan API Key Anda yang valid
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            // Jika ada error cURL, kembalikan array kosong
            return [];
        }

        $response = json_decode($response, true);

        // Memeriksa apakah respons API sukses (kode status 200)
        if (isset($response['rajaongkir']['status']['code']) && $response['rajaongkir']['status']['code'] == 200) {
            // Jika sukses, kembalikan data 'results'
            return $response['rajaongkir']['results'];
        }

        // Jika gagal, kembalikan array kosong
        return [];
    }

    /**
     * Menampilkan halaman form alamat checkout.
     */
    public function create_checkout($id)
    {
        $id_keranjang = $id;
        $provinsi = $this->get_provinsi();
        $city = $this->get_city(); // Anda mungkin ingin city ini dinamis berdasarkan provinsi
        return view('customer.alamat.alamat_checkout', compact(['id_keranjang', 'provinsi', 'city']));
    }

    /**
     * Menyimpan data alamat baru dari halaman checkout.
     */
    public function store_alamat_checkout(Request $request)
    {
        $id_keranjang = $request->id_keranjang;
        $alamatCount = Alamat::where('id_user', Auth::user()->id)->count();

        if ($alamatCount >= 3) {
            return to_route('keranjang.show', $id_keranjang)->with('error', 'Kapasitas pengisian alamat maksimal hanya 3.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'telp' => 'required|string|max:15',
            'pos' => 'required|string|max:10',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $provinsi_result = explode('|', $request->provinsi);
        $id_provinsi = $provinsi_result[0] ?? null;
        $nama_provinsi = $provinsi_result[1] ?? null;

        $kota_result = explode('|', $request->kota);
        $id_kota = $kota_result[0] ?? null;
        $nama_kota = $kota_result[1] ?? null;

        // Validasi tambahan untuk memastikan format provinsi dan kota benar
        if (!$id_provinsi || !$id_kota) {
             return to_route('keranjang.show', $id_keranjang)->with('error', 'Data provinsi atau kota tidak valid.');
        }

        Alamat::create([
            'id_user' => Auth::user()->id,
            'no_telp' => $request->telp,
            'nama_penerima' => $request->nama,
            'id_provinsi' => $id_provinsi,
            'nama_prov' => $nama_provinsi,
            'id_kota' => $id_kota,
            'nama_kota' => $nama_kota,
            'kode_pos' => $request->pos,
            'alamat' => $request->alamat,
        ]);

        return to_route('keranjang.show', $id_keranjang)->with('success', 'Berhasil menambahkan alamat pengiriman.');
    }
}